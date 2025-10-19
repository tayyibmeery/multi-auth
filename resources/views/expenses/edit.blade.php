@extends('layouts.app')

@section('title', 'Edit Expense - ' . $expense->expense_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Expense - {{ $expense->expense_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expense_date" class="form-label">Expense Date *</label>
                                    <input type="datetime-local" name="expense_date" id="expense_date" class="form-control" value="{{ $expense->expense_date->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="account_id" class="form-label">Account *</label>
                                    <select name="account_id" id="account_id" class="form-control" required>
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" {{ $expense->account_id == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }} ({{ $account->code }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount *</label>
                                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $expense->amount }}" required min="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <option value="office_supplies" {{ $expense->category == 'office_supplies' ? 'selected' : '' }}>Office Supplies</option>
                                        <option value="utilities" {{ $expense->category == 'utilities' ? 'selected' : '' }}>Utilities</option>
                                        <option value="rent" {{ $expense->category == 'rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="marketing" {{ $expense->category == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="travel" {{ $expense->category == 'travel' ? 'selected' : '' }}>Travel</option>
                                        <option value="maintenance" {{ $expense->category == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="software" {{ $expense->category == 'software' ? 'selected' : '' }}>Software</option>
                                        <option value="hardware" {{ $expense->category == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                        <option value="professional_services" {{ $expense->category == 'professional_services' ? 'selected' : '' }}>Professional Services</option>
                                        <option value="other" {{ $expense->category == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method *</label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="cash" {{ $expense->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ $expense->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="card" {{ $expense->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                        <option value="cheque" {{ $expense->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reference_number" class="form-label">Reference Number</label>
                                    <input type="text" name="reference_number" id="reference_number" class="form-control" value="{{ $expense->reference_number }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $expense->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2">{{ $expense->notes }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
