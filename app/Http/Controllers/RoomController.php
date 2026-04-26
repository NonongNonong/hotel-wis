<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%')
                  ->orWhere('room_type', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->latest()->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number'  => 'required|string|unique:rooms,room_number',
            'room_type'    => 'required|string',
            'capacity'     => 'required|integer|min:1',
            'base_rate'    => 'required|numeric|min:0',
            'status'       => 'required|string',
            'room_details' => 'nullable|string',
        ]);

        Room::create(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('rooms.index')
                         ->with('success', 'Room added successfully.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number'  => 'required|string|unique:rooms,room_number,' . $room->id,
            'room_type'    => 'required|string',
            'capacity'     => 'required|integer|min:1',
            'base_rate'    => 'required|numeric|min:0',
            'status'       => 'required|string',
            'room_details' => 'nullable|string',
        ]);

        $room->update(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('rooms.index')
                         ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')
                         ->with('success', 'Room deleted successfully.');
    }
}