@extends("layouts.app")

@section("title", "Add Payment - " . $sale->sale_number)

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Payment - {{ $sale->sale_number }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.show', $sale) }}">{{ $sale->sale_number }}</a></li>
                    <li class="breadcrumb-item active">Add Payment</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Add Payment
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sales.payments.store', $sale->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0">
                                            <i class="fas fa-calendar text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="datetime-local" name="payment_date" id="payment_date" class="form-control rounded-right" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control" max="{{ $sale->due_amount }}" value="{{ $sale->due_amount }}" required>
                                <small class="form-text text-muted">
                                    Maximum due amount: Rs {{ number_format($sale->due_amount, 2) }}
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" id="payment_method" class="form-control" required>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="card">Card</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="reference_number" class="form-label">Reference Number</label>
                                <input type="text" name="reference_number" id="reference_number" class="form-control" placeholder="Optional reference number">
                            </div>

                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Optional payment notes"></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Add Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Sale Summary -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-receipt mr-2"></i>
                            Sale Summary
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Sale Number</dt>
                            <dd class="col-sm-8">{{ $sale->sale_number }}</dd>

                            <dt class="col-sm-4">Customer</dt>
                            <dd class="col-sm-8">{{ $sale->customer->name ?? 'Walk-in Customer' }}</dd>

                            <dt class="col-sm-4">Total Amount</dt>
                            <dd class="col-sm-8">Rs {{ number_format($sale->total_amount, 2) }}</dd>

                            <dt class="col-sm-4">Paid Amount</dt>
                            <dd class="col-sm-8">Rs {{ number_format($sale->paid_amount, 2) }}</dd>

                            <dt class="col-sm-4">Due Amount</dt>
                            <dd class="col-sm-8 font-weight-bold text-danger">Rs {{ number_format($sale->due_amount, 2) }}</dd>

                            <dt class="col-sm-4">Payment Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($sale->payment_status) }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Previous Payments -->
                @if($sale->payments->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>
                            Previous Payments
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->payments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                        <td class="text-success font-weight-bold">Rs {{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
