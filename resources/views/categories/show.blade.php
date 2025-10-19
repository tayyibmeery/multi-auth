@extends("layouts.app")

@section("title", $category->name)

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
                <h1>{{ $category->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Category Information Row -->
        <div class="row">
            <!-- Category Details -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Category Information
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
                                <p class="text-muted">{{ $category->name }}</p>
                                <hr>

                                <strong><i class="fas fa-align-left mr-1"></i> Description</strong>
                                <p class="text-muted">{{ $category->description ?? "N/A" }}</p>
                                <hr>

                                <strong><i class="fas fa-cubes mr-1"></i> Spare Parts Count</strong>
                                <p class="text-muted">{{ $category->items_count }} Items</p>
                                <hr>

                                <strong><i class="fas fa-calendar mr-1"></i> Created</strong>
                                <p class="text-muted">{{ $category->created_at->format('M j, Y') }}</p>
                                <hr>

                                <strong><i class="fas fa-sync mr-1"></i> Last Updated</strong>
                                <p class="text-muted">{{ $category->updated_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('categories.index') }}" class="btn btn-default btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Category Statistics
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
                                <h3>Rs {{ number_format($category->items->sum('stock_value'), 2) }}</h3>
                                <p>Total Stock Value</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $category->items_count }}</h5>
                                    <span class="description-text">TOTAL ITEMS</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        @if($category->items_count > 0)
                                        Rs {{ number_format($category->items->avg('current_price'), 2) }}
                                        @else
                                        Rs 0.00
                                        @endif
                                    </h5>
                                    <span class="description-text">AVG PRICE</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Health -->
                        <div class="progress-group mt-3">
                            Stock Health
                            @php
                            $healthyItems = $category->items->where('current_stock', '>', 0)->where('current_stock', '>', \DB::raw('min_stock'))->count();
                            $healthPercentage = $category->items_count > 0 ? ($healthyItems / $category->items_count) * 100 : 0;
                            @endphp
                            <span class="float-right"><b>{{ $healthyItems }}</b>/{{ $category->items_count }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: {{ $healthPercentage }}%"></div>
                            </div>
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
                            <a href="{{ route('items.create') }}?category_id={{ $category->id }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus mr-1"></i> Add Spare Part
                            </a>

                            <a href="{{ route('items.index') }}?category_id={{ $category->id }}" class="btn btn-info btn-block">
                                <i class="fas fa-list mr-1"></i> View All Items
                            </a>
                        </div>

                        <!-- Stock Summary -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="text-center mb-3">
                                <i class="fas fa-boxes mr-1"></i>
                                Stock Summary
                            </h5>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="info-box bg-gradient-success">
                                        <span class="info-box-icon"><i class="fas fa-check"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">In Stock</span>
                                            <span class="info-box-number">{{ $category->items->where('current_stock', '>', 0)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="info-box bg-gradient-warning">
                                        <span class="info-box-icon"><i class="fas fa-exclamation"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Low Stock</span>
                                            <span class="info-box-number">{{ $category->items->where('is_low_stock', true)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="info-box bg-gradient-danger">
                                        <span class="info-box-icon"><i class="fas fa-times"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Out of Stock</span>
                                            <span class="info-box-number">{{ $category->items->where('current_stock', 0)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spare Parts in this Category -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cubes mr-1"></i>
                            Spare Parts in this Category ({{ $category->items_count }})
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('items.create') }}?category_id={{ $category->id }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Add Spare Part
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($category->items_count > 0)
                        <div class="table-responsive">
                            <table id="itemsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Code</th>
                                        <th>Current Stock</th>
                                        <th>Min Stock</th>
                                        <th>Price</th>
                                        <th>Stock Value</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->items as $item)
                                    <tr>
                                        <td class="font-weight-bold">{{ $item->name }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $item->current_stock }} {{ $item->unit }}</div>
                                        </td>
                                        <td>{{ $item->min_stock }} {{ $item->unit }}</td>
                                        <td class="text-success font-weight-bold">Rs {{ number_format($item->current_price, 2) }}</td>
                                        <td class="text-info font-weight-bold">Rs {{ number_format($item->stock_value, 2) }}</td>
                                        <td>
                                            @if($item->current_stock == 0)
                                            <span class="badge badge-danger">Out of Stock</span>
                                            @elseif($item->is_low_stock)
                                            <span class="badge badge-warning">Low Stock</span>
                                            @else
                                            <span class="badge badge-success">In Stock</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('items.show', $item) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-cubes fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No spare parts in this category yet</h5>
                            <p class="text-muted mb-4">Start by adding spare parts to this category</p>
                            <a href="{{ route('items.create') }}?category_id={{ $category->id }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i> Add First Spare Part
                            </a>
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
        // Initialize DataTable for items
        $("#itemsTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search items..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
