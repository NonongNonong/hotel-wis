<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $query->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('role', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%')
                  ->orWhere('email_add', 'like', '%' . $request->search . '%');
        }

        $employees = $query->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname'      => 'required|string|max:255',
            'lname'      => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'mobile_num' => 'required|string|unique:employees,mobile_num',
            'email_add'  => 'required|email|unique:employees,email_add',
            'hire_date'  => 'required|date',
            'status'     => 'required|string',
            'age'        => 'nullable|integer|min:1',
            'birthday'   => 'nullable|date',
        ]);

        Employee::create(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('employees.index')
                         ->with('success', 'Employee added successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'fname'      => 'required|string|max:255',
            'lname'      => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'mobile_num' => 'required|string|unique:employees,mobile_num,' . $employee->id,
            'email_add'  => 'required|email|unique:employees,email_add,' . $employee->id,
            'hire_date'  => 'required|date',
            'status'     => 'required|string',
            'age'        => 'nullable|integer|min:1',
            'birthday'   => 'nullable|date',
        ]);

        $employee->update(array_merge(
            $request->all(),
            ['last_update_by' => auth()->user()->name]
        ));

        return redirect()->route('employees.index')
                         ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
                         ->with('success', 'Employee deleted successfully.');
    }
}