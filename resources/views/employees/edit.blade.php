@extends('layouts.app')

@section('title', 'Edit Employee - ' . $employee->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Employee - {{ $employee->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $employee->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $employee->email }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $employee->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position *</label>
                                    <input type="text" name="position" id="position" class="form-control" value="{{ $employee->position }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department *</label>
                                    <select name="department" id="department" class="form-control" required>
                                        <option value="">Select Department</option>
                                        <option value="Production" {{ $employee->department == 'Production' ? 'selected' : '' }}>Production</option>
                                        <option value="Sales" {{ $employee->department == 'Sales' ? 'selected' : '' }}>Sales</option>
                                        <option value="Administration" {{ $employee->department == 'Administration' ? 'selected' : '' }}>Administration</option>
                                        <option value="Finance" {{ $employee->department == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="HR" {{ $employee->department == 'HR' ? 'selected' : '' }}>Human Resources</option>
                                        <option value="IT" {{ $employee->department == 'IT' ? 'selected' : '' }}>IT</option>
                                        <option value="Marketing" {{ $employee->department == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="Operations" {{ $employee->department == 'Operations' ? 'selected' : '' }}>Operations</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="basic_salary" class="form-label">Basic Salary *</label>
                                    <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" value="{{ $employee->basic_salary }}" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hire_date" class="form-label">Hire Date *</label>
                                    <input type="date" name="hire_date" id="hire_date" class="form-control" value="{{ $employee->hire_date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $employee->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active Employee</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3">{{ $employee->address }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
