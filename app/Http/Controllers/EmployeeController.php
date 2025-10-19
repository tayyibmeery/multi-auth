<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('name')->paginate(20);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
        ]);

        try {
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'position' => $request->position,
                'department' => $request->department,
                'basic_salary' => $request->basic_salary,
                'hire_date' => $request->hire_date,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('employees.index')
                ->with('success', 'Employee created successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create employee: ' . $e->getMessage()]);
        }
    }

    public function show(Employee $employee)
    {
        $employee->load('salaryPayments');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
        ]);

        try {
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'position' => $request->position,
                'department' => $request->department,
                'basic_salary' => $request->basic_salary,
                'hire_date' => $request->hire_date,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('employees.index')
                ->with('success', 'Employee updated successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update employee: ' . $e->getMessage()]);
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('employees.index')
                ->with('success', 'Employee deleted successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete employee: ' . $e->getMessage()]);
        }
    }
}