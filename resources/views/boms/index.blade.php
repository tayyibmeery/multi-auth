@extends("layouts.app")

@section("title", "Bill of Materials")

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
                <h1>Bill of Materials</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">BOMs</li>
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
                        <h3>{{ \App\Models\BillOfMaterial::count() }}</h3>
                        <p>Total BOMs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <a href="{{ route('boms.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ \App\Models\BillOfMaterial::where('is_active', true)->count() }}</h3>
                        <p>Active BOMs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('boms.index') }}?status=active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\BillOfMaterial::withCount('bomItems')->get()->sum('bom_items_count') }}</h3>
                        <p>Total Components</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <a href="{{ route('boms.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ \App\Models\BillOfMaterial::has('productionRuns')->count() }}</h3>
                        <p>BOMs in Production</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <a href="{{ route('boms.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bill of Materials List</h3>
                        <div class="card-tools">
                            <a href="{{ route('boms.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Create BOM
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="bomsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>BOM Details</th>
                                    <th>Product</th>
                                    <th>Components</th>
                                    <th>Estimated Cost</th>
                                    <th>Production Runs</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($boms as $bom)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-purple rounded p-2 mr-3">
                                                <i class="fas fa-list-alt text-white"></i>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-primary">{{ $bom->name }}</div>
                                                <small class="text-muted">{{ Str::limit($bom->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $bom->product->name }}</div>
                                        <small class="text-muted">{{ $bom->product->code }}</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $bom->bomItems->count() }} Spare Parts</div>
                                        <small class="text-muted">
                                            @php
                                            $totalQty = $bom->bomItems->sum('quantity');
                                            @endphp
                                            {{ $totalQty }} pcs total
                                        </small>
                                    </td>
                                    <td class="font-weight-bold text-success">Rs {{ number_format($bom->total_estimated_cost, 2) }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ $bom->productionRuns->count() }} runs</div>
                                    </td>
                                    <td>
                                        @if($bom->is_active)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('boms.show', $bom) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('boms.edit', $bom) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('production-runs.create') }}?bom_id={{ $bom->id }}" class="btn btn-sm btn-success" title="Start Production">
                                                <i class="fas fa-play"></i>
                                            </a>
                                            <form action="{{ route('boms.destroy', $bom) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this BOM?')">
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
                                            <i class="fas fa-list-alt fa-3x mb-3"></i>
                                            <h5>No BOMs found</h5>
                                            <p>Get started by creating your first bill of materials</p>
                                            <a href="{{ route('boms.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i>Create First BOM
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>BOM Details</th>
                                    <th>Product</th>
                                    <th>Components</th>
                                    <th>Estimated Cost</th>
                                    <th>Production Runs</th>
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
        $("#bomsTable").DataTable({
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
                , "searchPlaceholder": "Search BOMs..."
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
        }).buttons().container().appendTo('#bomsTable_wrapper .col-md-6:eq(0)');
    });

</script>
@endpush
