@extends("layouts.app")

@section("title", $sale->sale_number)

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sale: {{ $sale->sale_number }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                    <li class="breadcrumb-item active">{{ $sale->sale_number }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- Sale Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>
                            Sale Information
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-print mr-1"></i> Print
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Sale Number</dt>
                            <dd class="col-sm-8">{{ $sale->sale_number }}</dd>

                            <dt class="col-sm-4">Customer</dt>
                            <dd class="col-sm-8">{{ $sale->customer->name ?? 'Walk-in Customer' }}</dd>

                            <dt class="col-sm-4">Sale Date</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($sale->sale_date)->format('M j, Y g:i A') }}</dd>

                            <dt class="col-sm-4">Created By</dt>
                            <dd class="col-sm-8">{{ $sale->user->name }}</dd>

                            <dt class="col-sm-4">Created On</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($sale->created_at)->format('M j, Y g:i A') }}</dd>
                        </dl>

                        @if ($sale->notes)
                        <div class="mt-4 border-top pt-3">
                            <dt class="font-weight-bold text-muted">Notes</dt>
                            <dd class="mt-1">{{ $sale->notes }}</dd>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Payment Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Subtotal</dt>
                            <dd class="col-sm-8">Rs {{ number_format($sale->subtotal, 2) }}</dd>

                            <dt class="col-sm-4">Tax Amount</dt>
                            <dd class="col-sm-8">Rs {{ number_format($sale->tax_amount, 2) }}</dd>

                            <dt class="col-sm-4">Discount</dt>
                            <dd class="col-sm-8">Rs {{ number_format($sale->discount_amount, 2) }}</dd>

                            <dt class="col-sm-4">Total Amount</dt>
                            <dd class="col-sm-8 font-weight-bold text-success">Rs {{ number_format($sale->total_amount, 2) }}</dd>

                            <dt class="col-sm-4">Paid Amount</dt>
                            <dd class="col-sm-8">Rs {{ number_format($sale->paid_amount, 2) }}</dd>

                            <dt class="col-sm-4">Due Amount</dt>
                            <dd class="col-sm-8 font-weight-bold {{ $sale->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                                Rs {{ number_format($sale->due_amount, 2) }}
                            </dd>

                            <dt class="col-sm-4">Sale Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $sale->sale_status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($sale->sale_status) }}
                                </span>
                            </dd>

                            <dt class="col-sm-4">Payment Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($sale->payment_status) }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Sale Items -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-2"></i>
                            Sale Items
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->saleItems as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $item->product->name }}</div>
                                            <small class="text-muted">{{ $item->product->code }}</small>
                                        </td>
                                        <td>{{ number_format($item->quantity, 2) }}</td>
                                        <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Subtotal:</td>
                                        <td colspan="2" class="font-weight-bold">Rs {{ number_format($sale->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Tax:</td>
                                        <td colspan="2">Rs {{ number_format($sale->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Discount:</td>
                                        <td colspan="2">-Rs {{ number_format($sale->discount_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Grand Total:</td>
                                        <td colspan="2" class="font-weight-bold text-success">Rs {{ number_format($sale->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                @if($sale->payments->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>
                            Payment History
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
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
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>{{ $payment->reference_number ?? '-' }}</td>
                                        <td>{{ $payment->notes ?? '-' }}</td>
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

        <!-- Action Buttons -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-center">
                        <a href="{{ route('sales.index') }}" class="btn btn-default mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Sales
                        </a>
                        @if($sale->due_amount > 0)
                        <a href="{{ route('sales.payments.create', $sale->id) }}" class="btn btn-warning mr-2">
                            <i class="fas fa-money-bill mr-1"></i> Add Payment
                        </a>
                        @endif
                        <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="btn btn-secondary mr-2">
                            <i class="fas fa-print mr-1"></i> Print Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
