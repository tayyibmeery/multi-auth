@extends('layouts.app')

@section('title', 'Trial Balance')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trial Balance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                    <li class="breadcrumb-item active">Trial Balance</li>
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
                            <i class="fas fa-balance-scale mr-2"></i>
                            Trial Balance Report
                        </h3>
                        <div class="card-tools">
                            <button onclick="window.print()" class="btn btn-sm btn-secondary">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Account</th>
                                        <th>Code</th>
                                        <th>Debit (Rs)</th>
                                        <th>Credit (Rs)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trialBalance as $item)
                                    <tr>
                                        <td>{{ $item['account'] }}</td>
                                        <td>{{ $item['code'] }}</td>
                                        <td class="text-end">{{ number_format($item['debit'], 2) }}</td>
                                        <td class="text-end">{{ number_format($item['credit'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-end"><strong>{{ number_format($totalDebit, 2) }}</strong></td>
                                        <td class="text-end"><strong>{{ number_format($totalCredit, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end"><strong>Difference:</strong></td>
                                        <td colspan="2" class="text-end {{ $totalDebit == $totalCredit ? 'text-success' : 'text-danger' }}">
                                            <strong>{{ number_format($totalDebit - $totalCredit, 2) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($totalDebit != $totalCredit)
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Trial Balance is not balanced! Debit and Credit totals do not match.
                        </div>
                        @else
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle mr-2"></i>
                            Trial Balance is balanced.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        $('.table').DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": false
            , "searching": true
            , "ordering": true
            , "info": false
        });
    });

</script>
@endpush
