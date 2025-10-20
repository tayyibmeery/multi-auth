@extends("layouts.app")

@section("title", $product->name)

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $product->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Product Information Row -->
        <div class="row">
            <!-- Product Details -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Product Information
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <strong><i class="fas fa-tag mr-1"></i> Name</strong>
                                <p class="text-muted">{{ $product->name }}</p>
                                <hr>

                                <strong><i class="fas fa-barcode mr-1"></i> Code</strong>
                                <p class="text-muted">{{ $product->code }}</p>
                                <hr>

                                <strong><i class="fas fa-align-left mr-1"></i> Description</strong>
                                <p class="text-muted">{{ $product->description ?? "N/A" }}</p>
                                <hr>

                                <strong><i class="fas fa-calendar mr-1"></i> Created</strong>
                                <p class="text-muted">{{ $product->created_at->format('M j, Y') }}</p>
                                <hr>

                                <strong><i class="fas fa-sync mr-1"></i> Last Updated</strong>
                                <p class="text-muted">{{ $product->updated_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('products.index') }}" class="btn btn-default btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock & Pricing -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Stock & Pricing
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="small-box bg-gradient-success">
                            <div class="inner">
                                <h3>Rs {{ number_format($product->stock_value, 2) }}</h3>
                                <p>Total Stock Value</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header {{ $product->current_stock == 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $product->current_stock }}
                                    </h5>
                                    <span class="description-text">CURRENT STOCK</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="description-block">
                                    <h5 class="description-header text-success">Rs {{ number_format($product->selling_price, 2) }}</h5>
                                    <span class="description-text">SELLING PRICE</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="mt-3 text-center">
                            @if($product->current_stock == 0)
                            <span class="badge badge-danger p-2">Out of Stock</span>
                            @else
                            <span class="badge badge-success p-2">In Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Quick Actions
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('production-runs.create') }}?product_id={{ $product->id }}" class="btn btn-primary btn-block">
                                <i class="fas fa-industry mr-1"></i> Start Production
                            </a>

                            <a href="{{ route('stock-ledgers.product', $product->id) }}" class="btn btn-info btn-block">
                                <i class="fas fa-history mr-1"></i> View Stock History
                            </a>

                            <a href="{{ route('boms.create') }}?product_id={{ $product->id }}" class="btn btn-purple btn-block">
                                <i class="fas fa-list-alt mr-1"></i> Create BOM
                            </a>
                        </div>

                        <!-- BOM Information -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="text-center mb-3">
                                <i class="fas fa-list-alt mr-1"></i>
                                BOM Information
                            </h5>
                            <div class="row text-center">
                                <div class="col-12">
                                    <div class="info-box bg-gradient-purple">
                                        <span class="info-box-icon"><i class="fas fa-industry"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Bill of Materials</span>
                                            <span class="info-box-number">{{ $product->billOfMaterials->count() }} BOM(s)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill of Materials -->
        @if($product->billOfMaterials->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list-alt mr-1"></i>
                            Bill of Materials ({{ $product->billOfMaterials->count() }})
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="bomTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>BOM Name</th>
                                        <th>Spare Parts Count</th>
                                        <th>Estimated Cost</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->billOfMaterials as $bom)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $bom->name }}</div>
                                            <small class="text-muted">{{ $bom->description ?? "N/A" }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $bom->bomItems->count() }} Spare Parts</span>
                                        </td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($bom->total_estimated_cost, 2) }}</td>
                                        <td>
                                            @if($bom->is_active)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('boms.show', $bom) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('production-runs.create') }}?bom_id={{ $bom->id }}" class="btn btn-sm btn-success" title="Use for Production">
                                                    <i class="fas fa-play"></i> Use
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Stock Movements -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-1"></i>
                            Recent Stock Movements
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($product->stockLedgers->count() > 0)
                        <div class="table-responsive">
                            <table id="stockMovementsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Quantity In</th>
                                        <th>Quantity Out</th>
                                        <th>Stock After</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->stockLedgers->take(10) as $ledger)
                                    <tr>
                                        <td>{{ $ledger->date->format('M j, Y') }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $ledger->type)) }}</span>
                                        </td>
                                        <td class="text-success font-weight-bold">
                                            @if($ledger->quantity_in > 0)
                                            +{{ $ledger->quantity_in }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="text-danger font-weight-bold">
                                            @if($ledger->quantity_out > 0)
                                            -{{ $ledger->quantity_out }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">{{ $ledger->stock_after_transaction }}</td>
                                        <td>{{ $ledger->notes }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('stock-ledgers.product', $product->id) }}" class="btn btn-default">
                                View Full Stock History <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-2x text-muted mb-3"></i>
                            <h5 class="text-muted">No stock movements recorded yet</h5>
                            <p class="text-muted">Stock movements will appear here after production or sales</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(function() {
        // Initialize DataTable for BOM
        $("#bomTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 5
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search BOM..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        // Initialize DataTable for stock movements
        $("#stockMovementsTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 5
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search movements..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
