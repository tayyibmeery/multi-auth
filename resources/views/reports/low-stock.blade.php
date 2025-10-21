@extends('layouts.app')

@section('title', 'Low Stock Report')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Low Stock Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Low Stock</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $outOfStockItems->count() + $outOfStockProducts->count() }}</h3>
                        <p>Out of Stock Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="#out-of-stock" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $lowStockItems->count() + $lowStockProducts->count() }}</h3>
                        <p>Low Stock Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="#low-stock" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $lowStockItems->count() }}</h3>
                        <p>Low Stock Spare Parts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <a href="#spare-parts" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $lowStockProducts->count() }}</h3>
                        <p>Low Stock Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <a href="#products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Out of Stock Section -->
                <div class="card card-danger" id="out-of-stock">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Out of Stock Items
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($outOfStockItems->count() > 0 || $outOfStockProducts->count() > 0)
                        <!-- Out of Stock Spare Parts -->
                        @if($outOfStockItems->count() > 0)
                        <h5 class="font-weight-bold text-dark mb-3">
                            <i class="fas fa-boxes mr-2"></i>Spare Parts
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Min Stock</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outOfStockItems as $item)
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $item->name }}</td>
                                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                                        <td class="text-danger font-weight-bold">{{ number_format($item->current_stock, 2) }}</td>
                                        <td>{{ number_format($item->min_stock, 2) }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($item->current_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <!-- Out of Stock Products -->
                        @if($outOfStockProducts->count() > 0)
                        <h5 class="font-weight-bold text-dark mb-3 mt-4">
                            <i class="fas fa-cube mr-2"></i>Products
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Min Stock</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outOfStockProducts as $product)
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td class="text-danger font-weight-bold">{{ number_format($product->current_stock, 2) }}</td>
                                        <td>{{ number_format($product->min_stock, 2) }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4 class="text-success">No Out of Stock Items</h4>
                            <p class="text-muted">All items are currently in stock.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Low Stock Section -->
                <div class="card card-warning" id="low-stock">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-clock mr-2"></i>
                            Low Stock Items
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($lowStockItems->count() > 0 || $lowStockProducts->count() > 0)
                        <!-- Low Stock Spare Parts -->
                        @if($lowStockItems->count() > 0)
                        <h5 class="font-weight-bold text-dark mb-3">
                            <i class="fas fa-boxes mr-2"></i>Spare Parts
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Min Stock</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockItems as $item)
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $item->name }}</td>
                                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                                        <td class="text-warning font-weight-bold">{{ number_format($item->current_stock, 2) }}</td>
                                        <td>{{ number_format($item->min_stock, 2) }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($item->current_price, 2) }}</td>
                                        <td>
                                            @if($item->current_stock <= 0) <span class="badge badge-danger">Out of Stock</span>
                                                @else
                                                <span class="badge badge-warning">Low Stock</span>
                                                @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <!-- Low Stock Products -->
                        @if($lowStockProducts->count() > 0)
                        <h5 class="font-weight-bold text-dark mb-3 mt-4">
                            <i class="fas fa-cube mr-2"></i>Products
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Min Stock</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td class="text-warning font-weight-bold">{{ number_format($product->current_stock, 2) }}</td>
                                        <td>{{ number_format($product->min_stock, 2) }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</td>
                                        <td>
                                            @if($product->current_stock <= 0) <span class="badge badge-danger">Out of Stock</span>
                                                @else
                                                <span class="badge badge-warning">Low Stock</span>
                                                @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4 class="text-success">No Low Stock Items</h4>
                            <p class="text-muted">All items are sufficiently stocked.</p>
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
        $('.table').DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
        });
    });

</script>
@endpush
