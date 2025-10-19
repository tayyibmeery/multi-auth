@extends('layouts.app')

@section('title', 'Pay Salary - ' . $employee->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pay Salary - {{ $employee->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('salaries.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date *</label>
                            <input type="datetime-local" name="payment_date" id="payment_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="month" class="form-label">Month *</label>
                            <select name="month" id="month" class="form-select" required>
                                <option value="">Select Month</option>
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}" {{ $month == now()->format('F') ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Year *</label>
                            <input type="number" name="year" id="year" class="form-control" value="{{ now()->year }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="basic_salary" class="form-label">Basic Salary *</label>
                            <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" value="{{ $employee->basic_salary }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="allowances" class="form-label">Allowances</label>
                            <input type="number" step="0.01" name="allowances" id="allowances" class="form-control" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="deductions" class="form-label">Deductions</label>
                            <input type="number" step="0.01" name="deductions" id="deductions" class="form-control" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method *</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Pay Salary</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Employee Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $employee->name }}</td>
                        </tr>
                        <tr>
                            <th>Position:</th>
                            <td>{{ $employee->position }}</td>
                        </tr>
                        <tr>
                            <th>Department:</th>
                            <td>{{ $employee->department }}</td>
                        </tr>
                        <tr>
                            <th>Basic Salary:</th>
                            <td>Rs {{ number_format($employee->basic_salary, 2) }}</td>
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

                    @if($employee->salaryPayments->count() > 0)
                    <h6 class="mt-3">Salary History</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Net Salary</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee->salaryPayments->take(5) as $salary)
                                <tr>
                                    <td>{{ $salary->month }}</td>
                                    <td>{{ $salary->year }}</td>
                                    <td>Rs {{ number_format($salary->net_salary, 2) }}</td>
                                    <td>{{ $salary->payment_date->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Calculate net salary
    function calculateNetSalary() {
        const basicSalary = parseFloat(document.getElementById('basic_salary').value) || 0;
        const allowances = parseFloat(document.getElementById('allowances').value) || 0;
        const deductions = parseFloat(document.getElementById('deductions').value) || 0;
        const netSalary = basicSalary + allowances - deductions;

        document.getElementById('net_salary').value = netSalary.toFixed(2);
    }

    document.getElementById('basic_salary').addEventListener('input', calculateNetSalary);
    document.getElementById('allowances').addEventListener('input', calculateNetSalary);
    document.getElementById('deductions').addEventListener('input', calculateNetSalary);

</script>
@endpush
@endsection
