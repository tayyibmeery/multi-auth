@extends("layouts.app")

@section("title", "Out of Stock Products")

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
                <h1 class="m-0">Out of Stock Products</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Out of Stock</li>
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
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Out of Stock Products
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{ route('products.low-stock') }}" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Low Stock
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
                            <table id="outOfStockTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Selling Price</th>
                                        <th>Stock Value</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="bg-light">
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->code }}</small>
                                            @if($product->description)
                                            <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-danger">{{ $product->current_stock }} {{ $product->unit }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $product->min_stock }} {{ $product->unit }}</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-info">Rs {{ number_format($product->stock_value, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('production-runs.create') }}?product_id={{ $product->id }}" class="btn btn-sm btn-success" title="Produce">
                                                    <i class="fas fa-industry"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Selling Price</th>
                                        <th>Stock Value</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $products->links() }}
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="text-success">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <h4>No Out of Stock Products</h4>
                                <p class="mb-4">All products are currently in stock. Great job!</p>
                                <div class="btn-group">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                                        <i class="fas fa-cube mr-2"></i>View All Products
                                    </a>
                                    <a href="{{ route('products.low-stock') }}" class="btn btn-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>Check Low Stock
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->

                    @if($products->count() > 0)
                    <div class="card-footer bg-danger-light">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total Out of Stock Products: {{ $products->total() }}</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Consider producing more of these products
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('scripts')
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(function() {
        $("#outOfStockTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": false
            , "searching": true
            , "ordering": true
            , "info": false
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search products..."
                , "emptyTable": "No out of stock products found"
            }
            , "dom": "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });

</script>
@endpush
