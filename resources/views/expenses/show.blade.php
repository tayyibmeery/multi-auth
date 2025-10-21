@extends('layouts.app')

@section('title', 'Expense Details - ' . $expense->expense_number)

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
                <h1>{{ $expense->expense_number }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
                    <li class="breadcrumb-item active">{{ $expense->expense_number }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Expense Information Row -->
        <div class="row">
            <!-- Expense Details -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Expense Information
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
                                <strong><i class="fas fa-receipt mr-1"></i> Expense Number</strong>
                                <p class="text-muted">{{ $expense->expense_number }}</p>
                                <hr>

                                <strong><i class="fas fa-calendar mr-1"></i> Date</strong>
                                <p class="text-muted">{{ $expense->expense_date->format('M d, Y h:i A') }}</p>
                                <hr>

                                <strong><i class="fas fa-book mr-1"></i> Account</strong>
                                <p class="text-muted">{{ $expense->account->name }} ({{ $expense->account->code }})</p>
                                <hr>

                                <strong><i class="fas fa-tags mr-1"></i> Category</strong>
                                <p class="text-muted">
                                    <span class="badge bg-secondary">{{ $expense->category }}</span>
                                </p>
                                <hr>

                                <strong><i class="fas fa-user mr-1"></i> Created By</strong>
                                <p class="text-muted">{{ $expense->user->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('expenses.index') }}" class="btn btn-default btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment & Amount -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave mr-1"></i>
                            Payment Details
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="small-box bg-gradient-danger">
                            <div class="inner">
                                <h3>Rs {{ number_format($expense->amount, 2) }}</h3>
                                <p>Total Amount</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-info">
                                        {{ ucfirst($expense->payment_method) }}
                                    </h5>
                                    <span class="description-text">PAYMENT METHOD</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="description-block">
                                    <h5 class="description-header text-muted">{{ $expense->reference_number ?? 'N/A' }}</h5>
                                    <span class="description-text">REFERENCE</span>
                                </div>
                            </div>
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
                            <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus mr-1"></i> New Expense
                            </a>

                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit mr-1"></i> Edit Expense
                            </a>

                            <a href="{{ route('accounting.vouchers') }}" class="btn btn-info btn-block">
                                <i class="fas fa-book mr-1"></i> View Vouchers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Notes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-align-left mr-1"></i>
                            Description & Notes
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Description</h5>
                                <p class="border p-3 rounded bg-light">{{ $expense->description }}</p>
                            </div>
                            @if($expense->notes)
                            <div class="col-md-6">
                                <h5>Additional Notes</h5>
                                <p class="border p-3 rounded bg-light">{{ $expense->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accounting Entries -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-book mr-1"></i>
                            Accounting Entries
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($expense->accountingVouchers->count() > 0)
                        <div class="table-responsive">
                            <table id="accountingEntriesTable" class="table table-bordered table-striped">
                                <thead>
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
                                        <td class="{{ $voucher->debit > 0 ? 'text-danger font-weight-bold' : '' }}">
                                            {{ $voucher->debit > 0 ? 'Rs ' . number_format($voucher->debit, 2) : '-' }}
                                        </td>
                                        <td class="{{ $voucher->credit > 0 ? 'text-success font-weight-bold' : '' }}">
                                            {{ $voucher->credit > 0 ? 'Rs ' . number_format($voucher->credit, 2) : '-' }}
                                        </td>
                                        <td>{{ $voucher->description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-2x text-muted mb-3"></i>
                            <h5 class="text-muted">No accounting entries recorded</h5>
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
        $("#accountingEntriesTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 5
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search entries..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
