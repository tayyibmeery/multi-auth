@extends('layouts.app')

@section('title', 'Add Employee')

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
                <h1 class="m-0">Add New Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
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
                            <i class="fas fa-user-plus mr-2"></i>
                            New Employee Details
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Employees
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('employees.store') }}" method="POST" id="employeeForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-user text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror rounded-right" placeholder="Enter full name" value="{{ old('name') }}" required>
                                        </div>
                                        @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-envelope text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror rounded-right" placeholder="Enter email address" value="{{ old('email') }}">
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-phone text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror rounded-right" placeholder="Enter phone number" value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-briefcase text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror rounded-right" placeholder="Enter job position" value="{{ old('position') }}" required>
                                        </div>
                                        @error('position')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                                        <select name="department" id="department" class="form-control select2 @error('department') is-invalid @enderror" required>
                                            <option value="">Select Department</option>
                                            <option value="Production" {{ old('department') == 'Production' ? 'selected' : '' }}>Production</option>
                                            <option value="Sales" {{ old('department') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                            <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration</option>
                                            <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                            <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>Human Resources</option>
                                            <option value="IT" {{ old('department') == 'IT' ? 'selected' : '' }}>IT</option>
                                            <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="Operations" {{ old('department') == 'Operations' ? 'selected' : '' }}>Operations</option>
                                        </select>
                                        @error('department')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="basic_salary" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-rupee-sign text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror rounded-right" value="{{ old('basic_salary') }}" required min="0" placeholder="0.00">
                                        </div>
                                        @error('basic_salary')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hire_date" class="form-label">Hire Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-calendar text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="date" name="hire_date" id="hire_date" class="form-control @error('hire_date') is-invalid @enderror rounded-right" value="{{ old('hire_date', date('Y-m-d')) }}" required>
                                        </div>
                                        @error('hire_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="custom-control custom-switch custom-switch-lg mt-2">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                <span class="font-weight-bold">Active Employee</span>
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">Employee will be able to receive salary when active</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Enter employee address">{{ old('address') }}</textarea>
                                @error('address')
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
                                        <i class="fas fa-save mr-1"></i> Add Employee
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
        $('#employeeForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Creating...');
        });

        // Real-time validation for required fields
        $('#name, #position, #basic_salary').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

</script>
@endpush
