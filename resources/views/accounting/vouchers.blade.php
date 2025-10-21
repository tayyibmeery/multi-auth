@extends('layouts.app')

@section('title', 'Accounting Vouchers')

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
                <h1 class="m-0">Accounting Vouchers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item active">Vouchers</li>
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
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-receipt mr-2"></i>
                            All Accounting Vouchers
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('accounting.vouchers.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> New Voucher
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

                        <div class="table-responsive">
                            <table id="vouchersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Voucher #</th>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Description</th>
                                        <th>Reference</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->voucher_number }}</td>
                                        <td>{{ $voucher->voucher_date->format('M d, Y') }}</td>
                                        <td>{{ $voucher->account->name }}</td>
                                        <td class="{{ $voucher->debit > 0 ? 'text-danger font-weight-bold' : '' }}">
                                            {{ $voucher->debit > 0 ? 'Rs ' . number_format($voucher->debit, 2) : '-' }}
                                        </td>
                                        <td class="{{ $voucher->credit > 0 ? 'text-success font-weight-bold' : '' }}">
                                            {{ $voucher->credit > 0 ? 'Rs ' . number_format($voucher->credit, 2) : '-' }}
                                        </td>
                                        <td>{{ $voucher->description }}</td>
                                        <td>{{ $voucher->reference ?? '-' }}</td>
                                        <td>{{ $voucher->user->name }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-receipt fa-2x mb-3 d-block"></i>
                                            No vouchers found. <a href="{{ route('accounting.vouchers.create') }}">Create the first voucher</a>.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
        $("#vouchersTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search vouchers..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
