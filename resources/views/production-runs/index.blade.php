@extends("layouts.app")

@section("title", "Production Runs")

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
                <h1>Production Runs</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Production Runs</li>
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
                        <h3>{{ $productionRuns->total() }}</h3>
                        <p>Total Runs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <a href="{{ route('production-runs.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ \App\Models\ProductionRun::where('status', 'completed')->count() }}</h3>
                        <p>Completed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('production-runs.index') }}?status=completed" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\ProductionRun::where('status', 'in_progress')->count() }}</h3>
                        <p>In Progress</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('production-runs.index') }}?status=in_progress" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ \App\Models\ProductionRun::where('status', 'pending')->count() }}</h3>
                        <p>Pending</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-start"></i>
                    </div>
                    <a href="{{ route('production-runs.index') }}?status=pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Production Runs List</h3>
                        <div class="card-tools">
                            <a href="{{ route('production-runs.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Start Production
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="productionRunsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Batch Details</th>
                                    <th>Product</th>
                                    <th>BOM</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productionRuns as $run)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-orange rounded p-2 mr-3">
                                                <i class="fas fa-industry text-white"></i>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-primary">{{ $run->batch_number }}</div>
                                                <small class="text-muted">{{ $run->production_date->format('M j, Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $run->billOfMaterial->product->name }}</div>
                                        <small class="text-muted">{{ $run->billOfMaterial->product->code }}</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $run->billOfMaterial->name }}</div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $run->actual_quantity ?? $run->quantity_to_produce }} units</div>
                                    </td>
                                    <td>{{ $run->production_date->format('M j, Y') }}</td>
                                    <td>
                                        @if($run->status === 'completed')
                                        <span class="badge badge-success">Completed</span>
                                        @elseif($run->status === 'in_progress')
                                        <span class="badge badge-warning">In Progress</span>
                                        @else
                                        <span class="badge badge-secondary">{{ ucfirst($run->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $run->user->name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('production-runs.show', $run) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($run->status !== 'completed')
                                            <form action="{{ route('production-runs.destroy', $run) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this production run?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Cancel">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-industry fa-3x mb-3"></i>
                                            <h5>No production runs found</h5>
                                            <p>Get started by creating your first production run</p>
                                            <a href="{{ route('production-runs.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i>Start First Production
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Batch Details</th>
                                    <th>Product</th>
                                    <th>BOM</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Status</th>
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
        $("#productionRunsTable").DataTable({
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
                , "searchPlaceholder": "Search production runs..."
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
        }).buttons().container().appendTo('#productionRunsTable_wrapper .col-md-6:eq(0)');
    });

</script>
@endpush
