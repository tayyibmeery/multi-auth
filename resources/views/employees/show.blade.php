@extends('layouts.app')

@section('title', 'Employee Details - ' . $employee->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Employee Details - {{ $employee->name }}</h5>
                    <div>
                        <a href="{{ route('salaries.create', $employee->id) }}" class="btn btn-success">
                            <i class="fas fa-money-bill me-1"></i> Pay Salary
                        </a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Name:</th>
                                    <td>{{ $employee->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $employee->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $employee->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Position:</th>
                                    <td>{{ $employee->position }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Department:</th>
                                    <td>{{ $employee->department }}</td>
                                </tr>
                                <tr>
                                    <th>Basic Salary:</th>
                                    <td><strong>₹{{ number_format($employee->basic_salary, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Hire Date:</th>
                                    <td>{{ $employee->hire_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $employee->is_active ? 'success' : 'danger' }}">
                                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($employee->address)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Address</h6>
                            <p class="border p-3 rounded bg-light">{{ $employee->address }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Salary History -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Salary Payment History</h6>
                            @if($employee->salaryPayments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Payment #</th>
                                            <th>Period</th>
                                            <th>Basic Salary</th>
                                            <th>Allowances</th>
                                            <th>Deductions</th>
                                            <th>Net Salary</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employee->salaryPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_number }}</td>
                                            <td>{{ $payment->month }} {{ $payment->year }}</td>
                                            <td>₹{{ number_format($payment->basic_salary, 2) }}</td>
                                            <td>₹{{ number_format($payment->allowances, 2) }}</td>
                                            <td>₹{{ number_format($payment->deductions, 2) }}</td>
                                            <td><strong>₹{{ number_format($payment->net_salary, 2) }}</strong></td>
                                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Total Paid:</strong></td>
                                            <td colspan="2"><strong>₹{{ number_format($employee->total_salary_paid, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @else
                            <p class="text-muted">No salary payments recorded yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
