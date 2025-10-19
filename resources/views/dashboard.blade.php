@extends("layouts.app")

@section("title", "Dashboard")

@section("content")
<!-- Content Wrapper. Contains page content -->

<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats["total_items"] }}</h3>
                        <p>Total Spare Parts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <a href="{{ route('items.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats["total_products"] }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats["total_purchases"] }}</h3>
                        <p>Total Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('purchases.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats["total_sales"] }}</h3>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Second Row Stats -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalStockValue, 2) }}</h3>
                        <p>Total Stock Value</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('reports.stock-valuation') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $stats["total_production_runs"] }}</h3>
                        <p>Production Runs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <a href="{{ route('production-runs.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3>{{ $stats["total_customers"] }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-indigo">
                    <div class="inner">
                        <h3>Rs {{ number_format($stats["total_expenses"], 2) }}</h3>
                        <p>Total Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('expenses.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Third Row Stats -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-teal">
                    <div class="inner">
                        <h3>Rs {{ number_format($stats["total_revenue"] ?? 0, 2) }}</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('reports.sales') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-orange">
                    <div class="inner">
                        <h3>Rs {{ number_format(($stats["total_revenue"] ?? 0) - ($stats["total_expenses"] ?? 0), 2) }}</h3>
                        <p>Net Profit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="{{ route('accounting.dashboard') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-purple">
                    <div class="inner">
                        <h3>{{ $stats["total_vendors"] ?? 0 }}</h3>
                        <p>Total Vendors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <a href="{{ route('vendors.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-maroon">
                    <div class="inner">
                        <h3>{{ $stats["total_employees"] ?? 0 }}</h3>
                        <p>Total Employees</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('employees.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Recent Sales -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Recent Sales
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($recentSales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSales as $sale)
                                    <tr>
                                        <td>{{ $sale->invoice_number }}</td>
                                        <td>{{ $sale->customer->name }}</td>
                                        <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                                        <td>{{ $sale->created_at->format('M j, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-center text-muted py-3">No recent sales</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-default">
                            View All Sales
                        </a>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Low Stock Alert -->
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Low Stock Spare Parts
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($lowStockItems->count() > 0)
                        <div class="list-group">
                            @foreach($lowStockItems as $item)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $item->name }}</h6>
                                        <small class="text-muted">Stock: {{ $item->current_stock }} {{ $item->unit }}</small>
                                    </div>
                                    <span class="badge badge-danger">Low Stock</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-muted py-3">All Spare Parts are sufficiently stocked</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('items.low-stock') }}" class="btn btn-sm btn-default">
                            View All Low Stock Items
                        </a>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Inventory Health -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-heartbeat mr-1"></i>
                            Inventory Health
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @php
                        $totalItems = $stats["total_items"] ?? 1;
                        $healthyCount = $totalItems - count($lowStockItems);
                        $healthyPercentage = ($healthyCount / $totalItems) * 100;
                        $lowStockPercentage = (count($lowStockItems) / $totalItems) * 100;
                        @endphp
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-success" style="width: {{ $healthyPercentage }}%">
                                <strong>Healthy: {{ $healthyCount }}</strong>
                            </div>
                            <div class="progress-bar bg-danger" style="width: {{ $lowStockPercentage }}%">
                                <strong>Low Stock: {{ count($lowStockItems) }}</strong>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-success">{{ number_format($healthyPercentage, 1) }}%</h4>
                                <small class="text-muted">Healthy Items</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-danger">{{ number_format($lowStockPercentage, 1) }}%</h4>
                                <small class="text-muted">Low Stock Items</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Left col -->

            <!-- right col -->
            <section class="col-lg-5 connectedSortable">
                <!-- Financial Summary -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Financial Summary
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 border-right">
                                <h5 class="text-success">Rs {{ number_format($stats['total_revenue'] ?? 0, 2) }}</h5>
                                <small class="text-muted">Total Revenue</small>
                            </div>
                            <div class="col-6">
                                <h5 class="text-danger">Rs {{ number_format($stats['total_expenses'] ?? 0, 2) }}</h5>
                                <small class="text-muted">Total Expenses</small>
                            </div>
                            <div class="col-12 mt-3 pt-3 border-top">
                                @php
                                $netProfit = ($stats['total_revenue'] ?? 0) - ($stats['total_expenses'] ?? 0);
                                $profitClass = $netProfit >= 0 ? 'text-success' : 'text-danger';
                                @endphp
                                <h4 class="{{ $profitClass }}">Rs {{ number_format($netProfit, 2) }}</h4>
                                <small class="text-muted">Net Profit</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('accounting.dashboard') }}" class="btn btn-sm btn-default">
                            View Financial Reports
                        </a>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Recent Purchases -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart mr-1"></i>
                            Recent Purchases
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($recentPurchases->count() > 0)
                        <div class="list-group">
                            @foreach($recentPurchases as $purchase)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $purchase->purchase_number }}</h6>
                                        <small class="text-muted">{{ $purchase->vendor->name }}</small>
                                    </div>
                                    <div class="text-right">
                                        <strong>Rs {{ number_format($purchase->total_amount, 2) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $purchase->purchase_date->format('M j') }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-muted py-3">No recent purchases</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-default">
                            View All Purchases
                        </a>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Recent Production -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-industry mr-1"></i>
                            Recent Production Runs
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($recentProductions->count() > 0)
                        <div class="list-group">
                            @foreach($recentProductions as $production)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $production->batch_number }}</h6>
                                        <small class="text-muted">
                                            {{ $production->billOfMaterial->product->name }} -
                                            {{ $production->actual_quantity ?? $production->quantity_to_produce }} units
                                        </small>
                                    </div>
                                    <span class="badge badge-{{ $production->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($production->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-muted py-3">No recent production runs</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('production-runs.index') }}" class="btn btn-sm btn-default">
                            View All Production Runs
                        </a>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Performance Metrics -->
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tachometer-alt mr-1"></i>
                            Performance Metrics
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 border-right">
                                <h5>{{ number_format($performance['stock_turnover'] ?? 2.5, 2) }}</h5>
                                <small class="text-muted">Stock Turnover</small>
                            </div>
                            <div class="col-6">
                                <h5>{{ $performance['order_fulfillment_rate'] ?? 95 }}%</h5>
                                <small class="text-muted">Fulfillment Rate</small>
                            </div>
                            <div class="col-6 border-right border-top">
                                <h5>{{ $performance['production_efficiency'] ?? 88 }}%</h5>
                                <small class="text-muted">Production Efficiency</small>
                            </div>
                            <div class="col-6 border-top">
                                <h5>{{ $performance['customer_satisfaction'] ?? 92 }}%</h5>
                                <small class="text-muted">Customer Satisfaction</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Quick Actions -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('purchases.create') }}" class="btn btn-app bg-info">
                                    <i class="fas fa-plus"></i> New Purchase
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('sales.create') }}" class="btn btn-app bg-success">
                                    <i class="fas fa-cash-register"></i> New Sale
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('production-runs.create') }}" class="btn btn-app bg-warning">
                                    <i class="fas fa-industry"></i> Start Production
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('items.create') }}" class="btn btn-app bg-primary">
                                    <i class="fas fa-box"></i> Add Item
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize any dashboard-specific scripts here
        console.log('Dashboard loaded successfully');
    });

</script>
@endsection
