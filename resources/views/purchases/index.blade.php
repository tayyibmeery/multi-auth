@extends("layouts.app")

@section("title", "Purchases Management")

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
                <h1>Purchases Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Purchases</li>
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
                        <h3>{{ \App\Models\Purchase::count() }}</h3>
                        <p>Total Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('purchases.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format(\App\Models\Purchase::sum('total_amount'), 2) }}</h3>
                        <p>Total Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('purchases.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ \App\Models\Vendor::count() }}</h3>
                        <p>Total Vendors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('vendors.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\Purchase::whereMonth('purchase_date', now()->month)->count() }}</h3>
                        <p>This Month</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <a href="{{ route('purchases.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Purchases List</h3>
                        <div class="card-tools">
                            <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Create Purchase
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="purchasesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Purchase Details</th>
                                    <th>Vendor</th>
                                    <th>Date</th>
                                    <th>Items Count</th>
                                    <th>Total Amount</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-primary">{{ $purchase->purchase_number }}</div>
                                        <small class="text-muted">
                                            @if($purchase->notes)
                                                {{ Str::limit($purchase->notes, 50) }}
                                            @else
                                                No notes
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $purchase->vendor->name }}</div>
                                        <small class="text-muted">{{ $purchase->vendor->contact_person ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $purchase->purchase_date->format('M j, Y') }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $purchase->purchaseItems->count() }} items</div>
                                        <small class="text-muted">
                                            @php
                                                $totalQty = $purchase->purchaseItems->sum('quantity');
                                            @endphp
                                            {{ $totalQty }} pcs total
                                        </small>
                                    </td>
                                    <td class="font-weight-bold text-success">Rs {{ number_format($purchase->total_amount, 2) }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $purchase->user->name }}</div>
                                        <small class="text-muted">{{ $purchase->created_at->format('M j, Y') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if (auth()->user()->isAdmin())
                                            <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this purchase? This action cannot be undone.')">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                            <h5>No purchases found</h5>
                                            <p>Get started by creating your first purchase</p>
                                            <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i>Create First Purchase
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Purchase Details</th>
                                    <th>Vendor</th>
                                    <th>Date</th>
                                    <th>Items Count</th>
                                    <th>Total Amount</th>
                                    <th>Created By</th>
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
        $("#purchasesTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "buttons": [{
                    extend: 'copy',
                    text: '<i class="fas fa-copy mr-1"></i>Copy',
                    className: 'btn btn-default btn-sm'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv mr-1"></i>CSV',
                    className: 'btn btn-default btn-sm'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-1"></i>Excel',
                    className: 'btn btn-default btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-1"></i>PDF',
                    className: 'btn btn-default btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i>Print',
                    className: 'btn btn-default btn-sm'
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-eye mr-1"></i>Columns',
                    className: 'btn btn-default btn-sm'
                }
            ],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search purchases...",
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            },
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                "<'row'<'col-sm-12 col-md-6'B>>",
            "drawCallback": function() {
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                $('.dataTables_length select').addClass('form-control form-control-sm');
            }
        }).buttons().container().appendTo('#purchasesTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush