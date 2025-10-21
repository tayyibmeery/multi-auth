@extends('layouts.app')

@section('title', 'Expenses Management')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Expenses Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item active">Expenses</li>
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
                        <h3>{{ \App\Models\Expense::count() }}</h3>
                        <p>Total Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('expenses.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format(\App\Models\Expense::sum('amount'), 2) }}</h3>
                        <p>Total Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <a href="{{ route('expenses.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ \App\Models\Expense::where('category', 'office_supplies')->count() }}</h3>
                        <p>Office Supplies</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-paperclip"></i>
                    </div>
                    <a href="{{ route('expenses.index') }}?category=office_supplies" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ \App\Models\Expense::where('category', 'utilities')->count() }}</h3>
                        <p>Utilities</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <a href="{{ route('expenses.index') }}?category=utilities" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Expenses List
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Add Expense
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check"></i> {{ session('success') }}
                        </div>
                        @endif

                        <table id="expensesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Expense #</th>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_number }}</td>
                                    <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                    <td>{{ $expense->account->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $expense->category }}</span>
                                    </td>
                                    <td class="font-weight-bold text-danger">Rs {{ number_format($expense->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($expense->payment_method) }}</span>
                                    </td>
                                    <td>{{ Str::limit($expense->description, 30) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                                            <h5>No expenses found</h5>
                                            <p>Get started by creating your first expense</p>
                                            <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i>Create First Expense
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Expense #</th>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Description</th>
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
        $("#expensesTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "order": [
                [1, 'desc']
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
                , "searchPlaceholder": "Search expenses..."
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
        }).buttons().container().appendTo('#expensesTable_wrapper .col-md-6:eq(0)');
    });

</script>
@endpush
