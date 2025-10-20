@extends("layouts.app")

@section("title", "Sales Management")

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
                <h1 class="m-0">Sales Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Sales</li>
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
                        <h3>{{ \App\Models\Sale::count() }}</h3>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format(\App\Models\Sale::sum('total_amount'), 2) }}</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ \App\Models\Customer::count() }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\Sale::whereMonth('sale_date', now()->month)->count() }}</h3>
                        <p>This Month</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales List</h3>
                        <div class="card-tools">
                            <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> New Sale
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="salesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sale Details</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Payment Status</th>
                                    <th>Sale Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-primary">{{ $sale->sale_number }}</div>
                                        <small class="text-muted">
                                            @if($sale->notes)
                                            {{ Str::limit($sale->notes, 50) }}
                                            @else
                                            No notes
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $sale->customer->name ?? 'Walk-in Customer' }}</div>
                                        <small class="text-muted">{{ $sale->customer->phone ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('M j, Y') }}</td>
                                    <td>
                                        <div class="font-weight-bold text-success">Rs {{ number_format($sale->total_amount, 2) }}</div>
                                        <small class="text-muted">
                                            Paid: Rs {{ number_format($sale->paid_amount, 2) }} |
                                            Due: Rs {{ number_format($sale->due_amount, 2) }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($sale->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $sale->sale_status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($sale->sale_status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="btn btn-secondary" title="Print">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            @if($sale->due_amount > 0)
                                            <a href="{{ route('sales.payments.create', $sale->id) }}" class="btn btn-warning" title="Add Payment">
                                                <i class="fas fa-money-bill"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                            <h5>No sales found</h5>
                                            <p>Get started by creating your first sale</p>
                                            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i>Create First Sale
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sale Details</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Payment Status</th>
                                    <th>Sale Status</th>
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
        $("#salesTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "order": [
                [2, 'desc']
            ]
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
                , "searchPlaceholder": "Search sales..."
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
        }).buttons().container().appendTo('#salesTable_wrapper .col-md-6:eq(0)');
    });

</script>
@endpush
