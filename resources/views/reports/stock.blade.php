@extends('layouts.app')

@section('title', 'Stock Report')

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
                <h1 class="m-0">Stock Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Stock</li>
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
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $items->count() }}</h3>
                        <p>Total Spare Parts</p>
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
                        <h3>{{ $products->count() }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <a href="#products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $items->where('is_low_stock', true)->count() }}</h3>
                        <p>Low Stock Spare Parts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('reports.low-stock') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $items->where('current_stock', 0)->count() }}</h3>
                        <p>Out of Stock</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <a href="{{ route('reports.low-stock') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Spare Parts Stock -->
                <div class="card" id="spare-parts">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-boxes mr-2"></i>
                            Spare Parts Stock
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('reports.stock-valuation') }}" class="btn btn-sm btn-outline-secondary mr-2">
                                <i class="fas fa-calculator mr-1"></i> Stock Valuation
                            </a>
                            <a href="{{ route('reports.low-stock') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Low Stock Report
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sparePartsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Min Stock</th>
                                        <th>Unit Price</th>
                                        <th>Stock Value</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $item->name }}</div>
                                            <small class="text-muted">{{ $item->code }}</small>
                                        </td>
                                        <td>{{ $item->category->name }}</td>
                                        <td class="font-weight-bold">{{ $item->current_stock }} {{ $item->unit }}</td>
                                        <td>{{ $item->min_stock }} {{ $item->unit }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($item->current_price, 2) }}</td>
                                        <td class="font-weight-bold text-info">Rs {{ number_format($item->stock_value, 2) }}</td>
                                        <td>
                                            @if($item->current_stock == 0)
                                            <span class="badge badge-danger">Out of Stock</span>
                                            @elseif($item->is_low_stock)
                                            <span class="badge badge-warning">Low Stock</span>
                                            @else
                                            <span class="badge badge-success">In Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Products Stock -->
                <div class="card" id="products">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-cube mr-2"></i>
                            Products Stock
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Selling Price</th>
                                        <th>Stock Value</th>
                                        <th>BOM Count</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->code }}</small>
                                        </td>
                                        <td class="font-weight-bold">{{ $product->current_stock }} units</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</td>
                                        <td class="font-weight-bold text-info">Rs {{ number_format($product->stock_value, 2) }}</td>
                                        <td class="font-weight-bold">{{ $product->billOfMaterials->count() }}</td>
                                        <td>
                                            @if($product->current_stock == 0)
                                            <span class="badge badge-danger">Out of Stock</span>
                                            @else
                                            <span class="badge badge-success">In Stock</span>
                                            @endif
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
        $("#sparePartsTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
        });

        $("#productsTable").DataTable({
            "responsive": true
            , "lengthChange": true
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
