@extends('layouts.app')

@section('title', 'Stock Ledger')

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
                <h1>Stock Ledger</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stock Ledger</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Filters Card -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Stock Ledger
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('stock-ledgers.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type">Transaction Type</label>
                                <select name="type" id="type" class="form-control select2">
                                    <option value="">All Types</option>
                                    <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Purchase</option>
                                    <option value="production_usage" {{ request('type') == 'production_usage' ? 'selected' : '' }}>Production Usage</option>
                                    <option value="production_output" {{ request('type') == 'production_output' ? 'selected' : '' }}>Production Output</option>
                                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="item_id">Spare Part</label>
                                <select name="item_id" id="item_id" class="form-control select2">
                                    <option value="">All Spare Parts</option>
                                    @foreach(\App\Models\Item::all() as $item)
                                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->code }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_from">From Date</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_to">To Date</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <a href="{{ route('stock-ledgers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times mr-1"></i> Clear Filters
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter mr-1"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stock Ledger Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stock Ledger Entries</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="stockLedgerTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Spare Part/Product</th>
                                <th>Reference</th>
                                <th>Quantity In</th>
                                <th>Quantity Out</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th>Stock After</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockLedgers as $ledger)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ledger->date)->format('d M, Y') }}</td>
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
                                    @if($ledger->item)
                                    <div class="font-weight-bold">{{ $ledger->item->name }}</div>
                                    <small class="text-muted">{{ $ledger->item->code }}</small>
                                    @elseif($ledger->product)
                                    <div class="font-weight-bold">{{ $ledger->product->name }}</div>
                                    <small class="text-muted">{{ $ledger->product->code }}</small>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
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
                                <td>{{ $ledger->stock_after_transaction }}</td>
                                <td>
                                    <small class="text-muted">{{ $ledger->user->name }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No stock movements found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stockLedgers->hasPages())
                <div class="card-footer clearfix">
                    {{ $stockLedgers->links() }}
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
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Initialize DataTable
        $('#stockLedgerTable').DataTable({
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

        // Date validation
        $('#date_from, #date_to').change(function() {
            var startDate = new Date($('#date_from').val());
            var endDate = new Date($('#date_to').val());

            if (startDate && endDate && startDate > endDate) {
                alert('Start date cannot be after end date');
                $('#date_to').val('');
            }
        });
    });

</script>
@endpush
