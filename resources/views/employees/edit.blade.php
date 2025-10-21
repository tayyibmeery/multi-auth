@extends('layouts.app')

@section('title', 'Edit Employee - ' . $employee->name)

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
                <h1 class="m-0">Edit Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.show', $employee->id) }}">{{ $employee->name }}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                            <i class="fas fa-edit mr-2"></i>
                            Edit Employee: {{ $employee->name }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Employee
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" id="employeeForm">
                        @csrf
                        @method('PUT')
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
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror rounded-right" placeholder="Enter full name" value="{{ old('name', $employee->name) }}" required>
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
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror rounded-right" placeholder="Enter email address" value="{{ old('email', $employee->email) }}">
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
                                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror rounded-right" placeholder="Enter phone number" value="{{ old('phone', $employee->phone) }}">
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
                                            <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror rounded-right" placeholder="Enter job position" value="{{ old('position', $employee->position) }}" required>
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
                                            <option value="Production" {{ old('department', $employee->department) == 'Production' ? 'selected' : '' }}>Production</option>
                                            <option value="Sales" {{ old('department', $employee->department) == 'Sales' ? 'selected' : '' }}>Sales</option>
                                            <option value="Administration" {{ old('department', $employee->department) == 'Administration' ? 'selected' : '' }}>Administration</option>
                                            <option value="Finance" {{ old('department', $employee->department) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                            <option value="HR" {{ old('department', $employee->department) == 'HR' ? 'selected' : '' }}>Human Resources</option>
                                            <option value="IT" {{ old('department', $employee->department) == 'IT' ? 'selected' : '' }}>IT</option>
                                            <option value="Marketing" {{ old('department', $employee->department) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="Operations" {{ old('department', $employee->department) == 'Operations' ? 'selected' : '' }}>Operations</option>
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
                                            <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror rounded-right" value="{{ old('basic_salary', $employee->basic_salary) }}" required min="0" placeholder="0.00">
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
                                            <input type="date" name="hire_date" id="hire_date" class="form-control @error('hire_date') is-invalid @enderror rounded-right" value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}" required>
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
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
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
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Enter employee address">{{ old('address', $employee->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Employee Statistics -->
                            <div class="bg-light p-4 rounded mb-4">
                                <h5 class="font-weight-bold text-dark mb-3">
                                    <i class="fas fa-chart-bar mr-2"></i>Employee Statistics
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Total Salary Paid:</span>
                                            <span class="font-weight-bold text-success">Rs {{ number_format($employee->total_salary_paid, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Salary Payments:</span>
                                            <span class="font-weight-bold text-primary">{{ $employee->salaryPayments->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Created:</span>
                                            <span class="font-weight-bold text-muted">{{ $employee->created_at->format('M j, Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Last Updated:</span>
                                            <span class="font-weight-bold text-muted">{{ $employee->updated_at->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
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
                                        <i class="fas fa-save mr-1"></i> Update Employee
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
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
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
