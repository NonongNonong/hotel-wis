<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $query->where('service_name', 'like', '%' . $request->search . '%')
                  ->orWhere('availability', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $services = $query->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'availability' => 'required|string',
        ]);

        Service::create(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('services.index')
                         ->with('success', 'Service added successfully.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'availability' => 'required|string',
        ]);

        $service->update(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('services.index')
                         ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
                         ->with('success', 'Service deleted successfully.');
    }
}