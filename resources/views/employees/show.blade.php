@extends('layouts.app')

@section('title', $employee->name)

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $employee->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item active">{{ $employee->name }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Employee Information Row -->
        <div class="row">
            <!-- Employee Details -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Employee Information
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <strong><i class="fas fa-user mr-1"></i> Name</strong>
                                <p class="text-muted">{{ $employee->name }}</p>
                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                <p class="text-muted">{{ $employee->email ?? "N/A" }}</p>
                                <hr>

                                <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                                <p class="text-muted">{{ $employee->phone ?? "N/A" }}</p>
                                <hr>

                                <strong><i class="fas fa-briefcase mr-1"></i> Position</strong>
                                <p class="text-muted">{{ $employee->position }}</p>
                                <hr>

                                <strong><i class="fas fa-building mr-1"></i> Department</strong>
                                <p class="text-muted">{{ $employee->department }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('employees.index') }}" class="btn btn-default btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary & Status -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave mr-1"></i>
                            Salary & Status
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="small-box bg-gradient-success">
                            <div class="inner">
                                <h3>Rs {{ number_format($employee->basic_salary, 2) }}</h3>
                                <p>Basic Salary</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-primary">
                                        {{ $employee->hire_date->format('M d, Y') }}
                                    </h5>
                                    <span class="description-text">HIRE DATE</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="description-block">
                                    <h5 class="description-header {{ $employee->is_active ? 'text-success' : 'text-danger' }}">
                                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                    </h5>
                                    <span class="description-text">STATUS</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-3 text-center">
                            <a href="{{ route('salaries.create', $employee->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-money-bill mr-1"></i> Pay Salary
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Quick Actions
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('salaries.create', $employee->id) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-money-bill mr-1"></i> Pay Salary
                            </a>

                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit mr-1"></i> Edit Employee
                            </a>

                            <a href="{{ route('employees.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-plus mr-1"></i> New Employee
                            </a>
                        </div>

                        <!-- Salary Summary -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="text-center mb-3">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Salary Summary
                            </h5>
                            <div class="row text-center">
                                <div class="col-12">
                                    <div class="info-box bg-gradient-purple">
                                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Paid</span>
                                            <span class="info-box-number">Rs {{ number_format($employee->total_salary_paid, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Section -->
        @if($employee->address)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Address
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $employee->address }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Salary History -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-1"></i>
                            Salary Payment History
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($employee->salaryPayments->count() > 0)
                        <div class="table-responsive">
                            <table id="salaryHistoryTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Payment #</th>
                                        <th>Period</th>
                                        <th>Basic Salary</th>
                                        <th>Allowances</th>
                                        <th>Deductions</th>
                                        <th>Net Salary</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->salaryPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_number }}</td>
                                        <td>{{ $payment->month }} {{ $payment->year }}</td>
                                        <td class="font-weight-bold">Rs {{ number_format($payment->basic_salary, 2) }}</td>
                                        <td class="text-success font-weight-bold">Rs {{ number_format($payment->allowances, 2) }}</td>
                                        <td class="text-danger font-weight-bold">Rs {{ number_format($payment->deductions, 2) }}</td>
                                        <td class="font-weight-bold text-primary">Rs {{ number_format($payment->net_salary, 2) }}</td>
                                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-end"><strong>Total Paid:</strong></td>
                                        <td colspan="2" class="font-weight-bold text-primary">Rs {{ number_format($employee->total_salary_paid, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill-wave fa-2x text-muted mb-3"></i>
                            <h5 class="text-muted">No salary payments recorded yet</h5>
                            <p class="text-muted">Salary payments will appear here after processing</p>
                            <a href="{{ route('salaries.create', $employee->id) }}" class="btn btn-primary">
                                <i class="fas fa-money-bill mr-2"></i>Process First Salary
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(function() {
        $("#salaryHistoryTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search payments..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
