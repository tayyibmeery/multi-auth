@extends("layouts.app")

@section("title", $vendor->name)

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $vendor->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
                    <li class="breadcrumb-item active">{{ $vendor->name }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Vendor Information Row -->
        <div class="row">
            <!-- Vendor Details -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Vendor Information
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <strong><i class="fas fa-user mr-1"></i> Name</strong>
                                <p class="text-muted">{{ $vendor->name }}</p>
                                <hr>

                                <strong><i class="fas fa-user-tie mr-1"></i> Contact Person</strong>
                                <p class="text-muted">{{ $vendor->contact_person ?? "N/A" }}</p>
                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                <p class="text-muted">
                                    @if ($vendor->email)
                                    <a href="mailto:{{ $vendor->email }}" class="text-primary">
                                        {{ $vendor->email }}
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </p>
                                <hr>

                                <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                                <p class="text-muted">
                                    @if ($vendor->phone)
                                    <a href="tel:{{ $vendor->phone }}" class="text-primary">
                                        {{ $vendor->phone }}
                                    </a>
                                    @else
                                    N/A
                                    @endif
                                </p>
                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                                <p class="text-muted">{{ $vendor->address ?? "N/A" }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('vendors.index') }}" class="btn btn-default btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Statistics -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Purchase Statistics
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="small-box bg-gradient-success">
                            <div class="inner">
                                <h3>Rs {{ number_format($vendor->total_purchases, 2) }}</h3>
                                <p>Total Purchase Value</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $vendor->purchases_count }}</h5>
                                    <span class="description-text">TOTAL PURCHASES</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        @if ($vendor->purchases_count > 0)
                                        Rs {{ number_format($vendor->total_purchases / $vendor->purchases_count, 2) }}
                                        @else
                                        Rs 0.00
                                        @endif
                                    </h5>
                                    <span class="description-text">AVG PURCHASE</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress bars -->
                        <div class="progress-group mt-3">
                            Purchase Frequency
                            <span class="float-right"><b>{{ $vendor->purchases_count }}</b>/month</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{ min($vendor->purchases_count * 10, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Quick Actions
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('purchases.create') }}?vendor_id={{ $vendor->id }}" class="btn btn-primary btn-block">
                                <i class="fas fa-shopping-cart mr-1"></i> Create Purchase
                            </a>

                            @if ($vendor->email)
                            <a href="mailto:{{ $vendor->email }}" class="btn btn-info btn-block">
                                <i class="fas fa-envelope mr-1"></i> Send Email
                            </a>
                            @endif

                            @if ($vendor->phone)
                            <a href="tel:{{ $vendor->phone }}" class="btn btn-warning btn-block">
                                <i class="fas fa-phone mr-1"></i> Call Vendor
                            </a>
                            @endif
                        </div>

                        <!-- Performance Metrics -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="text-center mb-3">
                                <i class="fas fa-chart-line mr-1"></i>
                                Performance Metrics
                            </h5>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="info-box bg-gradient-success">
                                        <span class="info-box-icon"><i class="fas fa-star"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Rating</span>
                                            <span class="info-box-number">4.8/5</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="info-box bg-gradient-info">
                                        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Response</span>
                                            <span class="info-box-number">24h</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="info-box bg-gradient-warning">
                                        <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Terms</span>
                                            <span class="info-box-number">Net 30</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Purchases & Top Items Row -->
        <div class="row">
            <!-- Recent Purchases -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart mr-1"></i>
                            Recent Purchases
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('purchases.create') }}?vendor_id={{ $vendor->id }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> New Purchase
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($vendor->purchases->count() > 0)
                        <div class="table-responsive">
                            <table id="purchasesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Purchase No</th>
                                        <th>Date</th>
                                        <th>Items Count</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendor->purchases->take(10) as $purchase)
                                    <tr>
                                        <td class="font-weight-bold">{{ $purchase->purchase_number }}</td>
                                        <td>{{ $purchase->purchase_date->format("M j, Y") }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $purchase->purchaseItems->count() }} items</span>
                                        </td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($purchase->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-success">Completed</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('purchases.index') }}?vendor_id={{ $vendor->id }}" class="btn btn-default">
                                View All Purchases <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No purchases from this vendor yet</h5>
                            <p class="text-muted mb-4">Start by creating your first purchase order</p>
                            <a href="{{ route('purchases.create') }}?vendor_id={{ $vendor->id }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i> Create First Purchase
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Purchased Items -->
            <div class="col-md-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cubes mr-1"></i>
                            Top Purchased Items
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($vendor->purchases->count() > 0)
                        @php
                        $purchaseItems = $vendor->purchases->flatMap->purchaseItems;
                        $itemGroups = $purchaseItems->groupBy("item_id");
                        @endphp

                        @foreach ($itemGroups->take(5) as $itemId => $items)
                        @php
                        $item = $items->first()->item;
                        $totalQuantity = $items->sum("quantity");
                        $totalSpent = $items->sum("total_price");
                        @endphp

                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 font-weight-bold">{{ $item->name }}</h6>
                                    <small class="text-muted">{{ $item->code }}</small>
                                </div>
                                <span class="badge badge-primary">{{ $items->count() }}x</span>
                            </div>
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Qty: {{ $totalQuantity }} {{ $item->unit }}</span>
                                    <span class="font-weight-bold text-success">Rs {{ number_format($totalSpent, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($itemGroups->count() > 5)
                        <div class="text-center mt-2">
                            <small class="text-muted">+{{ $itemGroups->count() - 5 }} more items</small>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No items purchased yet</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Monthly Trend -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Monthly Trend
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                        $monthlyPurchases = $vendor
                        ->purchases()
                        ->selectRaw(
                        "MONTH(purchase_date) as month, YEAR(purchase_date) as year, SUM(total_amount) as total",
                        )
                        ->whereYear("purchase_date", now()->year)
                        ->groupBy("year", "month")
                        ->orderBy("year", "asc")
                        ->orderBy("month", "asc")
                        ->get();
                        @endphp

                        @if ($monthlyPurchases->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($monthlyPurchases as $data)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="font-weight-bold">
                                    {{ DateTime::createFromFormat("!m", $data->month)->format("M") }}
                                </span>
                                <span class="badge badge-success badge-pill">
                                    Rs {{ number_format($data->total, 2) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-chart-bar fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No data for this year</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('scripts')
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(function() {
        // Initialize DataTable for purchases
        $("#purchasesTable").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 5
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search purchases..."
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });

</script>
@endpush
