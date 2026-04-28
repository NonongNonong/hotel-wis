<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\FacilityBooking;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class CheckInOutController extends Controller
{
    public function index(Request $request)
    {
        $query = CheckInOut::with(['guest', 'room', 'reservation']);

        if ($request->filled('search')) {
            $query->whereHas('guest', function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%');
            })->orWhereHas('room', function($q) use ($request) {
                $q->where('room_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->latest()->paginate(10);
        return view('checkinout.index', compact('records'));
    }

    public function create()
    {
        // Only show Confirmed or Pending reservations
        // that don't have an active check-in yet
        $reservations = Reservation::with(['guest', 'room'])
            ->whereIn('status', ['Confirmed', 'Pending'])
            ->whereDoesntHave('checkInOut', function($q) {
                $q->where('status', 'Checked-in');
            })
            ->get();

        return view('checkinout.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::with(['guest', 'room'])->findOrFail($request->reservation_id);

        // Create check-in record
        CheckInOut::create([
            'reservation_id'  => $reservation->id,
            'guest_id'        => $reservation->guest_id,
            'room_id'         => $reservation->room_id,
            'actual_check_in' => now(),
            'status'          => 'Checked-in',
            'total_amount'    => $reservation->base_room_cost,
            'last_update_by'  => auth()->user()->name,
        ]);

        // Update reservation and room status
        $reservation->update(['status' => 'Checked-in']);
        Room::findOrFail($reservation->room_id)->update(['status' => 'Occupied']);

        return redirect()->route('checkinout.index')
                         ->with('success', 'Guest checked in successfully.');
    }

    public function show(CheckInOut $checkinout)
    {
        $checkinout->load(['guest', 'room', 'reservation']);

        $serviceRequests = ServiceRequest::with(['service', 'employee'])
            ->where('reservation_id', $checkinout->reservation_id)
            ->get();

        $facilityBookings = FacilityBooking::with(['facility'])
            ->where('reservation_id', $checkinout->reservation_id)
            ->get();

        return view('checkinout.show', compact('checkinout', 'serviceRequests', 'facilityBookings'));
    }

    public function checkout(Request $request, CheckInOut $checkinout)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $checkinout->load(['reservation', 'room']);

        // Compute total amount
        $checkIn   = \Carbon\Carbon::parse($checkinout->actual_check_in);
        $checkOut  = now();
        $nights    = max(1, $checkIn->diffInDays($checkOut));
        $roomCost  = $checkinout->room->base_rate * $nights;
        $total     = $roomCost;

        // Update check-in/out record
        $checkinout->update([
            'actual_check_out' => $checkOut,
            'status'           => 'Checked-out',
            'total_amount'     => $total,
            'payment_method'   => $request->payment_method,
            'last_update_by'   => auth()->user()->name,
        ]);

        // Update reservation and room status
        $checkinout->reservation->update(['status' => 'Completed']);
        Room::findOrFail($checkinout->room_id)->update(['status' => 'Available']);

        // Auto-complete open service requests and facility bookings for this reservation
        ServiceRequest::where('reservation_id', $checkinout->reservation_id)
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->update([
                'status'         => 'Completed',
                'last_update_by' => auth()->user()->name,
            ]);

        FacilityBooking::where('reservation_id', $checkinout->reservation_id)
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->update([
                'status'         => 'Completed',
                'last_update_by' => auth()->user()->name,
            ]);

        return redirect()->route('checkinout.index')
                         ->with('success', 'Guest checked out successfully.');
    }
}