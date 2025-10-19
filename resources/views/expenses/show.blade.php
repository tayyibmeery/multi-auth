@extends('layouts.app')

@section('title', 'Expense Details - ' . $expense->expense_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Expense Details - {{ $expense->expense_number }}</h5>
                    <div>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Expense Number:</th>
                                    <td>{{ $expense->expense_number }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $expense->expense_date->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Account:</th>
                                    <td>{{ $expense->account->name }} ({{ $expense->account->code }})</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>
                                        <span class="badge bg-secondary">{{ $expense->category }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Amount:</th>
                                    <td><strong>Rs {{ number_format($expense->amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($expense->payment_method) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Reference Number:</th>
                                    <td>{{ $expense->reference_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created By:</th>
                                    <td>{{ $expense->user->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Description</h6>
                            <p class="border p-3 rounded bg-light">{{ $expense->description }}</p>
                        </div>
                    </div>

                    @if($expense->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Notes</h6>
                            <p class="border p-3 rounded bg-light">{{ $expense->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Accounting Entries</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Account</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expense->accountingVouchers as $voucher)
                                        <tr>
                                            <td>{{ $voucher->account->name }}</td>
                                            <td class="{{ $voucher->debit > 0 ? 'text-danger' : '' }}">
                                                {{ $voucher->debit > 0 ? 'Rs ' . number_format($voucher->debit, 2) : '-' }}
                                            </td>
                                            <td class="{{ $voucher->credit > 0 ? 'text-success' : '' }}">
                                                {{ $voucher->credit > 0 ? 'Rs ' . number_format($voucher->credit, 2) : '-' }}
                                            </td>
                                            <td>{{ $voucher->description }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
