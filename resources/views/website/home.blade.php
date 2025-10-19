@extends('website.layout')

@section('title', 'Home - Rozwel Control')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient py-5" style="min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="display-3 fw-bold mb-4">
                    {{ $company->company_name ?? 'Rozwel Control' }}
                </h1>
                <h2 class="h1 mb-4 opacity-90">
                    {{ $company->tagline ?? 'Complete Business Management Solutions' }}
                </h2>
                <p class="lead mb-5 fs-4 opacity-90">
                    {{ $company->about ?? 'End-to-end solutions for inventory management, production control, sales automation, and comprehensive accounting systems.' }}
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#products" class="btn btn-light btn-lg px-5 py-3 fw-bold fs-5">
                        <i class="fas fa-box me-2"></i>Our Products
                    </a>
                    <a href="{{ route('website.contact') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold fs-5">
                        <i class="fas fa-phone me-2"></i>Contact Us
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="floating">
                        <i class="fas fa-chart-network text-white display-1 mb-4"></i>
                    </div>
                    <!-- Stats Grid -->
                    <div class="row g-3 mt-4">
                        <div class="col-6">
                            <div class="stat-card p-4 text-center text-white">
                                <div class="display-6 fw-bold mb-2">100%</div>
                                <div class="fs-6 opacity-90">Accuracy</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card p-4 text-center text-white">
                                <div class="display-6 fw-bold mb-2">24/7</div>
                                <div class="fs-6 opacity-90">Support</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card p-4 text-center text-white">
                                <div class="display-6 fw-bold mb-2">Real-time</div>
                                <div class="fs-6 opacity-90">Tracking</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card p-4 text-center text-white">
                                <div class="display-6 fw-bold mb-2">Secure</div>
                                <div class="fs-6 opacity-90">Platform</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="products" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center">
                <h2 class="display-4 fw-bold text-dark mb-3">Our Featured Products</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    Comprehensive business management solutions tailored to your specific needs
                </p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-4">
                <div class="product-card card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-{{ $product->color }}-100 mb-4">
                            <i class="{{ $product->icon }} fs-1 text-{{ $product->color }}-600"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">{{ $product->name }}</h4>
                        <p class="text-muted mb-4">
                            {{ Str::limit($product->description, 120) }}
                        </p>
                        <div class="mb-3">
                            <span class="h3 fw-bold text-primary">${{ number_format($product->monthly_price, 2) }}</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled text-start text-muted mb-4">
                            @foreach($product->getFeaturesArrayAttribute() as $feature)
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('website.contact') }}" class="btn btn-primary w-100 py-2">Get Started</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="/products" class="btn btn-outline-primary btn-lg">
                View All Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center">
                <h2 class="display-4 fw-bold text-dark mb-3">Why Choose Rozwel Control?</h2>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card card h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white p-4 mb-4">
                            <i class="fas fa-rocket fs-2"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Fast Implementation</h5>
                        <p class="text-muted">Get your system up and running quickly with our streamlined implementation process.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="feature-card card h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white p-4 mb-4">
                            <i class="fas fa-shield-alt fs-2"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Enterprise Security</h5>
                        <p class="text-muted">Bank-level security with encryption and compliance with industry standards.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="feature-card card h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning text-white p-4 mb-4">
                            <i class="fas fa-headset fs-2"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">24/7 Support</h5>
                        <p class="text-muted">Round-the-clock customer support with dedicated account managers.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="feature-card card h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info text-white p-4 mb-4">
                            <i class="fas fa-sync-alt fs-2"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Continuous Updates</h5>
                        <p class="text-muted">Regular feature updates and improvements based on customer feedback.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 company-gradient text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ready to Get Started?</h2>
        <p class="fs-4 mb-4 opacity-90 mx-auto" style="max-width: 600px;">
            Join hundreds of businesses that trust Rozwel Control for their business management needs
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('website.contact') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold fs-5">
                <i class="fas fa-calendar-check me-2"></i>Schedule Demo
            </a>
            <a href="tel:{{ $company->phone ?? '+15551234567' }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold fs-5">
                <i class="fas fa-phone me-2"></i>Call Now
            </a>
        </div>
    </div>
</section>
@endsection
