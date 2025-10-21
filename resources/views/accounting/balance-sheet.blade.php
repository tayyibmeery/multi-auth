@extends('layouts.app')

@section('title', 'Balance Sheet')

@push('styles')
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Balance Sheet</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item active">Balance Sheet</li>
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
                            <i class="fas fa-balance-scale-left mr-2"></i>
                            Balance Sheet Report
                        </h3>
                        <div class="card-tools">
                            <button onclick="window.print()" class="btn btn-sm btn-secondary">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <h4>Balance Sheet</h4>
                                <p class="text-muted">As of {{ now()->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Assets -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-wallet mr-2"></i>Assets</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($assets as $asset)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>{{ $asset->name }}:</span>
                                            <strong>Rs {{ number_format($asset->current_balance, 2) }}</strong>
                                        </div>
                                        @endforeach
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <strong>Total Assets:</strong>
                                            <strong>Rs {{ number_format($totalAssets, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Liabilities & Equity -->
                            <div class="col-md-6">
                                <!-- Liabilities -->
                                <div class="card mb-3">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0"><i class="fas fa-hand-holding-usd mr-2"></i>Liabilities</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($liabilities as $liability)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>{{ $liability->name }}:</span>
                                            <strong>Rs {{ number_format($liability->current_balance, 2) }}</strong>
                                        </div>
                                        @endforeach
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <strong>Total Liabilities:</strong>
                                            <strong>Rs {{ number_format($totalLiabilities, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Equity -->
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Equity</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($equity as $eq)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>{{ $eq->name }}:</span>
                                            <strong>Rs {{ number_format($eq->current_balance, 2) }}</strong>
                                        </div>
                                        @endforeach
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <strong>Total Equity:</strong>
                                            <strong>Rs {{ number_format($totalEquity, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="row mt-4">
                            <div class="col-md-6 offset-md-3">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-calculator mr-2"></i>Balance Sheet Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Assets:</span>
                                            <strong>Rs {{ number_format($totalAssets, 2) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Liabilities & Equity:</span>
                                            <strong>Rs {{ number_format($totalLiabilities + $totalEquity, 2) }}</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <strong>Difference:</strong>
                                            <strong class="{{ $totalAssets == ($totalLiabilities + $totalEquity) ? 'text-success' : 'text-danger' }}">
                                                Rs {{ number_format($totalAssets - ($totalLiabilities + $totalEquity), 2) }}
                                            </strong>
                                        </div>

                                        @if($totalAssets == ($totalLiabilities + $totalEquity))
                                        <div class="alert alert-success mt-3 mb-0">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Balance Sheet is balanced. Assets = Liabilities + Equity
                                        </div>
                                        @else
                                        <div class="alert alert-danger mt-3 mb-0">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Balance Sheet is not balanced!
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
