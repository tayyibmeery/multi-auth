@extends('layouts.app')

@section('title', 'Create Vendor')

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
                <h1 class="m-0">Create Vendor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
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
                            <i class="fas fa-truck mr-2"></i>
                            Vendor Information
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('vendors.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Vendors
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('vendors.store') }}" method="POST" id="vendorForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Vendor Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-building text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror rounded-right" id="name" name="name" placeholder="Enter vendor name" value="{{ old('name') }}" required>
                                        </div>
                                        @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_person" class="form-label">Contact Person</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-user text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control @error('contact_person') is-invalid @enderror rounded-right" id="contact_person" name="contact_person" placeholder="Enter contact person name" value="{{ old('contact_person') }}">
                                        </div>
                                        @error('contact_person')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-envelope text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror rounded-right" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-phone text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror rounded-right" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Enter complete vendor address">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Vendor Type</label>
                                        <select class="form-control select2bs4 @error('vendor_type') is-invalid @enderror" name="vendor_type" style="width: 100%;">
                                            <option value="supplier" {{ old('vendor_type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                            <option value="manufacturer" {{ old('vendor_type') == 'manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                                            <option value="distributor" {{ old('vendor_type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                            <option value="wholesaler" {{ old('vendor_type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                        </select>
                                        @error('vendor_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Payment Terms</label>
                                        <select class="form-control select2bs4 @error('payment_terms') is-invalid @enderror" name="payment_terms" style="width: 100%;">
                                            <option value="net_15" {{ old('payment_terms') == 'net_15' ? 'selected' : '' }}>Net 15 Days</option>
                                            <option value="net_30" {{ old('payment_terms') == 'net_30' ? 'selected' : '' }}>Net 30 Days</option>
                                            <option value="net_45" {{ old('payment_terms') == 'net_45' ? 'selected' : '' }}>Net 45 Days</option>
                                            <option value="due_on_receipt" {{ old('payment_terms') == 'due_on_receipt' ? 'selected' : '' }}>Due on Receipt</option>
                                        </select>
                                        @error('payment_terms')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch custom-switch-lg">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                                    <label class="custom-control-label" for="status">
                                        <span class="font-weight-bold">Active Vendor</span>
                                    </label>
                                </div>
                                <small class="form-text text-muted">Vendor will be available for purchases when active</small>
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
                                        <i class="fas fa-save mr-1"></i> Create Vendor
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
<!-- /.content -->
@endsection

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<script>
    $(function() {
        // Initialize Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4'
            , placeholder: 'Select an option'
            , allowClear: true
        });

        // Initialize InputMask for phone
        $('#phone').inputmask('(999) 999-9999');

        // Auto-format phone number
        $('#phone').on('blur', function() {
            let phone = $(this).val().replace(/\D/g, '');
            if (phone.length === 10) {
                phone = phone.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                $(this).val(phone);
            }
        });

        // Form validation enhancement
        $('#vendorForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Creating...');
        });

        // Real-time validation for required fields
        $('#name').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

</script>
@endpush
