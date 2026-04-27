<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\ServiceRequest;
use App\Models\FacilityBooking;
use App\Models\Service;
use App\Models\Facility;
use Illuminate\Http\Request;

class GuestPortalController extends Controller
{
    private function getGuest()
{
    $guest = auth()->user()->guestProfile;

    if (!$guest) {
        abort(403, 'No guest profile linked to this account. Please contact the front desk.');
    }

    return $guest;
}

    public function dashboard()
    {
        $guest = $this->getGuest();

        $totalReservations  = Reservation::where('guest_id', $guest->id)->count();
        $activeReservations = Reservation::where('guest_id', $guest->id)
                                ->whereIn('status', ['Confirmed', 'Pending', 'Checked-in'])
                                ->count();
        $pendingServices    = ServiceRequest::where('guest_id', $guest->id)
                                ->whereNotIn('status', ['Completed'])
                                ->count();
        $totalFacilities    = FacilityBooking::where('guest_id', $guest->id)->count();

        return view('guest-portal.dashboard', compact(
            'guest', 'totalReservations', 'activeReservations',
            'pendingServices', 'totalFacilities'
        ));
    }

    public function reservations()
    {
        $guest        = $this->getGuest();
        $reservations = Reservation::with('room')
                            ->where('guest_id', $guest->id)
                            ->latest()->paginate(10);

        return view('guest-portal.reservations', compact('guest', 'reservations'));
    }

    public function createReservation()
    {
        $guest = $this->getGuest();
        $rooms = Room::where('status', 'Available')->orderBy('room_number')->get();

        return view('guest-portal.create-reservation', compact('guest', 'rooms'));
    }

    public function storeReservation(Request $request)
    {
        $guest = $this->getGuest();

        $request->validate([
            'room_id'        => ['required', 'exists:rooms,id'],
            'check_in_date'  => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ]);

        $room   = Room::findOrFail($request->room_id);
        $nights = \Carbon\Carbon::parse($request->check_in_date)
                      ->diffInDays($request->check_out_date);
        $cost   = $room->base_rate * $nights;

        Reservation::create([
            'guest_id'       => $guest->id,
            'room_id'        => $room->id,
            'check_in_date'  => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status'         => 'Pending',
            'base_room_cost' => $cost,
            'created_by'     => auth()->user()->name,
        ]);

        return redirect()->route('guest.reservations')
                         ->with('success', 'Reservation submitted! We will confirm it shortly.');
    }

    public function serviceRequests()
    {
        $guest    = $this->getGuest();
        $requests = ServiceRequest::with(['service', 'room', 'employee'])
                        ->where('guest_id', $guest->id)
                        ->latest()->paginate(10);
        $services = Service::where('availability', 'Available')->get();

        // Get active reservation for this guest
        $activeReservation = Reservation::where('guest_id', $guest->id)
                                ->where('status', 'Checked-in')
                                ->first();

        return view('guest-portal.service-requests',
            compact('guest', 'requests', 'services', 'activeReservation'));
    }

    public function storeServiceRequest(Request $request)
    {
        $guest = $this->getGuest();

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity'   => 'required|integer|min:1',
            'special_instructions' => 'nullable|string',
        ]);

        $activeReservation = Reservation::where('guest_id', $guest->id)
                                ->where('status', 'Checked-in')
                                ->first();

        if (!$activeReservation) {
            return back()->with('error', 'You must be checked in to request a service.');
        }

        $service   = \App\Models\Service::findOrFail($request->service_id);
        $totalCost = $service->price * $request->quantity;

        ServiceRequest::create([
            'guest_id'             => $guest->id,
            'reservation_id'       => $activeReservation->id,
            'room_id'              => $activeReservation->room_id,
            'service_id'           => $request->service_id,
            'quantity'             => $request->quantity,
            'special_instructions' => $request->special_instructions,
            'status'               => 'Pending',
            'total_cost'           => $totalCost,
            'last_update_by'       => auth()->user()->name,
        ]);

        return redirect()->route('guest.service-requests')
                         ->with('success', 'Service request submitted successfully.');
    }

    public function facilityBookings()
    {
        $guest      = $this->getGuest();
        $bookings   = FacilityBooking::with('facility')
                          ->where('guest_id', $guest->id)
                          ->latest()->paginate(10);
        $facilities = Facility::where('status', 'Available')
                          ->where('reservable', true)
                          ->get();

        $activeReservation = Reservation::where('guest_id', $guest->id)
                                ->whereIn('status', ['Confirmed', 'Checked-in'])
                                ->first();

        return view('guest-portal.facility-bookings',
            compact('guest', 'bookings', 'facilities', 'activeReservation'));
    }

    public function storeFacilityBooking(Request $request)
    {
        $guest = $this->getGuest();

        $request->validate([
            'facility_id'   => 'required|exists:facilities,id',
            'booking_start' => 'required|date|after_or_equal:now',
            'booking_end'   => 'required|date|after:booking_start',
        ]);

        $facility  = Facility::findOrFail($request->facility_id);
        $start     = \Carbon\Carbon::parse($request->booking_start);
        $end       = \Carbon\Carbon::parse($request->booking_end);
        $hours     = max(1, $start->diffInHours($end));
        $totalCost = $facility->need_payment ? $facility->price * $hours : 0;

        $activeReservation = Reservation::where('guest_id', $guest->id)
                                ->whereIn('status', ['Confirmed', 'Checked-in'])
                                ->first();

        FacilityBooking::create([
            'guest_id'       => $guest->id,
            'facility_id'    => $request->facility_id,
            'reservation_id' => $activeReservation?->id,
            'booking_start'  => $request->booking_start,
            'booking_end'    => $request->booking_end,
            'status'         => 'Pending',
            'total_cost'     => $totalCost,
            'last_update_by' => auth()->user()->name,
        ]);

        return redirect()->route('guest.facility-bookings')
                         ->with('success', 'Facility booking submitted successfully.');
    }
}