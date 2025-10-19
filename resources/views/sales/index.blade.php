@extends('layouts.app')

@section('title', 'Sales List')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Sales List</h5>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> New Sale
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="salesTable">
                            <thead>
                                <tr>
                                    <th>Sale #</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->sale_number }}</td>
                                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                    <td>{{ $sale->customer->name ?? 'Walk-in Customer' }}</td>
                                    <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                                    <td>Rs {{ number_format($sale->paid_amount, 2) }}</td>
                                    <td>Rs {{ number_format($sale->due_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sale->sale_status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($sale->sale_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($sale->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            @if($sale->due_amount > 0)
                                            <a href="{{ route('sales.payments.create', $sale->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-money-bill"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#salesTable').DataTable({
            order: [
                [1, 'desc']
            ]
        });
    });

</script>
@endpush
