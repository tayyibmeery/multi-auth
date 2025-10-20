@extends("layouts.app")

@section("title", $purchase->purchase_number)

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Purchase: {{ $purchase->purchase_number }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                    <li class="breadcrumb-item active">{{ $purchase->purchase_number }}</li>
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
                <!-- Purchase Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>
                            Purchase Information
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Purchase Number</dt>
                            <dd class="col-sm-8">{{ $purchase->purchase_number }}</dd>

                            <dt class="col-sm-4">Vendor</dt>
                            <dd class="col-sm-8">{{ $purchase->vendor->name }}</dd>

                            <dt class="col-sm-4">Purchase Date</dt>
                            <dd class="col-sm-8">{{ $purchase->purchase_date->format('M j, Y') }}</dd>

                            <dt class="col-sm-4">Total Amount</dt>
                            <dd class="col-sm-8 font-weight-bold text-success">Rs {{ number_format($purchase->total_amount, 2) }}</dd>

                            <dt class="col-sm-4">Created By</dt>
                            <dd class="col-sm-8">{{ $purchase->user->name }}</dd>

                            <dt class="col-sm-4">Created On</dt>
                            <dd class="col-sm-8">{{ $purchase->created_at->format('M j, Y g:i A') }}</dd>
                        </dl>

                        @if ($purchase->notes)
                        <div class="mt-4 border-top pt-3">
                            <dt class="font-weight-bold text-muted">Notes</dt>
                            <dd class="mt-1">{{ $purchase->notes }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Purchase Items -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-2"></i>
                            Purchase Spare Parts
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->purchaseItems as $item)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $item->item->name }}</div>
                                            <small class="text-muted">{{ $item->item->code }}</small>
                                        </td>
                                        <td>{{ $item->quantity }} {{ $item->item->unit }}</td>
                                        <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total:</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($purchase->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Stock Impact -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-boxes mr-2"></i>
                            Stock Impact
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Previous Stock</th>
                                        <th>Quantity Added</th>
                                        <th>New Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->purchaseItems as $item)
                                    @php
                                    $previousStock = $item->item->current_stock - $item->quantity;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $item->item->name }}</div>
                                            <small class="text-muted">{{ $item->item->code }}</small>
                                        </td>
                                        <td>{{ $previousStock }} {{ $item->item->unit }}</td>
                                        <td class="text-success font-weight-bold">+{{ $item->quantity }} {{ $item->item->unit }}</td>
                                        <td>{{ $item->item->current_stock }} {{ $item->item->unit }}</td>
                                        <td>
                                            @if ($item->item->current_stock == 0)
                                            <span class="badge badge-danger">Out of Stock</span>
                                            @elseif($item->item->is_low_stock)
                                            <span class="badge badge-warning">Low Stock</span>
                                            @else
                                            <span class="badge badge-success">In Stock</span>
                                            @endif
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

        <!-- Action Buttons -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-center">
                        <a href="{{ route('purchases.index') }}" class="btn btn-default mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Purchases
                        </a>
                        <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit Purchase
                        </a>
                        @if (auth()->user()->isAdmin())
                        <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this purchase? This action cannot be undone.')">
                                <i class="fas fa-trash mr-1"></i> Delete Purchase
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
