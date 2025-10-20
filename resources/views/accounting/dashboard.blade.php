@extends("layouts.app")

@section("title", "Accounting Dashboard")

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
                        <h3>Rs {{ number_format($totalSales, 2) }}</h3>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format($cashBalance, 2) }}</h3>
                        <p>Cash Balance</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <a href="{{ route('accounting.balance-sheet') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rs {{ number_format($bankBalance, 2) }}</h3>
                        <p>Bank Balance</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <a href="{{ route('accounting.balance-sheet') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalExpenses, 2) }}</h3>
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

        <!-- Second Row Stats -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $products->count() }}</h3>
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
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $customers->count() }}</h3>
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
                <div class="small-box bg-dark">
                    <div class="inner">
                        @php
                        $accounts = \App\Models\Account::where('is_active', true)->get();
                        $totalAccounts = $accounts->count();
                        @endphp
                        <h3>{{ $totalAccounts }}</h3>
                        <p>Active Accounts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <a href="{{ route('accounting.trial-balance') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-indigo">
                    <div class="inner">
                        @php
                        $netIncome = $totalSales - $totalExpenses;
                        @endphp
                        <h3>Rs {{ number_format($netIncome, 2) }}</h3>
                        <p>Net Income</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="{{ route('accounting.income-statement') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-8 connectedSortable">
                <!-- Recent Vouchers -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-invoice-dollar mr-1"></i>
                            Recent Accounting Vouchers
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
                        @if($recentVouchers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Voucher #</th>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentVouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->voucher_number }}</td>
                                        <td>{{ $voucher->voucher_date->format('M d, Y') }}</td>
                                        <td>{{ $voucher->account->name }}</td>
                                        <td class="{{ $voucher->debit > 0 ? 'text-danger' : '' }}">
                                            {{ $voucher->debit > 0 ? 'Rs ' . number_format($voucher->debit, 2) : '-' }}
                                        </td>
                                        <td class="{{ $voucher->credit > 0 ? 'text-success' : '' }}">
                                            {{ $voucher->credit > 0 ? 'Rs ' . number_format($voucher->credit, 2) : '-' }}
                                        </td>
                                        <td>{{ Str::limit($voucher->description, 30) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-center text-muted py-3">No recent vouchers</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('accounting.vouchers') }}" class="btn btn-sm btn-default">
                            View All Vouchers
                        </a>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Account Summary -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Account Summary
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($accounts->count() > 0)
                        <div class="list-group">
                            @foreach($accounts as $account)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $account->name }}</h6>
                                        <small class="text-muted">{{ $account->code }}</small>
                                    </div>
                                    <span class="badge badge-{{ $account->current_balance >= 0 ? 'success' : 'danger' }}">
                                        Rs {{ number_format($account->current_balance, 2) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-muted py-3">No active accounts</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Left col -->

            <!-- right col -->
            <section class="col-lg-4 connectedSortable">
                <!-- Financial Summary -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
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
                            <div class="col-12 border-bottom pb-2 mb-2">
                                <h5 class="text-success">Rs {{ number_format($totalSales, 2) }}</h5>
                                <small class="text-muted">Total Sales</small>
                            </div>
                            <div class="col-6 border-right">
                                <h5 class="text-info">Rs {{ number_format($cashBalance, 2) }}</h5>
                                <small class="text-muted">Cash Balance</small>
                            </div>
                            <div class="col-6">
                                <h5 class="text-primary">Rs {{ number_format($bankBalance, 2) }}</h5>
                                <small class="text-muted">Bank Balance</small>
                            </div>
                            <div class="col-6 border-right border-top pt-2">
                                <h5 class="text-danger">Rs {{ number_format($totalExpenses, 2) }}</h5>
                                <small class="text-muted">Total Expenses</small>
                            </div>
                            <div class="col-6 border-top pt-2">
                                @php
                                $netIncome = $totalSales - $totalExpenses;
                                $incomeClass = $netIncome >= 0 ? 'text-success' : 'text-danger';
                                @endphp
                                <h5 class="{{ $incomeClass }}">Rs {{ number_format($netIncome, 2) }}</h5>
                                <small class="text-muted">Net Income</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('accounting.income-statement') }}" class="btn btn-sm btn-default">
                            View Income Statement
                        </a>
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
                                <a href="{{ route('sales.create') }}" class="btn btn-app bg-success">
                                    <i class="fas fa-cash-register"></i> New Sale
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('expenses.create') }}" class="btn btn-app bg-danger">
                                    <i class="fas fa-money-bill-wave"></i> Add Expense
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('accounting.trial-balance') }}" class="btn btn-app bg-info">
                                    <i class="fas fa-balance-scale"></i> Trial Balance
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('accounting.balance-sheet') }}" class="btn btn-app bg-primary">
                                    <i class="fas fa-file-invoice-dollar"></i> Balance Sheet
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <!-- Accounting Reports -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Accounting Reports
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('accounting.trial-balance') }}" class="btn btn-outline-primary text-start">
                                <i class="fas fa-balance-scale me-2"></i> Trial Balance
                            </a>
                            <a href="{{ route('accounting.income-statement') }}" class="btn btn-outline-success text-start">
                                <i class="fas fa-chart-line me-2"></i> Income Statement
                            </a>
                            <a href="{{ route('accounting.balance-sheet') }}" class="btn btn-outline-info text-start">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Balance Sheet
                            </a>
                            <a href="{{ route('reports.sales') }}" class="btn btn-outline-warning text-start">
                                <i class="fas fa-chart-bar me-2"></i> Sales Reports
                            </a>
                            <a href="{{ route('reports.stock-valuation') }}" class="btn btn-outline-secondary text-start">
                                <i class="fas fa-boxes me-2"></i> Stock Valuation
                            </a>
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
        console.log('Accounting Dashboard loaded successfully');
    });

</script>
@endsection
