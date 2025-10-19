@extends('layouts.app')

@section('title', 'Balance Sheet')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Balance Sheet</h5>
                    <button onclick="window.print()" class="btn btn-secondary">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
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
                                    <h6 class="mb-0">Assets</h6>
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
                                    <h6 class="mb-0">Liabilities</h6>
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
                                    <h6 class="mb-0">Equity</h6>
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
                                    <h6 class="mb-0">Balance Sheet Summary</h6>
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
                                        <i class="fas fa-check-circle me-2"></i>
                                        Balance Sheet is balanced. Assets = Liabilities + Equity
                                    </div>
                                    @else
                                    <div class="alert alert-danger mt-3 mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
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
</div>
@endsection
