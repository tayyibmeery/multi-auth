<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;

class SalaryPaymentController extends Controller
{
    public function create(Employee $employee)
    {
        return view('salaries.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payment_date' => 'required|date',
            'month' => 'required|string',
            'year' => 'required|integer',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,cheque',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $netSalary = $request->basic_salary + ($request->allowances ?? 0) - ($request->deductions ?? 0);

            SalaryPayment::create([
                'employee_id' => $request->employee_id,
                'payment_date' => $request->payment_date,
                'month' => $request->month,
                'year' => $request->year,
                'basic_salary' => $request->basic_salary,
                'allowances' => $request->allowances ?? 0,
                'deductions' => $request->deductions ?? 0,
                'net_salary' => $netSalary,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('employees.show', $request->employee_id)
                ->with('success', 'Salary payment recorded successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to record salary payment: ' . $e->getMessage()]);
        }
    }
}