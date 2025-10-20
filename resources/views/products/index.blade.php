@extends("layouts.app")

@section("title", "Products Management")

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
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
                        <h3>{{ \App\Models\Product::count() }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ \App\Models\Product::where('current_stock', '>', 0)->count() }}</h3>
                        <p>In Stock</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('products.index') }}?stock_status=in_stock" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\Product::whereRaw('current_stock <= min_stock')->where('current_stock', '>', 0)->count() }}</h3>
                        <p>Low Stock</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('products.low-stock') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ \App\Models\Product::where('current_stock', 0)->count() }}</h3>
                        <p>Out of Stock</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <a href="{{ route('products.out-of-stock') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products List</h3>
                        <div class="card-tools">
                            <a href="{{ route('products.low-stock') }}" class="btn btn-warning btn-sm mr-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Low Stock
                            </a>
                            <a href="{{ route('products.out-of-stock') }}" class="btn btn-danger btn-sm mr-2">
                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Add Product
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="productsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Code</th>
                                    <th>Current Stock</th>
                                    <th>Selling Price</th>
                                    <th>Stock Value</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-primary">{{ $product->name }}</div>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    </td>
                                    <td>{{ $product->code }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $product->current_stock }} pcs</div>
                                        <small class="text-muted">Min: {{ $product->min_stock }}</small>
                                    </td>
                                    <td class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</td>
                                    <td class="font-weight-bold text-info">Rs {{ number_format($product->stock_value, 2) }}</td>
                                    <td>
                                        @if($product->current_stock == 0)
                                        <span class="badge badge-danger">Out of Stock</span>
                                        @elseif($product->is_low_stock)
                                        <span class="badge badge-warning">Low Stock</span>
                                        @else
                                        <span class="badge badge-success">In Stock</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-cube fa-3x mb-3"></i>
                                            <h5>No products found</h5>
                                            <p>Get started by creating your first product</p>
                                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i>Create First Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Product</th>
                                    <th>Code</th>
                                    <th>Current Stock</th>
                                    <th>Selling Price</th>
                                    <th>Stock Value</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
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
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function() {
        $("#productsTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "buttons": [{
                    extend: 'copy'
                    , text: '<i class="fas fa-copy mr-1"></i>Copy'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'csv'
                    , text: '<i class="fas fa-file-csv mr-1"></i>CSV'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'excel'
                    , text: '<i class="fas fa-file-excel mr-1"></i>Excel'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'pdf'
                    , text: '<i class="fas fa-file-pdf mr-1"></i>PDF'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'print'
                    , text: '<i class="fas fa-print mr-1"></i>Print'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'colvis'
                    , text: '<i class="fas fa-eye mr-1"></i>Columns'
                    , className: 'btn btn-default btn-sm'
                }
            ]
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search products..."
                , "lengthMenu": "Show _MENU_ entries"
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
            , "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                "<'row'<'col-sm-12 col-md-6'B>>"
            , "drawCallback": function() {
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                $('.dataTables_length select').addClass('form-control form-control-sm');
            }
        }).buttons().container().appendTo('#productsTable_wrapper .col-md-6:eq(0)');
    });

</script>
@endpush
