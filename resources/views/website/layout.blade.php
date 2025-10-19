<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rozwel Control - Business Management Solutions')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #3730a3;
            --accent: #0f766e;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .hero-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .company-gradient {
            background: linear-gradient(135deg, var(--accent) 0%, #0e7490 100%);
        }

        .feature-card,
        .product-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
        }

        .feature-card:hover,
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .footer {
            background: var(--dark);
            color: white;
        }

        .bg-blue-100 {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%) !important;
        }

        .bg-green-100 {
            background: linear-gradient(135deg, #dcfce7 0%, #ccfbf1 100%) !important;
        }

        .bg-purple-100 {
            background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important;
        }

        .bg-orange-100 {
            background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%) !important;
        }

        .bg-cyan-100 {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%) !important;
        }

        .bg-emerald-100 {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
        }

        .text-blue-600 {
            color: #1d4ed8 !important;
        }

        .text-green-600 {
            color: #047857 !important;
        }

        .text-purple-600 {
            color: #7c3aed !important;
        }

        .text-orange-600 {
            color: #ea580c !important;
        }

        .text-cyan-600 {
            color: #0e7490 !important;
        }

        .text-emerald-600 {
            color: #059669 !important;
        }

    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-chart-network text-primary me-2"></i>
                Rozwel Control
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
<a href="/" class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}">Home</a>

                    </li>
                    <li class="nav-item">
      <a href="/about" class="nav-link {{ request()->is('about') ? 'active fw-bold' : '' }}">About</a>

                    </li>
                    <li class="nav-item">
<a href="/serproducts" class="nav-link {{ request()->is('serproducts') ? 'active fw-bold' : '' }}">Products</a>



                    </li>
                    <li class="nav-item">
           <a href="/contact" class="nav-link {{ request()->is('contact') ? 'active fw-bold' : '' }}">Contact</a>

                    </li>
                </ul>

                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-person me-2"></i>Administration Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-network me-2"></i>Rozwel Control
                    </h5>
                    <p class="text-light opacity-80">
                        Providing comprehensive business management solutions for modern enterprises.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light opacity-80"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light opacity-80"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light opacity-80"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-light opacity-80"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('website.home') }}" class="text-light opacity-80 text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('website.about') }}" class="text-light opacity-80 text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('website.serproducts') }}" class="text-light opacity-80 text-decoration-none">Products</a></li>

                        <li class="mb-2"><a href="{{ route('website.contact') }}" class="text-light opacity-80 text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Contact Info</h6>
                    @if($company ?? null)
                    <div class="text-light opacity-80">
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $company->address }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            {{ $company->phone }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            {{ $company->email }}
                        </p>
                        @if($company->working_hours)
                        <p class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            {{ $company->working_hours }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <hr class="my-4 opacity-20">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light opacity-80">
                        &copy; {{ date('Y') }} Rozwel Control. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-light opacity-80">
                        Designed with <i class="fas fa-heart text-danger"></i> for your business success
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
