<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $query = Guest::query();

        if ($request->filled('search')) {
            $query->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('email_add', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile_num', 'like', '%' . $request->search . '%');
        }

        $guests = $query->latest()->paginate(10);
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname'      => 'required|string|max:255',
            'lname'      => 'required|string|max:255',
            'mobile_num' => 'required|string|unique:guests,mobile_num',
            'email_add'  => 'required|email|unique:guests,email_add',
            'age'        => 'nullable|integer|min:1',
            'birthday'   => 'nullable|date',
        ]);

        Guest::create(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('guests.index')
                         ->with('success', 'Guest added successfully.');
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'fname'      => 'required|string|max:255',
            'lname'      => 'required|string|max:255',
            'mobile_num' => 'required|string|unique:guests,mobile_num,' . $guest->id,
            'email_add'  => 'required|email|unique:guests,email_add,' . $guest->id,
            'age'        => 'nullable|integer|min:1',
            'birthday'   => 'nullable|date',
        ]);

        $guest->update(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('guests.index')
                         ->with('success', 'Guest updated successfully.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('guests.index')
                         ->with('success', 'Guest deleted successfully.');
    }
}