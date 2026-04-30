<?php

namespace App\Http\Controllers;

use App\Models\FacilityBooking;
use App\Models\Facility;
use App\Models\Guest;
use App\Models\Reservation;
use Illuminate\Http\Request;

class FacilityBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = FacilityBooking::with(['guest', 'facility', 'reservation']);

        if ($request->filled('search')) {
            $query->whereHas('guest', function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%');
            })->orWhereHas('facility', function($q) use ($request) {
                $q->where('facility_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);
        return view('facilitybookings.index', compact('bookings'));
    }

    public function create()
    {
        $facilities   = Facility::where('status', 'Available')
                                ->where('reservable', true)
                                ->get();
        $reservations = Reservation::with(['guest', 'room'])
                                   ->whereIn('status', ['Confirmed', 'Checked-in'])
                                   ->get();
        $guests = Guest::orderBy('lname')->get();
        return view('facilitybookings.create', compact('facilities', 'reservations', 'guests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id'    => 'required|exists:facilities,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'guest_id'       => 'required_without:reservation_id|nullable|exists:guests,id',
            'booking_start'  => 'required|date',
            'booking_end'    => 'required|date|after:booking_start',
            'status'         => 'required|string',
        ]);

        $facility = Facility::findOrFail($request->facility_id);

        // Compute total cost based on hours
        $start     = \Carbon\Carbon::parse($request->booking_start);
        $end       = \Carbon\Carbon::parse($request->booking_end);
        $hours     = max(1, $start->diffInHours($end));
        $totalCost = $facility->need_payment ? $facility->price * $hours : 0;

        // Derive guest_id from reservation, or fall back to direct guest selection
        $guestId = null;
        if ($request->reservation_id) {
            $guestId = Reservation::findOrFail($request->reservation_id)->guest_id;
        } elseif ($request->guest_id) {
            $guestId = $request->guest_id;
        }

        // Check for overlapping bookings: existing.start < new.end AND existing.end > new.start
        $overlap = FacilityBooking::where('facility_id', $request->facility_id)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->where('booking_start', '<', $request->booking_end)
            ->where('booking_end',   '>',  $request->booking_start)
            ->exists();

        if ($overlap) {
            return back()->withInput()
                         ->with('error', 'This facility is already booked for the selected time slot.');
        }

        FacilityBooking::create([
            'guest_id'       => $guestId,
            'facility_id'    => $request->facility_id,
            'reservation_id' => $request->reservation_id,
            'booking_start'  => $request->booking_start,
            'booking_end'    => $request->booking_end,
            'status'         => $request->status,
            'total_cost'     => $totalCost,
            'last_update_by' => auth()->user()->name,
        ]);

        return redirect()->route('facilitybookings.index')
                         ->with('success', 'Facility booking created successfully.');
    }

    public function show(FacilityBooking $facilitybooking)
    {
        $facilitybooking->load(['guest', 'facility', 'reservation']);
        return view('facilitybookings.show', compact('facilitybooking'));
    }

    public function edit(FacilityBooking $facilitybooking)
    {
        $facilities   = Facility::orderBy('facility_name')->get();
        $reservations = Reservation::with(['guest', 'room'])
                                   ->whereIn('status', ['Confirmed', 'Checked-in'])
                                   ->get();
        return view('facilitybookings.edit',
            compact('facilitybooking', 'facilities', 'reservations'));
    }

    public function update(Request $request, FacilityBooking $facilitybooking)
    {
        $request->validate([
            'booking_start' => 'required|date',
            'booking_end'   => 'required|date|after:booking_start',
            'status'        => 'required|string',
            'rating'        => 'nullable|integer|min:1|max:5',
        ]);

        $facility  = Facility::findOrFail($facilitybooking->facility_id);
        $start     = \Carbon\Carbon::parse($request->booking_start);
        $end       = \Carbon\Carbon::parse($request->booking_end);
        $hours     = max(1, $start->diffInHours($end));
        $totalCost = $facility->need_payment ? $facility->price * $hours : 0;

        $facilitybooking->update([
            'booking_start'  => $request->booking_start,
            'booking_end'    => $request->booking_end,
            'status'         => $request->status,
            'total_cost'     => $totalCost,
            'rating'         => $request->rating,
            'last_update_by' => auth()->user()->name,
        ]);

        return redirect()->route('facilitybookings.index')
                         ->with('success', 'Facility booking updated successfully.');
    }

    public function destroy(FacilityBooking $facilitybooking)
    {
        $facilitybooking->delete();
        return redirect()->route('facilitybookings.index')
                         ->with('success', 'Facility booking deleted successfully.');
    }
}