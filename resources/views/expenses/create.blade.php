@extends('layouts.app')

@section('title', 'Add Expense')

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add New Expense</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-plus-circle mr-2"></i>
                            New Expense Details
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Expenses
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('expenses.store') }}" method="POST" id="expenseForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expense_date" class="form-label">Expense Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-calendar text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="datetime-local" name="expense_date" id="expense_date" class="form-control @error('expense_date') is-invalid @enderror rounded-right" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                        </div>
                                        @error('expense_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_id" class="form-label">Account <span class="text-danger">*</span></label>
                                        <select name="account_id" id="account_id" class="form-control select2 @error('account_id') is-invalid @enderror" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }} ({{ $account->code }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('account_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-rupee-sign text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror rounded-right" value="{{ old('amount') }}" required min="0.01" placeholder="0.00">
                                        </div>
                                        @error('amount')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category" id="category" class="form-control select2 @error('category') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            <option value="office_supplies" {{ old('category') == 'office_supplies' ? 'selected' : '' }}>Office Supplies</option>
                                            <option value="utilities" {{ old('category') == 'utilities' ? 'selected' : '' }}>Utilities</option>
                                            <option value="rent" {{ old('category') == 'rent' ? 'selected' : '' }}>Rent</option>
                                            <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="travel" {{ old('category') == 'travel' ? 'selected' : '' }}>Travel</option>
                                            <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                            <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software</option>
                                            <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                            <option value="professional_services" {{ old('category') == 'professional_services' ? 'selected' : '' }}>Professional Services</option>
                                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('category')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select name="payment_method" id="payment_method" class="form-control select2 @error('payment_method') is-invalid @enderror" required>
                                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                            <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                        </select>
                                        @error('payment_method')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference_number" class="form-label">Reference Number</label>
                                        <input type="text" name="reference_number" id="reference_number" class="form-control @error('reference_number') is-invalid @enderror" value="{{ old('reference_number') }}" placeholder="Optional reference number">
                                        @error('reference_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" required placeholder="Enter expense description...">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="2" placeholder="Additional notes (optional)">{{ old('notes') }}</textarea>
                                @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Fields marked with <span class="text-danger">*</span> are required
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="reset" class="btn btn-outline-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Add Expense
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Form validation enhancement
        $('#expenseForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Creating...');
        });

        // Real-time validation for required fields
        $('#amount, #description').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

</script>
@endpush
