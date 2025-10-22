@extends('layouts.app')

@section('title', $item->name . ' - Stock Ledger')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $item->name }} - Stock Ledger</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Spare Parts</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.show', $item) }}">{{ $item->name }}</a></li>
                    <li class="breadcrumb-item active">Stock Ledger</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Item Summary Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-box"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Current Stock</span>
                        <span class="info-box-number">{{ $item->current_stock }} {{ $item->unit }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Current Price</span>
                        <span class="info-box-number">Rs {{ number_format($item->current_price, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-calculator"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stock Value</span>
                        <span class="info-box-number">Rs {{ number_format($item->stock_value, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Minimum Stock</span>
                        <span class="info-box-number">{{ $item->min_stock }} {{ $item->unit }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Summary -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $ledgers->total() }}</h3>
                        <p>Total Transactions</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalIn ?? 0 }}</h3>
                        <p>Total Quantity In</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalOut ?? 0 }}</h3>
                        <p>Total Quantity Out</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Spare Part
                    </a>
                    <a href="{{ route('stock-ledgers.index') }}" class="btn btn-primary">
                        <i class="fas fa-list mr-1"></i> All Ledgers
                    </a>
                </div>
            </div>
        </div>

        <!-- Stock Ledger Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stock Movement History</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="itemLedgerTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th>Quantity In</th>
                                <th>Quantity Out</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th>Stock After</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ledgers as $ledger)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ledger->date)->format('M j, Y') }}</td>
                                <td>
                                    <span class="badge badge-{{
                                        $ledger->type == 'purchase' ? 'success' :
                                        ($ledger->type == 'production_output' ? 'info' :
                                        ($ledger->type == 'production_usage' ? 'warning' :
                                        ($ledger->type == 'adjustment' ? 'primary' : 'danger')))
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $ledger->type)) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $ledger->reference_type }} #{{ $ledger->reference_id }}</small>
                                </td>
                                <td class="text-success font-weight-bold">
                                    @if($ledger->quantity_in > 0)
                                    +{{ $ledger->quantity_in }}
                                    @endif
                                </td>
                                <td class="text-danger font-weight-bold">
                                    @if($ledger->quantity_out > 0)
                                    -{{ $ledger->quantity_out }}
                                    @endif
                                </td>
                                <td>Rs {{ number_format($ledger->unit_cost, 2) }}</td>
                                <td>Rs {{ number_format($ledger->total_cost, 2) }}</td>
                                <td>{{ $ledger->stock_after_transaction }} {{ $item->unit }}</td>
                                <td>
                                    <small class="text-muted">{{ $ledger->notes }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No stock movements recorded for this Spare Part.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($ledgers->hasPages())
                <div class="card-footer clearfix">
                    {{ $ledgers->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#itemLedgerTable').DataTable({
            "paging": true
            , "lengthChange": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "autoWidth": false
            , "responsive": true
            , "order": [
                [0, 'desc']
            ] // Sort by date descending
        });
    });

</script>
@endpush
