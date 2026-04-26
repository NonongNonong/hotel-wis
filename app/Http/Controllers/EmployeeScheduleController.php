<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSchedule;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = EmployeeSchedule::with('employee');

        if ($request->filled('search')) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('date')) {
            $query->where('work_date', $request->date);
        }

        $schedules   = $query->orderBy('work_date', 'desc')->paginate(10);
        $departments = Employee::distinct()->pluck('department');

        return view('schedules.index', compact('schedules', 'departments'));
    }

    public function create()
    {
        $employees   = Employee::where('status', 'Active')->orderBy('lname')->get();
        $departments = Employee::distinct()->pluck('department');
        return view('schedules.create', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_date'   => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
            'department'  => 'required|string',
        ]);

        // Check for duplicate schedule on same day
        $exists = EmployeeSchedule::where('employee_id', $request->employee_id)
            ->where('work_date', $request->work_date)
            ->exists();

        if ($exists) {
            return back()->withInput()
                         ->with('error', 'This employee already has a schedule on that date.');
        }

        EmployeeSchedule::create([
            'employee_id' => $request->employee_id,
            'work_date'   => $request->work_date,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'department'  => $request->department,
            'created_by'  => auth()->user()->name,
        ]);

        return redirect()->route('schedules.index')
                         ->with('success', 'Schedule added successfully.');
    }

    public function show(EmployeeSchedule $schedule)
    {
        $schedule->load('employee');
        return view('schedules.show', compact('schedule'));
    }

    public function edit(EmployeeSchedule $schedule)
    {
        $employees = Employee::where('status', 'Active')->orderBy('lname')->get();
        return view('schedules.edit', compact('schedule', 'employees'));
    }

    public function update(Request $request, EmployeeSchedule $schedule)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_date'   => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
            'department'  => 'required|string',
        ]);

        $schedule->update([
            'employee_id' => $request->employee_id,
            'work_date'   => $request->work_date,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'department'  => $request->department,
        ]);

        return redirect()->route('schedules.index')
                         ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(EmployeeSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')
                         ->with('success', 'Schedule deleted successfully.');
    }
}