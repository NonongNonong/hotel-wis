<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['guest', 'room', 'service', 'employee']);

        if ($request->filled('search')) {
            $query->whereHas('guest', function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%');
            })->orWhereHas('service', function($q) use ($request) {
                $q->where('service_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(10);
        return view('servicerequests.index', compact('requests'));
    }

    public function create()
    {
        $reservations = Reservation::with(['guest', 'room'])
            ->where('status', 'Checked-in')
            ->get();
        $services  = Service::where('availability', 'Available')->get();
        $employees = Employee::where('status', 'Active')->get();
        return view('servicerequests.create',
            compact('reservations', 'services', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id'       => 'required|exists:reservations,id',
            'service_id'           => 'required|exists:services,id',
            'quantity'             => 'required|integer|min:1',
            'special_instructions' => 'nullable|string',
            'employee_id'          => 'nullable|exists:employees,id',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);
        $service     = Service::findOrFail($request->service_id);
        $totalCost   = $service->price * $request->quantity;
        $status      = $request->employee_id ? 'Assigned' : 'Pending';

        ServiceRequest::create([
            'guest_id'             => $reservation->guest_id,
            'reservation_id'       => $reservation->id,
            'room_id'              => $reservation->room_id,
            'service_id'           => $request->service_id,
            'employee_id'          => $request->employee_id,
            'quantity'             => $request->quantity,
            'special_instructions' => $request->special_instructions,
            'status'               => $status,
            'total_cost'           => $totalCost,
            'last_update_by'       => auth()->user()->name,
        ]);

        return redirect()->route('servicerequests.index')
                         ->with('success', 'Service request created successfully.');
    }

    public function show(ServiceRequest $servicerequest)
    {
        $servicerequest->load(['guest', 'room', 'service', 'employee', 'reservation']);
        return view('servicerequests.show', compact('servicerequest'));
    }

    public function edit(ServiceRequest $servicerequest)
    {
        $services  = Service::where('availability', 'Available')->get();
        $employees = Employee::where('status', 'Active')->get();
        return view('servicerequests.edit',
            compact('servicerequest', 'services', 'employees'));
    }

    public function update(Request $request, ServiceRequest $servicerequest)
    {
        $request->validate([
            'status'      => 'required|string',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $service   = Service::findOrFail($servicerequest->service_id);
        $totalCost = $service->price * $servicerequest->quantity;

        $servicerequest->update([
            'employee_id'    => $request->employee_id,
            'status'         => $request->status,
            'total_cost'     => $totalCost,
            'last_update_by' => auth()->user()->name,
        ]);

        return redirect()->route('servicerequests.index')
                         ->with('success', 'Service request updated successfully.');
    }

    public function destroy(ServiceRequest $servicerequest)
    {
        $servicerequest->delete();
        return redirect()->route('servicerequests.index')
                         ->with('success', 'Service request deleted.');
    }
}