@extends('layouts.app')

@section('title', 'Sales Report')

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
                <h1 class="m-0">Sales Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Sales</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Date Filter -->
        <div class="card card-info">
            <div class="card-header border-bottom-0">
                <h3 class="card-title">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Report
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.sales') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $sales->count() }}</h3>
                        <p>Total Sales Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalSales, 2) }}</h3>
                        <p>Total Sales Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalProfit, 2) }}</h3>
                        <p>Total Profit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Sales Table -->
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Sales Details
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table id="salesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sale #</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Subtotal</th>
                                        <th>Tax</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>Profit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $sale->sale_number }}</td>
                                        <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $sale->customer->name ?? 'Walk-in Customer' }}</div>
                                        </td>
                                        <td class="font-weight-bold">{{ $sale->saleItems->count() }}</td>
                                        <td>Rs {{ number_format($sale->subtotal, 2) }}</td>
                                        <td>Rs {{ number_format($sale->tax_amount, 2) }}</td>
                                        <td class="text-danger">Rs {{ number_format($sale->discount_amount, 2) }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($sale->total_amount, 2) }}</td>
                                        <td class="font-weight-bold text-info">Rs {{ number_format($sale->profit_margin, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $sale->sale_status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($sale->sale_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="7" class="text-right font-weight-bold">Grand Total:</td>
                                        <td class="font-weight-bold text-primary">Rs {{ number_format($totalSales, 2) }}</td>
                                        <td class="font-weight-bold text-info">Rs {{ number_format($totalProfit, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Sales Found</h4>
                            <p class="text-muted">No sales data available for the selected period.</p>
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
        $("#salesTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
        });
    });

</script>
@endpush
