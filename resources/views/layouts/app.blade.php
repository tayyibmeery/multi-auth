<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "Inventory Management System")</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield("styles")
</head>

<body class="hold-transition @auth sidebar-mini @else sidebar-collapse @endauth">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand @auth navbar-white navbar-light @else navbar-custom @endauth">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                @auth
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ url("/") }}" class="navbar-brand">
                        <i class="fas fa-warehouse mr-2"></i>
                        <span>Inventory System</span>
                    </a>
                </li>
                @endauth
                @auth
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route("dashboard") }}" class="nav-link">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                @endauth
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <i class="far fa-user-circle mr-2"></i>
                        <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        {{-- <span class="user-badge ml-2">{{ ucfirst(auth()->user()->role) }}</span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-custom dropdown-menu-right">
                        <div class="dropdown-header bg-light">
                            <strong>{{ auth()->user()->name }}</strong>
                            <div class="text-muted small">{{ auth()->user()->role ?? "User Account" }}</div>

                        </div>
                        {{-- <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user-circle text-primary mr-2"></i> My Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog text-secondary mr-2"></i> Settings
                        </a> --}}
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route("logout") }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route("login") }}" class="nav-link px-4">
                        <i class="fas fa-user mr-2"></i>
                        <span class="font-weight-bold">User Login</span>
                    </a>
                </li>
                @endauth
            </ul>
        </nav>

        @auth
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url("/") }}" class="brand-link text-center">
                <i class="fas fa-warehouse brand-icon"></i>
                <span class="brand-text font-weight-light">Inventory System</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route("dashboard") }}" class="nav-link {{ request()->routeIs("dashboard") ? "active" : "" }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if (auth()->user()->isAdmin())
                        <!-- Admin Menu -->
                        <li class="nav-header">ADMINISTRATION</li>
                        <li class="nav-item">
                            <a href="{{ route("vendors.index") }}" class="nav-link {{ request()->routeIs("vendors.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Vendors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("categories.index") }}" class="nav-link {{ request()->routeIs("categories.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        @endif

                        <!-- Inventory Menu -->
                        <li class="nav-header">INVENTORY</li>
                        <li class="nav-item">
                            <a href="{{ route("items.index") }}" class="nav-link {{ request()->routeIs("items.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>Spare Parts </p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("products.index") }}" class="nav-link {{ request()->routeIs("products.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-cube"></i>
                                <p>Products</p>
                            </a>
                        </li>

                        <!-- Operations Menu -->
                        <li class="nav-header">OPERATIONS</li>
                        <li class="nav-item">
                            <a href="{{ route("purchases.index") }}" class="nav-link {{ request()->routeIs("purchases.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Purchases</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("boms.index") }}" class="nav-link {{ request()->routeIs("boms.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Bill of Materials</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("production-runs.index") }}" class="nav-link {{ request()->routeIs("production-runs.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-industry"></i>
                                <p>Production</p>
                            </a>
                        </li>

                        <!-- Reports Menu -->
                        <li class="nav-header">REPORTS</li>
                        <li class="nav-item">
                            <a href="{{ route("stock-ledgers.index") }}" class="nav-link {{ request()->routeIs("stock-ledgers.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Stock Ledger</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs("reports.*") ? "menu-open" : "" }}">
                            <a href="#" class="nav-link {{ request()->routeIs("reports.*") ? "active" : "" }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route("reports.stock") }}" class="nav-link {{ request()->routeIs("reports.stock") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Stock Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route("reports.low-stock") }}" class="nav-link {{ request()->routeIs("reports.low-stock") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Low Stock</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route("reports.stock-valuation") }}" class="nav-link {{ request()->routeIs("reports.stock-valuation") ? "active" : "" }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Stock Valuation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        @endauth

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper @guest content-wrapper-full @endguest">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="font-weight-bold m-0">@yield("title", "Dashboard")</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @auth

                                <li class="breadcrumb-item"><a href="{{ route("dashboard") }}"><i class="fas fa-home"></i> Home</a></li>
                                <li class="breadcrumb-item active">@yield("title", "Dashboard")</li>

                                @endauth
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Flash Messages -->
                    @if (session("success"))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="icon fas fa-check-circle mr-2"></i>
                        <strong>Success!</strong> {{ session("success") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session("error"))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="icon fas fa-exclamation-circle mr-2"></i>
                        <strong>Error!</strong> {{ session("error") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session("warning"))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="icon fas fa-exclamation-triangle mr-2"></i>
                        <strong>Warning!</strong> {{ session("warning") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session("info"))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="icon fas fa-info-circle mr-2"></i>
                        <strong>Info!</strong> {{ session("info") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @yield("content")
                </div>
            </section>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="d-none d-sm-inline float-right">
                <strong>Version</strong> 1.0.0
            </div>
            <strong>Copyright &copy; {{ date("Y") }} <a href="#">Inventory Management System</a>.</strong>
            All rights reserved.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds with smooth fade
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).alert('close');
                });
            }, 5000);

            // Confirm delete with better styling
            window.confirmDelete = function(message = 'Are you sure you want to delete this Spare Part?') {

                return confirm(message);
            };

            // Active menu highlight
            var url = window.location.pathname;
            $('.nav-sidebar a').each(function() {
                if (this.href.includes(url) && url.length > 1) {
                    $(this).addClass('active');
                    $(this).parents('.nav-item.has-treeview').addClass('menu-open');
                }
            });

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(e) {
                var target = $(this.hash);
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 500);
                }
            });
        });

    </script>

    @yield("scripts")
</body>

</html>
