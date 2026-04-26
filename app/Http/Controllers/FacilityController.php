<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->filled('search')) {
            $query->where('facility_name', 'like', '%' . $request->search . '%')
                  ->orWhere('facility_category', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%');
        }

        $facilities = $query->latest()->paginate(10);
        return view('facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_name'     => 'required|string|max:255',
            'facility_category' => 'required|string|max:255',
            'description'       => 'nullable|string',
            'capacity'          => 'nullable|integer|min:1',
            'status'            => 'required|string',
            'reservable'        => 'nullable|boolean',
            'need_payment'      => 'nullable|boolean',
            'price'             => 'required|numeric|min:0',
        ]);

        Facility::create(array_merge(
            $request->except(['reservable', 'need_payment']),
            [
                'reservable'     => $request->has('reservable') ? 1 : 0,
                'need_payment'   => $request->has('need_payment') ? 1 : 0,
                'last_update_by' => auth()->user()->name,
            ]
        ));

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility added successfully.');
    }

    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'facility_name'     => 'required|string|max:255',
            'facility_category' => 'required|string|max:255',
            'description'       => 'nullable|string',
            'capacity'          => 'nullable|integer|min:1',
            'status'            => 'required|string',
            'reservable'        => 'nullable|boolean',
            'need_payment'      => 'nullable|boolean',
            'price'             => 'required|numeric|min:0',
        ]);

        $facility->update(array_merge(
            $request->except(['reservable', 'need_payment']),
            [
                'reservable'     => $request->has('reservable') ? 1 : 0,
                'need_payment'   => $request->has('need_payment') ? 1 : 0,
                'last_update_by' => auth()->user()->name,
            ]
        ));

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility updated successfully.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('facilities.index')
                         ->with('success', 'Facility deleted successfully.');
    }
}