@extends('layouts.app')

@section('title', 'Income Statement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Income Statement</h5>
                    <div>
                        <form method="GET" class="d-inline">
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                <span class="input-group-text">to</span>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                        <button onclick="window.print()" class="btn btn-secondary ms-2">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
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
                                    <h6 class="mb-0">Revenue</h6>
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
                                    <h6 class="mb-0">Expenses</h6>
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
                                    <h6 class="mb-0">Net Income</h6>
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
</div>
@endsection
