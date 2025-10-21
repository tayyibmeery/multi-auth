@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Admin Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Admin Dashboard</li>
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
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($stats['total_revenue'], 2) }}</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['total_products'] }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats['total_customers'] }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Accounting Summary -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Accounting Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Cash Balance</span>
                                        <span class="info-box-number">{{ number_format($accountingStats['cash_balance'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-university"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Bank Balance</span>
                                        <span class="info-box-number">{{ number_format($accountingStats['bank_balance'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Assets</span>
                                        <span class="info-box-number">{{ number_format($accountingStats['total_assets'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-balance-scale"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Liabilities</span>
                                        <span class="info-box-number">{{ number_format($accountingStats['total_liabilities'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">View All</a>
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
                                        {{ $sale->customer->name ?? 'N/A' }} - {{ $sale->created_at->format('M d, Y') }}
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
                        <h3 class="card-title">Recent Accounting Vouchers</h3>
                        <div class="card-tools">
                            <a href="{{ route('accounting-vouchers.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($recentVouchers as $voucher)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        Voucher #{{ $voucher->id }}
                                        <span class="float-right text-warning">{{ number_format($voucher->amount, 2) }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $voucher->account->name ?? 'N/A' }} - {{ $voucher->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                            @if($recentVouchers->isEmpty())
                            <li class="item">
                                <div class="product-info">
                                    <span class="product-description text-muted">No recent vouchers</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Vendors and Customers -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top Vendors</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($topVendors as $vendor)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        {{ $vendor->name }}
                                        <span class="float-right text-info">{{ $vendor->purchases_count }} purchases</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $vendor->email ?? 'No email' }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                            @if($topVendors->isEmpty())
                            <li class="item">
                                <div class="product-info">
                                    <span class="product-description text-muted">No vendors found</span>
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
                        <h3 class="card-title">Top Customers</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($topCustomers as $customer)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        {{ $customer->name }}
                                        <span class="float-right text-success">{{ $customer->sales_count }} sales</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $customer->email ?? 'No email' }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                            @if($topCustomers->isEmpty())
                            <li class="item">
                                <div class="product-info">
                                    <span class="product-description text-muted">No customers found</span>
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
        console.log('Admin dashboard loaded');
    });

</script>
@endpush
