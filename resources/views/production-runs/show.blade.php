@extends("layouts.app")

@section("title", $productionRun->batch_number)

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Production Run: {{ $productionRun->batch_number }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('production-runs.index') }}">Production Runs</a></li>
                    <li class="breadcrumb-item active">{{ $productionRun->batch_number }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- Production Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>
                            Production Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Batch Number</dt>
                            <dd class="col-sm-8">{{ $productionRun->batch_number }}</dd>

                            <dt class="col-sm-4">Product</dt>
                            <dd class="col-sm-8">{{ $productionRun->billOfMaterial->product->name }}</dd>

                            <dt class="col-sm-4">BOM Used</dt>
                            <dd class="col-sm-8">{{ $productionRun->billOfMaterial->name }}</dd>

                            <dt class="col-sm-4">Target Quantity</dt>
                            <dd class="col-sm-8">{{ $productionRun->quantity_to_produce }} units</dd>

                            <dt class="col-sm-4">Actual Quantity</dt>
                            <dd class="col-sm-8 {{ $productionRun->actual_quantity ? 'text-success' : 'text-muted' }} font-weight-bold">
                                {{ $productionRun->actual_quantity ?? "Not recorded" }} units
                            </dd>

                            <dt class="col-sm-4">Production Date</dt>
                            <dd class="col-sm-8">{{ $productionRun->production_date->format("M j, Y") }}</dd>

                            <dt class="col-sm-4">Completion Date</dt>
                            <dd class="col-sm-8">
                                {{ $productionRun->completion_date ? $productionRun->completion_date->format("M j, Y") : "Not completed" }}
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Status & Cost -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-2"></i>
                            Status & Cost
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                @if ($productionRun->status === "completed")
                                <span class="badge badge-success">Completed</span>
                                @elseif($productionRun->status === "in_progress")
                                <span class="badge badge-warning">In Progress</span>
                                @else
                                <span class="badge badge-secondary">{{ ucfirst($productionRun->status) }}</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Total Material Cost</dt>
                            <dd class="col-sm-8 font-weight-bold text-success">
                                Rs {{ number_format($productionRun->total_production_cost, 2) }}
                            </dd>

                            <dt class="col-sm-4">Cost Per Unit</dt>
                            <dd class="col-sm-8">
                                @if ($productionRun->actual_quantity)
                                Rs {{ number_format($productionRun->total_production_cost / $productionRun->actual_quantity, 2) }}
                                @else
                                N/A
                                @endif
                            </dd>

                            <dt class="col-sm-4">Created By</dt>
                            <dd class="col-sm-8">{{ $productionRun->user->name }}</dd>

                            <dt class="col-sm-4">Created On</dt>
                            <dd class="col-sm-8">{{ $productionRun->created_at->format("M j, Y g:i A") }}</dd>
                        </dl>

                        @if ($productionRun->notes)
                        <div class="mt-3 border-top pt-3">
                            <dt class="font-weight-bold text-muted">Notes</dt>
                            <dd class="mt-1">{{ $productionRun->notes }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-2"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('boms.show', $productionRun->billOfMaterial) }}" class="btn btn-purple btn-block">
                                    <i class="fas fa-list-alt mr-2"></i>View BOM Details
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('products.show', $productionRun->billOfMaterial->product) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-cube mr-2"></i>View Product
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('stock-ledgers.index') }}?reference_id={{ $productionRun->id }}&reference_type=production_run" class="btn btn-success btn-block">
                                    <i class="fas fa-history mr-2"></i>View Stock Impact
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Materials Used -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tools mr-2"></i>
                            Materials Used
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Material</th>
                                        <th>Quantity Used</th>
                                        <th>Unit Cost</th>
                                        <th>Total Cost</th>
                                        <th>Stock Before</th>
                                        <th>Stock After</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $usageLedgers = $productionRun->stockLedgers->where("type", "production_usage");
                                    @endphp
                                    @foreach ($usageLedgers as $ledger)
                                    @php
                                    $stockBefore = $ledger->stock_after_transaction + $ledger->quantity_out;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $ledger->item->name }}</div>
                                            <small class="text-muted">{{ $ledger->item->code }}</small>
                                        </td>
                                        <td class="font-weight-bold text-danger">-{{ $ledger->quantity_out }} {{ $ledger->item->unit }}</td>
                                        <td>Rs {{ number_format($ledger->unit_cost, 2) }}</td>
                                        <td class="font-weight-bold">Rs {{ number_format($ledger->total_cost, 2) }}</td>
                                        <td>{{ $stockBefore }} {{ $ledger->item->unit }}</td>
                                        <td>{{ $ledger->stock_after_transaction }} {{ $ledger->item->unit }}</td>
                                    </tr>
                                    @endforeach
                                    @if ($usageLedgers->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-box-open fa-2x mb-2"></i>
                                            <p>No material usage recorded.</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                                @if ($usageLedgers->count() > 0)
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total Material Cost:</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($usageLedgers->sum("total_cost"), 2) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Products Produced -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cube mr-2"></i>
                            Products Produced
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity Produced</th>
                                        <th>Unit Cost</th>
                                        <th>Total Value</th>
                                        <th>Stock Before</th>
                                        <th>Stock After</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $outputLedgers = $productionRun->stockLedgers->where("type", "production_output");
                                    @endphp
                                    @foreach ($outputLedgers as $ledger)
                                    @php
                                    $stockBefore = $ledger->stock_after_transaction - $ledger->quantity_in;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $ledger->product->name }}</div>
                                            <small class="text-muted">{{ $ledger->product->code }}</small>
                                        </td>
                                        <td class="font-weight-bold text-success">+{{ $ledger->quantity_in }} units</td>
                                        <td>Rs {{ number_format($ledger->unit_cost, 2) }}</td>
                                        <td class="font-weight-bold">Rs {{ number_format($ledger->total_cost, 2) }}</td>
                                        <td>{{ $stockBefore }} units</td>
                                        <td>{{ $ledger->stock_after_transaction }} units</td>
                                    </tr>
                                    @endforeach
                                    @if ($outputLedgers->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-industry fa-2x mb-2"></i>
                                            <p>No products produced recorded.</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-center">
                        <a href="{{ route('production-runs.index') }}" class="btn btn-default mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Production
                        </a>
                        <a href="{{ route('production-runs.create') }}?bom_id={{ $productionRun->bom_id }}" class="btn btn-primary mr-2">
                            <i class="fas fa-redo mr-1"></i> Repeat Production
                        </a>
                        @if($productionRun->status !== 'completed')
                        <form action="{{ route('production-runs.destroy', $productionRun) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this production run?')">
                                <i class="fas fa-times mr-1"></i> Cancel Production
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
