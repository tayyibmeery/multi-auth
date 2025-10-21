@extends('layouts.app')

@section('title', 'Production Report')

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
                <h1 class="m-0">Production Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Production</li>
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
                <form method="GET" action="{{ route('reports.production') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', $startDate) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', $endDate) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group d-flex align-items-end">
                                <button type="submit" class="btn btn-info mr-2">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <a href="{{ route('reports.production') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo mr-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $productions->count() }}</h3>
                        <p>Total Runs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <a href="{{ route('reports.production') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $productions->where('status', 'completed')->count() }}</h3>
                        <p>Completed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('reports.production') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $productions->where('status', 'in_progress')->count() }}</h3>
                        <p>In Progress</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <a href="{{ route('reports.production') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $productions->where('status', 'cancelled')->count() }}</h3>
                        <p>Cancelled</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <a href="{{ route('reports.production') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Production Runs List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Production Runs</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($productions->count() > 0)
                <div class="table-responsive">
                    <table id="productionTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Batch Size</th>
                                <th>Actual Output</th>
                                <th>Status</th>
                                <th>Yield %</th>
                                <th>Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productions as $production)
                            <tr>
                                <td>{{ $production->id }}</td>
                                <td>{{ $production->production_date->format('M d, Y') }}</td>
                                <td>
                                    {{ $production->billOfMaterial->product->name ?? 'N/A' }}
                                </td>
                                <td class="text-right">{{ number_format($production->batch_size, 2) }}</td>
                                <td class="text-right">{{ number_format($production->actual_output, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{
                                        $production->status == 'completed' ? 'success' :
                                        ($production->status == 'in_progress' ? 'warning' :
                                        ($production->status == 'planned' ? 'info' : 'danger'))
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $production->status)) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    @if($production->batch_size > 0)
                                    {{ number_format(($production->actual_output / $production->batch_size) * 100, 1) }}%
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ number_format($production->production_cost, 2) }}
                                </td>
                                <td>
                                    <a href="{{ route('production-runs.show', $production->id) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="3" class="text-right"><strong>Totals:</strong></td>
                                <td class="text-right"><strong>{{ number_format($productions->sum('batch_size'), 2) }}</strong></td>
                                <td class="text-right"><strong>{{ number_format($productions->sum('actual_output'), 2) }}</strong></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><strong>{{ number_format($productions->sum('production_cost'), 2) }}</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="alert alert-info text-center">
                    <h5><i class="icon fas fa-info"></i> No production runs found</h5>
                    <p>No production records match the selected criteria.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Summary Statistics -->
        @if($productions->count() > 0)
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Production Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Total Batch Size</p>
                                <h3>{{ number_format($productions->sum('batch_size'), 2) }}</h3>
                            </div>
                            <div class="col-6">
                                <p class="text-muted">Total Actual Output</p>
                                <h3>{{ number_format($productions->sum('actual_output'), 2) }}</h3>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <p class="text-muted">Average Yield</p>
                                <h3>
                                    @php
                                    $totalBatch = $productions->sum('batch_size');
                                    $totalOutput = $productions->sum('actual_output');
                                    $averageYield = $totalBatch > 0 ? ($totalOutput / $totalBatch) * 100 : 0;
                                    @endphp
                                    {{ number_format($averageYield, 1) }}%
                                </h3>
                            </div>
                            <div class="col-6">
                                <p class="text-muted">Total Cost</p>
                                <h3>{{ number_format($productions->sum('production_cost'), 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Status Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Options -->
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
                        <a href="{{ route('reports.production', array_merge(request()->all(), ['download' => 'csv'])) }}" class="btn btn-secondary btn-block">
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
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#productionTable').DataTable({
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

        // Status Chart
        @if($productions -> count() > 0)
        var statusData = {
            labels: ['Completed', 'In Progress', 'Planned', 'Cancelled']
            , datasets: [{
                data: [{
                        {
                            $productions - > where('status', 'completed') - > count()
                        }
                    }
                    , {
                        {
                            $productions - > where('status', 'in_progress') - > count()
                        }
                    }
                    , {
                        {
                            $productions - > where('status', 'planned') - > count()
                        }
                    }
                    , {
                        {
                            $productions - > where('status', 'cancelled') - > count()
                        }
                    }
                ]
                , backgroundColor: [
                    '#28a745'
                    , '#ffc107'
                    , '#17a2b8'
                    , '#dc3545'
                ]
            }]
        };

        var ctx = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(ctx, {
            type: 'doughnut'
            , data: statusData
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , legend: {
                    position: 'bottom'
                }
            }
        });
        @endif
    });

</script>
@endpush
