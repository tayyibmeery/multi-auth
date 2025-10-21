@extends('layouts.app')

@section('title', 'Reports Dashboard')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reports Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($todaySales, 2) }}</h3>
                        <p>Today's Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($monthSales, 2) }}</h3>
                        <p>Monthly Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($todayPurchases, 2) }}</h3>
                        <p>Today's Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <a href="{{ route('reports.purchases') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $lowStockItems + $lowStockProducts }}</h3>
                        <p>Low Stock Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('reports.low-stock') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Report Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-chart-bar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales Report</span>
                        <span class="info-box-number">Detailed Analysis</span>
                        <a href="{{ route('reports.sales') }}" class="btn btn-sm btn-info mt-2">View Report</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stock Report</span>
                        <span class="info-box-number">Inventory Levels</span>
                        <a href="{{ route('reports.stock') }}" class="btn btn-sm btn-success mt-2">View Report</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Purchase Report</span>
                        <span class="info-box-number">Vendor Purchases</span>
                        <a href="{{ route('reports.purchases') }}" class="btn btn-sm btn-warning mt-2">View Report</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-industry"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Production Report</span>
                        <span class="info-box-number">Manufacturing</span>
                        <a href="{{ route('reports.production') }}" class="btn btn-sm btn-primary mt-2">View Report</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Low Stock Alert</span>
                        <span class="info-box-number">{{ $lowStockItems + $lowStockProducts }} Items</span>
                        <a href="{{ route('reports.low-stock') }}" class="btn btn-sm btn-danger mt-2">View Report</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stock Valuation</span>
                        <span class="info-box-number">Total Value</span>
                        <a href="{{ route('reports.stock-valuation') }}" class="btn btn-sm btn-secondary mt-2">View Report</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Sales</h3>
                        <div class="card-tools">
                            <a href="{{ route('reports.sales') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($recentSales as $sale)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        Sale #{{ $sale->id }}
                                        <span class="float-right text-success">{{ number_format($sale->total_amount, 2) }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $sale->customer->name ?? 'N/A' }} - {{ $sale->sale_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                            @if($recentSales->isEmpty())
                            <li class="item">
                                <div class="product-info">
                                    <span class="product-description text-muted">No recent sales</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Purchases</h3>
                        <div class="card-tools">
                            <a href="{{ route('reports.purchases') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($recentPurchases as $purchase)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        Purchase #{{ $purchase->id }}
                                        <span class="float-right text-warning">{{ number_format($purchase->total_amount, 2) }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $purchase->vendor->name ?? 'N/A' }} - {{ $purchase->purchase_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                            @if($recentPurchases->isEmpty())
                            <li class="item">
                                <div class="product-info">
                                    <span class="product-description text-muted">No recent purchases</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Add any JavaScript for the reports dashboard here
        console.log('Reports dashboard loaded');
    });

</script>
@endpush
