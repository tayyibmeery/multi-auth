<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center  ">
        <i class="fas fa-warehouse brand-icon"></i>
        <span class="brand-text font-weight-light">Inventory System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name ?? 'Alexander Pierce' }}</a>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- INVENTORY -->
                <li class="nav-header">INVENTORY</li>

                <li class="nav-item">
                    <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Spare Parts</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>Products</p>
                    </a>
                </li>

                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('stock-ledgers.index') }}" class="nav-link {{ request()->routeIs('stock-ledgers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Stock Ledger</p>
                    </a>
                </li>

                <!-- OPERATIONS -->
                <li class="nav-header">OPERATIONS</li>

                <li class="nav-item">
                    <a href="{{ route('purchases.index') }}" class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Purchases</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('vendors.index') }}" class="nav-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Vendors</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('boms.index') }}" class="nav-link {{ request()->routeIs('boms.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Bill of Materials</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('production-runs.index') }}" class="nav-link {{ request()->routeIs('production-runs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-industry"></i>
                        <p>Production</p>
                    </a>
                </li>

                <!-- SALES -->
                <li class="nav-header">SALES</li>

                <li class="nav-item">
                    <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Sales</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>

                <!-- ACCOUNTING -->
                <li class="nav-header">ACCOUNTING</li>

                <li class="nav-item">
                    <a href="{{ route('accounting.dashboard') }}" class="nav-link {{ request()->routeIs('accounting.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Accounting Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('accounting.trial-balance') || request()->routeIs('accounting.income-statement') || request()->routeIs('accounting.balance-sheet') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('accounting.trial-balance') || request()->routeIs('accounting.income-statement') || request()->routeIs('accounting.balance-sheet') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Financial Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('accounting.trial-balance') }}" class="nav-link {{ request()->routeIs('accounting.trial-balance') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trial Balance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounting.income-statement') }}" class="nav-link {{ request()->routeIs('accounting.income-statement') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income Statement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounting.balance-sheet') }}" class="nav-link {{ request()->routeIs('accounting.balance-sheet') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Balance Sheet</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('accounting.vouchers') }}" class="nav-link {{ request()->routeIs('accounting.vouchers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Vouchers</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Expenses</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') || request()->routeIs('salaries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Employees</p>
                    </a>
                </li>

                <!-- REPORTS -->
                <li class="nav-header">REPORTS</li>

                <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                     <li class="nav-item">
                         <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                             <i class="far fa-circle nav-icon"></i>
                             <p> Report</p>
                         </a>
                     </li>

                        <li class="nav-item">
                            <a href="{{ route('reports.stock') }}" class="nav-link {{ request()->routeIs('reports.stock') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.low-stock') }}" class="nav-link {{ request()->routeIs('reports.low-stock') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Low Stock</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.stock-valuation') }}" class="nav-link {{ request()->routeIs('reports.stock-valuation') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Valuation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.sales') }}" class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.purchases') }}" class="nav-link {{ request()->routeIs('reports.purchases') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.production') }}" class="nav-link {{ request()->routeIs('reports.production') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Production Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(auth()->user()->isAdmin())
                <!-- WEBSITE -->
                <li class="nav-header">WEBSITE</li>

                <li class="nav-item">
                    <a href="{{ route('admin.website.dashboard') }}" class="nav-link {{ request()->routeIs('admin.website.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Website Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.company.index') }}" class="nav-link {{ request()->routeIs('admin.company.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Company Info</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.service-products.index') }}" class="nav-link {{ request()->routeIs('admin.service-products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>Service Products</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Messages
                            @if($unreadMessagesCount > 0)
                            <span class="right badge badge-danger">{{ $unreadMessagesCount }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
