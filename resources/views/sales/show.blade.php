@extends('layouts.app')

@section('title', 'Sale Details - ' . $sale->sale_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Sale Details - {{ $sale->sale_number }}</h5>
                    <div>
                        <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-print me-1"></i> Print Invoice
                        </a>
                        <a href="{{ route('sales.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Sale Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th>Sale Number:</th>
                                    <td>{{ $sale->sale_number }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $sale->sale_date->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Customer:</th>
                                    <td>{{ $sale->customer->name ?? 'Walk-in Customer' }}</td>
                                </tr>
                                <tr>
                                    <th>Created By:</th>
                                    <td>{{ $sale->user->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th>Subtotal:</th>
                                    <td>Rs {{ number_format($sale->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Tax:</th>
                                    <td>Rs {{ number_format($sale->tax_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Discount:</th>
                                    <td>Rs {{ number_format($sale->discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td><strong>Rs {{ number_format($sale->total_amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Paid Amount:</th>
                                    <td>Rs {{ number_format($sale->paid_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Due Amount:</th>
                                    <td class="{{ $sale->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                                        Rs {{ number_format($sale->due_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $sale->sale_status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($sale->sale_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($sale->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <h6>Sale Items</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleItems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name }} ({{ $item->product->code }})</td>
                                    <td>{{ number_format($item->quantity, 2) }}</td>
                                    <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                                    <td>Rs {{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td><strong>Rs {{ number_format($sale->subtotal, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                    <td>Rs {{ number_format($sale->tax_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Discount:</strong></td>
                                    <td>-Rs {{ number_format($sale->discount_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                    <td><strong>Rs {{ number_format($sale->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payments -->
                    @if($sale->payments->count() > 0)
                    <h6 class="mt-4">Payment History</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td>Rs {{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>{{ $payment->reference_number ?? '-' }}</td>
                                    <td>{{ $payment->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if($sale->notes)
                    <div class="mt-3">
                        <h6>Notes</h6>
                        <p class="text-muted">{{ $sale->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
