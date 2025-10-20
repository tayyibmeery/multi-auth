@extends("layouts.app")

@section("title", $customer->name)

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customer: {{ $customer->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">{{ $customer->name }}</li>
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
                <!-- Customer Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-2"></i>
                            Customer Information
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Name</dt>
                            <dd class="col-sm-8 font-weight-bold">{{ $customer->name }}</dd>

                            @if($customer->company_name)
                            <dt class="col-sm-4">Company</dt>
                            <dd class="col-sm-8">{{ $customer->company_name }}</dd>
                            @endif

                            @if($customer->email)
                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">
                                <a href="mailto:{{ $customer->email }}" class="text-primary">
                                    <i class="fas fa-envelope mr-1"></i>{{ $customer->email }}
                                </a>
                            </dd>
                            @endif

                            @if($customer->phone)
                            <dt class="col-sm-4">Phone</dt>
                            <dd class="col-sm-8">
                                <a href="tel:{{ $customer->phone }}" class="text-primary">
                                    <i class="fas fa-phone mr-1"></i>{{ $customer->phone }}
                                </a>
                            </dd>
                            @endif

                            @if($customer->tax_number)
                            <dt class="col-sm-4">Tax Number</dt>
                            <dd class="col-sm-8">{{ $customer->tax_number }}</dd>
                            @endif

                            @if($customer->contact_person)
                            <dt class="col-sm-4">Contact Person</dt>
                            <dd class="col-sm-8">{{ $customer->contact_person }}</dd>
                            @endif

                            <dt class="col-sm-4">Member Since</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($customer->created_at)->format('M j, Y') }}</dd>

                            <dt class="col-sm-4">Last Updated</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($customer->updated_at)->format('M j, Y') }}</dd>
                        </dl>

                        @if($customer->address)
                        <div class="mt-4 border-top pt-3">
                            <dt class="font-weight-bold text-muted">Address</dt>
                            <dd class="mt-1">{{ $customer->address }}</dd>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Summary -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-2"></i>
                            Customer Summary
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="display-4 font-weight-bold text-primary">{{ $customer->sales_count }}</div>
                            <div class="text-muted">Total Purchases</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Spent:</span>
                            <span class="font-weight-bold text-success">Rs {{ number_format($customer->total_sales, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Due:</span>
                            <span class="font-weight-bold {{ $customer->total_due > 0 ? 'text-danger' : 'text-success' }}">
                                Rs {{ number_format($customer->total_due, 2) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Avg. Purchase:</span>
                            <span class="font-weight-bold text-info">
                                Rs {{ $customer->sales_count > 0 ? number_format($customer->total_sales / $customer->sales_count, 2) : '0.00' }}
                            </span>
                        </div>

                        @if($customer->last_sale_date)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Last Purchase:</span>
                                <span class="font-weight-bold">{{ \Carbon\Carbon::parse($customer->last_sale_date)->format('M j, Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Sales History -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>
                            Sales History
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($customer->sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Sale #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total Amount</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->sales as $sale)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $sale->sale_number }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('M j, Y') }}</td>
                                        <td>{{ $sale->saleItems->count() }} items</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($sale->total_amount, 2) }}</td>
                                        <td>Rs {{ number_format($sale->paid_amount, 2) }}</td>
                                        <td class="{{ $sale->due_amount > 0 ? 'text-danger font-weight-bold' : 'text-success' }}">
                                            Rs {{ number_format($sale->due_amount, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($sale->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Sales Yet</h5>
                            <p class="text-muted">This customer hasn't made any purchases yet.</p>
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Create First Sale
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                @if($customer->sales->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Purchase Statistics
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <div class="font-weight-bold text-primary h4">{{ $customer->sales_count }}</div>
                                    <div class="text-muted small">Total Orders</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <div class="font-weight-bold text-success h4">Rs {{ number_format($customer->total_sales, 2) }}</div>
                                    <div class="text-muted small">Total Spent</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <div class="font-weight-bold {{ $customer->total_due > 0 ? 'text-danger' : 'text-success' }} h4">
                                        Rs {{ number_format($customer->total_due, 2) }}
                                    </div>
                                    <div class="text-muted small">Total Due</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <div class="font-weight-bold text-info h4">
                                        Rs {{ $customer->sales_count > 0 ? number_format($customer->total_sales / $customer->sales_count, 2) : '0.00' }}
                                    </div>
                                    <div class="text-muted small">Avg. Order</div>
                                </div>
                            </div>
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
                        <a href="{{ route('customers.index') }}" class="btn btn-default mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Customers
                        </a>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit Customer
                        </a>
                        <a href="{{ route('sales.create', ['customer_id' => $customer->id]) }}" class="btn btn-success mr-2">
                            <i class="fas fa-plus mr-1"></i> New Sale
                        </a>
                        @if($customer->sales_count == 0)
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?')">
                                <i class="fas fa-trash mr-1"></i> Delete Customer
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
