@extends("layouts.app")

@section("title", "Low Stock Products")

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
                <h1 class="m-0">Low Stock Products</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Low Stock</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Low Stock Alert - Products that need production
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{ route('products.out-of-stock') }}" class="btn btn-danger btn-sm mr-2">
                                    <i class="fas fa-times-circle mr-1"></i> Out of Stock
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm mr-2">
                                    <i class="fas fa-cube mr-1"></i> All Products
                                </a>
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Add Product
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($products->count() > 0)
                        <div class="table-responsive">
                            <table id="lowStockTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Required</th>
                                        <th>Selling Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->code }}</small>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-danger">{{ $product->current_stock }} {{ $product->unit }}</div>
                                        </td>
                                        <td>{{ $product->min_stock }} {{ $product->unit }}</td>
                                        <td>
                                            <div class="font-weight-bold text-warning">
                                                {{ max(0, $product->min_stock - $product->current_stock) }} {{ $product->unit }}
                                            </div>
                                        </td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('production-runs.create') }}?product_id={{ $product->id }}" class="btn btn-sm btn-success" title="Produce">
                                                    <i class="fas fa-industry mr-1"></i> Produce
                                                </a>
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="text-success mb-3">
                                <i class="fas fa-check-circle fa-4x"></i>
                            </div>
                            <h4 class="text-success">All Products are sufficiently stocked!</h4>
                            <p class="text-muted">No low stock products found.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Products
                            </a>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
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
        $("#lowStockTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search low stock products..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
