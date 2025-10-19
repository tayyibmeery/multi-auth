@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Expense</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expense_date" class="form-label">Expense Date *</label>
                                    <input type="datetime-local" name="expense_date" id="expense_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="account_id" class="form-label">Account *</label>
                                    <select name="account_id" id="account_id" class="form-control" required>
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount *</label>
                                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" required min="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <option value="office_supplies">Office Supplies</option>
                                        <option value="utilities">Utilities</option>
                                        <option value="rent">Rent</option>
                                        <option value="marketing">Marketing</option>
                                        <option value="travel">Travel</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="software">Software</option>
                                        <option value="hardware">Hardware</option>
                                        <option value="professional_services">Professional Services</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method *</label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="card">Card</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reference_number" class="form-label">Reference Number</label>
                                    <input type="text" name="reference_number" id="reference_number" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required placeholder="Enter expense description..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Additional notes (optional)"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Add Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Expense Categories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Office Supplies
                            <span class="badge bg-primary rounded-pill">General</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Utilities
                            <span class="badge bg-primary rounded-pill">Monthly</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Rent
                            <span class="badge bg-primary rounded-pill">Fixed</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Marketing
                            <span class="badge bg-success rounded-pill">Variable</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Travel
                            <span class="badge bg-warning rounded-pill">Occasional</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Maintenance
                            <span class="badge bg-info rounded-pill">As Needed</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Quick Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-info-circle text-primary me-2"></i> Select the appropriate account for proper accounting</li>
                        <li><i class="fas fa-info-circle text-primary me-2"></i> Choose the correct category for better reporting</li>
                        <li><i class="fas fa-info-circle text-primary me-2"></i> Add reference numbers for bank transactions</li>
                        <li><i class="fas fa-info-circle text-primary me-2"></i> Provide clear descriptions for future reference</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
