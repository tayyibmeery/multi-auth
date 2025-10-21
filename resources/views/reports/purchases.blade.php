@extends('layouts.app')

@section('title', 'Purchase Report')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Purchase Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Purchases</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card card-info">
            <div class="card-header border-bottom-0">
                <h3 class="card-title">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Report
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.purchases') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="vendor_id" class="form-label">Vendor</label>
                                <select name="vendor_id" id="vendor_id" class="form-control select2">
                                    <option value="">All Vendors</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', $startDate) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', $endDate) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group d-flex align-items-end">
                                <button type="submit" class="btn btn-info mr-2">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <a href="{{ route('reports.purchases') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo mr-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Purchases</span>
                        <span class="info-box-number">{{ number_format($totalPurchases, 2) }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            {{ $purchases->count() }} purchase records
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Date Range</span>
                        <span class="info-box-number">{{ $startDate }} to {{ $endDate }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            Filtered period
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Vendors</span>
                        <span class="info-box-number">{{ $purchases->groupBy('vendor_id')->count() }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            Active in period
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Purchase Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($purchases->count() > 0)
                <div class="table-responsive">
                    <table id="purchasesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Vendor</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                                <td>
                                    @foreach($purchase->purchaseItems as $item)
                                    <span class="badge badge-info">{{ $item->item->name ?? 'N/A' }} ({{ $item->quantity }})</span>
                                    @endforeach
                                </td>
                                <td>{{ $purchase->purchaseItems->sum('quantity') }}</td>
                                <td class="text-right">{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $purchase->purchase_status == 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($purchase->purchase_status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                                <td class="text-right"><strong>{{ number_format($totalPurchases, 2) }}</strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="alert alert-info text-center">
                    <h5><i class="icon fas fa-info"></i> No purchases found</h5>
                    <p>No purchase records match the selected criteria.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Export Options -->
        @if($purchases->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Export Report</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="#" class="btn btn-success btn-block">
                            <i class="fas fa-file-excel mr-2"></i> Export to Excel
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-danger btn-block">
                            <i class="fas fa-file-pdf mr-2"></i> Export to PDF
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-primary btn-block" onclick="window.print()">
                            <i class="fas fa-print mr-2"></i> Print Report
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reports.purchases', array_merge(request()->all(), ['download' => 'csv'])) }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-file-csv mr-2"></i> Export to CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Initialize DataTable
        $('#purchasesTable').DataTable({
            "paging": true
            , "lengthChange": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "autoWidth": false
            , "responsive": true
            , "order": [
                [1, 'desc']
            ] // Sort by date descending
        });

        // Date range validation
        $('#start_date, #end_date').change(function() {
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());

            if (startDate && endDate && startDate > endDate) {
                alert('Start date cannot be after end date');
                $('#end_date').val('');
            }
        });
    });

</script>
@endpush
