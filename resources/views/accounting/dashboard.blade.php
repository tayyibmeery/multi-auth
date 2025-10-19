@extends('layouts.app')

@section('title', 'Accounting Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-4">Accounting Dashboard</h4>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Sales</h6>
                            <h3 class="text-primary">Rs {{ number_format($totalSales, 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Expenses</h6>
                            <h3 class="text-danger">Rs {{ number_format($totalExpenses, 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Cash Balance</h6>
                            <h3 class="text-success">Rs {{ number_format($cashBalance, 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-wallet fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Bank Balance</h6>
                            <h3 class="text-info">Rs {{ number_format($bankBalance, 2) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-university fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Vouchers -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Accounting Vouchers</h5>
                    <a href="{{ route('accounting.vouchers') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Voucher #</th>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentVouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher->voucher_number }}</td>
                                    <td>{{ $voucher->voucher_date->format('M d, Y') }}</td>
                                    <td>{{ $voucher->account->name }}</td>
                                    <td class="{{ $voucher->debit > 0 ? 'text-danger' : '' }}">
                                        {{ $voucher->debit > 0 ? 'Rs ' . number_format($voucher->debit, 2) : '-' }}
                                    </td>
                                    <td class="{{ $voucher->credit > 0 ? 'text-success' : '' }}">
                                        {{ $voucher->credit > 0 ? 'Rs ' . number_format($voucher->credit, 2) : '-' }}
                                    </td>
                                    <td>{{ Str::limit($voucher->description, 30) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('accounting.trial-balance') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-balance-scale me-2"></i> Trial Balance
                        </a>
                        <a href="{{ route('accounting.income-statement') }}" class="btn btn-outline-success text-start">
                            <i class="fas fa-chart-line me-2"></i> Income Statement
                        </a>
                        <a href="{{ route('accounting.balance-sheet') }}" class="btn btn-outline-info text-start">
                            <i class="fas fa-file-invoice-dollar me-2"></i> Balance Sheet
                        </a>
                        <a href="{{ route('expenses.create') }}" class="btn btn-outline-warning text-start">
                            <i class="fas fa-plus me-2"></i> Add Expense
                        </a>
                        <a href="{{ route('employees.create') }}" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-user-plus me-2"></i> Add Employee
                        </a>
                    </div>
                </div>
            </div>

            <!-- Account Summary -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Account Summary</h5>
                </div>
                <div class="card-body">
                    @php
                    $accounts = \App\Models\Account::where('is_active', true)->get();
                    @endphp
                    <div class="list-group list-group-flush">
                        @foreach($accounts as $account)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $account->name }}</span>
                            <span class="badge bg-{{ $account->current_balance >= 0 ? 'success' : 'danger' }} rounded-pill">
                                Rs {{ number_format($account->current_balance, 2) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
