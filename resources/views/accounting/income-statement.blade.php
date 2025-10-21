@extends('layouts.app')

@section('title', 'Income Statement')

@push('styles')
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Income Statement</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item active">Income Statement</li>
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
                            <i class="fas fa-chart-line mr-2"></i>
                            Income Statement
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <form method="GET" class="form-inline">
                                    <div class="input-group input-group-sm">
                                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                        <span class="input-group-text">to</span>
                                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter"></i>
                                        </button>
                                    </div>
                                </form>
                                <button onclick="window.print()" class="btn btn-sm btn-secondary ml-2">
                                    <i class="fas fa-print mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 offset-md-3 text-center">
                                <h4>Income Statement</h4>
                                <p class="text-muted">
                                    For the period: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}
                                    to {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <!-- Revenue -->
                                <div class="card mb-3">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Revenue</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span>Total Revenue:</span>
                                            <strong>Rs {{ number_format($revenue, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Expenses -->
                                <div class="card mb-3">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0"><i class="fas fa-receipt mr-2"></i>Expenses</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span>Total Expenses:</span>
                                            <strong>Rs {{ number_format($expenses, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Net Income -->
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-calculator mr-2"></i>Net Income</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span>Net Income (Revenue - Expenses):</span>
                                            <strong class="{{ $netIncome >= 0 ? 'text-success' : 'text-danger' }}">
                                                Rs {{ number_format($netIncome, 2) }}
                                            </strong>
                                        </div>
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
