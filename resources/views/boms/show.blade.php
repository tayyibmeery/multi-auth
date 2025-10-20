@extends("layouts.app")

@section("title", $bom->name)

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $bom->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('boms.index') }}">BOMs</a></li>
                    <li class="breadcrumb-item active">{{ $bom->name }}</li>
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
                <!-- BOM Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>
                            BOM Information
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('boms.edit', $bom) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Name</dt>
                            <dd class="col-sm-8">{{ $bom->name }}</dd>

                            <dt class="col-sm-4">Product</dt>
                            <dd class="col-sm-8">{{ $bom->product->name }} ({{ $bom->product->code }})</dd>

                            <dt class="col-sm-4">Description</dt>
                            <dd class="col-sm-8">{{ $bom->description ?? "N/A" }}</dd>

                            <dt class="col-sm-4">Total Estimated Cost</dt>
                            <dd class="col-sm-8 font-weight-bold text-success">Rs {{ number_format($bom->total_estimated_cost, 2) }}</dd>

                            <dt class="col-sm-4">Spare Parts Count</dt>
                            <dd class="col-sm-8">{{ $bom->bomItems->count() }} Spare Parts</dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                @if ($bom->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Created</dt>
                            <dd class="col-sm-8">{{ $bom->created_at->format("M j, Y") }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Production Information -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-industry mr-2"></i>
                            Production Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Total Production Runs</dt>
                            <dd class="col-sm-6">{{ $bom->productionRuns->count() }}</dd>

                            <dt class="col-sm-6">Total Quantity Produced</dt>
                            <dd class="col-sm-6">{{ $bom->productionRuns->sum("actual_quantity") }} units</dd>

                            <dt class="col-sm-6">Last Production</dt>
                            <dd class="col-sm-6">
                                @if ($bom->productionRuns->count() > 0)
                                {{ $bom->productionRuns->last()->production_date->format("M j, Y") }}
                                @else
                                Never
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route("production-runs.create") }}?bom_id={{ $bom->id }}" class="btn btn-success btn-block">
                            <i class="fas fa-industry mr-1"></i> Start New Production Run
                        </a>
                    </div>
                </div>

                <!-- Cost Analysis -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-2"></i>
                            Cost Analysis
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-6">Material Cost</dt>
                            <dd class="col-sm-6">Rs {{ number_format($bom->total_estimated_cost, 2) }}</dd>

                            <dt class="col-sm-6">Product Price</dt>
                            <dd class="col-sm-6">Rs {{ number_format($bom->product->selling_price, 2) }}</dd>

                            <dt class="col-sm-6">Gross Margin</dt>
                            <dd class="col-sm-6 {{ $bom->product->selling_price - $bom->total_estimated_cost >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                Rs {{ number_format($bom->product->selling_price - $bom->total_estimated_cost, 2) }}
                            </dd>

                            <dt class="col-sm-6">Margin Percentage</dt>
                            <dd class="col-sm-6 {{ $bom->product->selling_price - $bom->total_estimated_cost >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                @if ($bom->product->selling_price > 0)
                                {{ number_format((($bom->product->selling_price - $bom->total_estimated_cost) / $bom->product->selling_price) * 100, 1) }}%
                                @else
                                N/A
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- BOM Spare Parts -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-2"></i>
                            BOM Spare Parts
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Spare Parts</th>
                                        <th>Current Stock</th>
                                        <th>Required Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Cost</th>
                                        <th>Stock Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bom->bomItems as $bomItem)
                                    @php
                                    $item = $bomItem->item;
                                    $requiredStock = $bomItem->quantity;
                                    $hasEnoughStock = $item->current_stock >= $requiredStock;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $item->name }}</div>
                                            <small class="text-muted">{{ $item->code }}</small>
                                        </td>
                                        <td>{{ $item->current_stock }} {{ $item->unit }}</td>
                                        <td>{{ $bomItem->quantity }} {{ $item->unit }}</td>
                                        <td>Rs {{ number_format($item->current_price, 2) }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($bomItem->quantity * $item->current_price, 2) }}</td>
                                        <td>
                                            @if ($hasEnoughStock)
                                            <span class="badge badge-success">Sufficient</span>
                                            @else
                                            <span class="badge badge-danger">Short: {{ $requiredStock - $item->current_stock }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="4" class="text-right font-weight-bold">Total Material Cost:</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($bom->total_estimated_cost, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Production Runs -->
                @if ($bom->productionRuns->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>
                            Recent Production Runs
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Batch No</th>
                                        <th>Date</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bom->productionRuns->take(5) as $run)
                                    <tr>
                                        <td class="font-weight-bold">{{ $run->batch_number }}</td>
                                        <td>{{ $run->production_date->format("M j, Y") }}</td>
                                        <td>{{ $run->actual_quantity ?? $run->quantity_to_produce }} units</td>
                                        <td>
                                            @if ($run->status === "completed")
                                            <span class="badge badge-success">Completed</span>
                                            @else
                                            <span class="badge badge-warning">{{ ucfirst($run->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route("production-runs.show", $run) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-center">
                        <a href="{{ route('boms.index') }}" class="btn btn-default mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to BOMs
                        </a>
                        <a href="{{ route('boms.edit', $bom) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit BOM
                        </a>
                        <a href="{{ route("production-runs.create") }}?bom_id={{ $bom->id }}" class="btn btn-success mr-2">
                            <i class="fas fa-play mr-1"></i> Start Production
                        </a>
                        <form action="{{ route('boms.destroy', $bom) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this BOM?')">
                                <i class="fas fa-trash mr-1"></i> Delete BOM
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
