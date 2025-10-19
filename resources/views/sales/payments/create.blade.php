@extends('layouts.app')

@section('title', 'Add Payment - ' . $sale->sale_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add Payment - {{ $sale->sale_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.payments.store', $sale->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date *</label>
                            <input type="datetime-local" name="payment_date" id="payment_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount *</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" max="{{ $sale->due_amount }}" value="{{ $sale->due_amount }}" required>
                            <div class="form-text">
                                Due Amount: Rs {{ number_format($sale->due_amount, 2) }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method *</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="card">Card</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" name="reference_number" id="reference_number" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sale Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Sale Number:</th>
                            <td>{{ $sale->sale_number }}</td>
                        </tr>
                        <tr>
                            <th>Customer:</th>
                            <td>{{ $sale->customer->name ?? 'Walk-in Customer' }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount:</th>
                            <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Paid Amount:</th>
                            <td>Rs {{ number_format($sale->paid_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Due Amount:</th>
                            <td class="text-danger"><strong>Rs {{ number_format($sale->due_amount, 2) }}</strong></td>
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

                    @if($sale->payments->count() > 0)
                    <h6 class="mt-3">Previous Payments</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td>Rs {{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
