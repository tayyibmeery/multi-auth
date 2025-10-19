@extends("layouts.app")

@section("title", "Out of Stock Spare Parts")

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
                <h1 class="m-0">Out of Stock Spare Parts</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Spare Parts</a></li>
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
                            Out of Stock Spare Parts
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{ route('items.low-stock') }}" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Low Stock
                                </a>
                                <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm mr-2">
                                    <i class="fas fa-boxes mr-1"></i> All Spare Parts
                                </a>
                                <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Add Spare Part
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($items->count() > 0)
                        <div class="table-responsive">
                            <table id="outOfStockTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Price</th>
                                        <th>Stock Value</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr class="bg-light">
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $item->name }}</div>
                                            <small class="text-muted">{{ $item->code }}</small>
                                            @if($item->description)
                                            <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->category)
                                            <span class="badge badge-info">{{ $item->category->name }}</span>
                                            @else
                                            <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-danger">{{ $item->current_stock }} {{ $item->unit }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $item->min_stock }} {{ $item->unit }}</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-success">Rs {{ number_format($item->current_price, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-info">Rs {{ number_format($item->stock_value, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('purchases.create') }}?item_id={{ $item->id }}" class="btn btn-sm btn-success" title="Purchase">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Price</th>
                                        <th>Stock Value</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $items->links() }}
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="text-success">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <h4>No Out of Stock Spare Parts</h4>
                                <p class="mb-4">All spare parts are currently in stock. Great job!</p>
                                <div class="btn-group">
                                    <a href="{{ route('items.index') }}" class="btn btn-primary">
                                        <i class="fas fa-boxes mr-2"></i>View All Spare Parts
                                    </a>
                                    <a href="{{ route('items.low-stock') }}" class="btn btn-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>Check Low Stock
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->

                    @if($items->count() > 0)
                    <div class="card-footer bg-danger-light">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total Out of Stock Items: {{ $items->total() }}</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Consider creating purchase orders for these spare parts
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
                , "searchPlaceholder": "Search spare parts..."
                , "emptyTable": "No out of stock spare parts found"
            }
            , "dom": "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });

</script>
@endpush
