@extends('layouts.app')

@section('title', 'Create Accounting Voucher')

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
                <h1 class="m-0">Create Accounting Voucher</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.vouchers') }}">Vouchers</a></li>
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
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-receipt mr-2"></i>
                            New Voucher Details
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('accounting.vouchers') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Vouchers
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('accounting.vouchers.store') }}" method="POST" id="voucherForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="voucher_date" class="form-label">Voucher Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-calendar text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control @error('voucher_date') is-invalid @enderror rounded-right" id="voucher_date" name="voucher_date" value="{{ old('voucher_date', date('Y-m-d')) }}" required>
                                        </div>
                                        @error('voucher_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_id" class="form-label">Account <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('account_id') is-invalid @enderror" id="account_id" name="account_id" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                {{ $account->code }} - {{ $account->name }}
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
                                        <label for="debit" class="form-label">Debit Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-arrow-down text-danger"></i>
                                                </span>
                                            </div>
                                            <input type="number" step="0.01" class="form-control @error('debit') is-invalid @enderror rounded-right" id="debit" name="debit" value="{{ old('debit', 0) }}" placeholder="0.00">
                                        </div>
                                        @error('debit')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="credit" class="form-label">Credit Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-arrow-up text-success"></i>
                                                </span>
                                            </div>
                                            <input type="number" step="0.01" class="form-control @error('credit') is-invalid @enderror rounded-right" id="credit" name="credit" value="{{ old('credit', 0) }}" placeholder="0.00">
                                        </div>
                                        @error('credit')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter voucher description..." required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="reference" class="form-label">Reference</label>
                                <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="Optional reference number">
                                @error('reference')
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
                                        <i class="fas fa-save mr-1"></i> Create Voucher
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

        // Ensure only one of debit or credit is filled
        $('#debit, #credit').on('input', function() {
            if ($(this).val() > 0) {
                if ($(this).attr('id') === 'debit') {
                    $('#credit').val(0);
                } else {
                    $('#debit').val(0);
                }
            }
        });

        // Form validation enhancement
        $('#voucherForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Creating...');
        });
    });

</script>
@endpush
