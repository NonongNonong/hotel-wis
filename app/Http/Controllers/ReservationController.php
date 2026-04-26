<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['guest', 'room']);

        if ($request->filled('search')) {
            $query->whereHas('guest', function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('email_add', 'like', '%' . $request->search . '%');
            })->orWhereHas('room', function($q) use ($request) {
                $q->where('room_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->latest()->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $guests = Guest::orderBy('lname')->get();
        $rooms  = Room::where('status', 'Available')->orderBy('room_number')->get();
        return view('reservations.create', compact('guests', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_id'       => 'required|exists:guests,id',
            'room_id'        => 'required|exists:rooms,id',
            'check_in_date'  => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'status'         => 'required|string',
        ]);

        // Check for overlapping reservations on the same room
        $overlap = Reservation::where('room_id', $request->room_id)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->where(function($q) use ($request) {
                $q->whereBetween('check_in_date',  [$request->check_in_date, $request->check_out_date])
                  ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date]);
            })->exists();

        if ($overlap) {
            return back()->withInput()
                         ->with('error', 'This room is already reserved for the selected dates.');
        }

        // Compute base room cost
        $room      = Room::findOrFail($request->room_id);
        $checkIn   = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut  = \Carbon\Carbon::parse($request->check_out_date);
        $nights    = $checkIn->diffInDays($checkOut);
        $baseCost  = $room->base_rate * $nights;

        Reservation::create([
            'guest_id'       => $request->guest_id,
            'room_id'        => $request->room_id,
            'check_in_date'  => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status'         => $request->status,
            'base_room_cost' => $baseCost,
            'created_by'     => auth()->user()->name,
        ]);

        // Mark room as Reserved
        $room->update(['status' => 'Reserved']);

        return redirect()->route('reservations.index')
                         ->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['guest', 'room']);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $guests = Guest::orderBy('lname')->get();
        $rooms  = Room::orderBy('room_number')->get();
        return view('reservations.edit', compact('reservation', 'guests', 'rooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'guest_id'       => 'required|exists:guests,id',
            'room_id'        => 'required|exists:rooms,id',
            'check_in_date'  => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status'         => 'required|string',
        ]);

        // Recompute cost
        $room     = Room::findOrFail($request->room_id);
        $nights   = \Carbon\Carbon::parse($request->check_in_date)
                        ->diffInDays(\Carbon\Carbon::parse($request->check_out_date));
        $baseCost = $room->base_rate * $nights;

        $reservation->update([
            'guest_id'       => $request->guest_id,
            'room_id'        => $request->room_id,
            'check_in_date'  => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status'         => $request->status,
            'base_room_cost' => $baseCost,
        ]);

        return redirect()->route('reservations.index')
                         ->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        // Free up the room when reservation is cancelled
        $room = Room::findOrFail($reservation->room_id);
        $room->update(['status' => 'Available']);

        $reservation->delete();
        return redirect()->route('reservations.index')
                         ->with('success', 'Reservation deleted successfully.');
    }
}