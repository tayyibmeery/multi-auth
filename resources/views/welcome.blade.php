@extends("layouts.app")

@section("title", "Rozwel Control - Complete Business Management Solutions")

@section("styles")
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
    }

    .company-gradient {
        background: linear-gradient(135deg, #0f766e 0%, #0e7490 100%);
    }

    .feature-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .product-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

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

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Color System */
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

    /* Custom Backgrounds */
    .bg-light-custom {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    }

    .bg-dark-custom {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
    }

    /* Pricing Cards */
    .pricing-card {
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
    }

    .pricing-card.featured {
        border-color: #3b82f6;
        transform: scale(1.05);
    }

    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    /* Company Info Styles */
    .company-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .contact-info {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 15px;
        padding: 2rem;
    }

    /* Product Showcase */
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ef4444;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
    }

</style>
@endsection

@section("content")
<div class="content-wrapper" style="min-height: 100vh; margin-left: 0 !important;">

    <!-- Hero Section -->
    <section class="hero-gradient py-5" style="min-height: 100vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <div class="company-logo floating mb-4">
                        RC
                    </div>
                    <h1 class="display-3 fw-bold mb-4">
                        Rozwel Control
                    </h1>
                    <h2 class="h1 mb-4 opacity-90">
                        Complete Business Management Solutions
                    </h2>
                    <p class="lead mb-5 fs-4 opacity-90">
                        End-to-end solutions for inventory management, production control, sales automation, and comprehensive accounting systems tailored for modern businesses.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#contact" class="btn btn-light btn-lg px-5 py-3 fw-bold fs-5 pulse">
                            <i class="fas fa-phone me-2"></i>Contact Us
                        </a>
                        <a href="#products" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold fs-5">
                            <i class="fas fa-box me-2"></i>Our Products
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

    <!-- Company Information Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold text-dark mb-4">About Rozwel Control</h2>
                    <p class="lead text-muted mb-4">
                        Rozwel Control is a leading provider of comprehensive business management solutions, specializing in custom software development for inventory control, production management, and enterprise resource planning.
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-4">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary text-white rounded-circle p-3">
                                        <i class="fas fa-bullseye fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold text-dark">Our Mission</h5>
                                    <p class="text-muted mb-0">To empower businesses with innovative technology solutions that drive efficiency and growth.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-4">
                                <div class="flex-shrink-0">
                                    <div class="bg-success text-white rounded-circle p-3">
                                        <i class="fas fa-eye fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold text-dark">Our Vision</h5>
                                    <p class="text-muted mb-0">To be the preferred partner for business automation and digital transformation.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info">
                        <h4 class="fw-bold text-dark mb-4">Company Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fas fa-building me-2"></i>Company Name
                                    </h6>
                                    <p class="text-muted mb-0">Rozwel Control Pvt. Ltd.</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fas fa-map-marker-alt me-2"></i>Address
                                    </h6>
                                    <p class="text-muted mb-0">123 Business District<br>Industrial Area<br>City, State 12345</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fas fa-phone me-2"></i>Contact
                                    </h6>
                                    <p class="text-muted mb-0">+1 (555) 123-4567<br>+1 (555) 123-4568</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </h6>
                                    <p class="text-muted mb-0">info@rozwelcontrol.com<br>support@rozwelcontrol.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products & Services Section -->
    <section id="products" class="py-5 bg-light-custom">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-4 fw-bold text-dark mb-3">Our Products & Services</h2>
                    <p class="lead text-muted mx-auto" style="max-width: 600px;">
                        Comprehensive business management solutions tailored to your specific needs
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-blue-100 mb-4">
                                <i class="fas fa-boxes fs-1 text-blue-600"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Inventory Management System</h4>
                            <p class="text-muted mb-4">
                                Complete inventory tracking with real-time stock updates, automated reordering, and comprehensive reporting.
                            </p>
                            <div class="mb-3">
                                <span class="h3 fw-bold text-primary">$499</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled text-start text-muted mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Real-time stock tracking</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Automated purchase orders</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Low stock alerts</li>
                                <li><i class="fas fa-check text-success me-2"></i> Vendor management</li>
                            </ul>
                            <a href="#contact" class="btn btn-primary w-100 py-2">Get Started</a>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 border-0 shadow-sm position-relative">
                        <div class="product-badge">Most Popular</div>
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-green-100 mb-4">
                                <i class="fas fa-industry fs-1 text-green-600"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Production Control Suite</h4>
                            <p class="text-muted mb-4">
                                End-to-end production management with BOM tracking, quality control, and cost analysis.
                            </p>
                            <div class="mb-3">
                                <span class="h3 fw-bold text-primary">$799</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled text-start text-muted mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> BOM management</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Production scheduling</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Quality control tracking</li>
                                <li><i class="fas fa-check text-success me-2"></i> Cost analysis reports</li>
                            </ul>
                            <a href="#contact" class="btn btn-success w-100 py-2">Get Started</a>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-purple-100 mb-4">
                                <i class="fas fa-cash-register fs-1 text-purple-600"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Sales & POS System</h4>
                            <p class="text-muted mb-4">
                                Complete point of sale with customer management, invoicing, and sales analytics.
                            </p>
                            <div class="mb-3">
                                <span class="h3 fw-bold text-primary">$599</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled text-start text-muted mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Point of Sale</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Customer management</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Invoice generation</li>
                                <li><i class="fas fa-check text-success me-2"></i> Sales analytics</li>
                            </ul>
                            <a href="#contact" class="btn btn-primary w-100 py-2">Get Started</a>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-orange-100 mb-4">
                                <i class="fas fa-chart-line fs-1 text-orange-600"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Accounting System</h4>
                            <p class="text-muted mb-4">
                                Complete double-entry accounting with financial reporting and expense tracking.
                            </p>
                            <div class="mb-3">
                                <span class="h3 fw-bold text-primary">$699</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled text-start text-muted mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Double-entry accounting</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Financial reports</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Expense management</li>
                                <li><i class="fas fa-check text-success me-2"></i> Payroll system</li>
                            </ul>
                            <a href="#contact" class="btn btn-primary w-100 py-2">Get Started</a>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-cyan-100 mb-4">
                                <i class="fas fa-mobile-alt fs-1 text-cyan-600"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Mobile Business App</h4>
                            <p class="text-muted mb-4">
                                Mobile application for on-the-go business management and real-time notifications.
                            </p>
                            <div class="mb-3">
                                <span class="h3 fw-bold text-primary">$299</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled text-start text-muted mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Mobile dashboard</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Real-time alerts</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Sales on mobile</li>
                                <li><i class="fas fa-check text-success me-2"></i> Inventory checks</li>
                            </ul>
                            <a href="#contact" class="btn btn-primary w-100 py-2">Get Started</a>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="product-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-emerald-100 mb-4">
                                <i class="fas fa-star fs-1 text-emerald-600"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Complete Enterprise Suite</h4>
                            <p class="text-muted mb-4">
                                All-in-one solution combining all modules for complete business management.
                            </p>
                            <div class="mb-3">
                                <span class="h3 fw-bold text-primary">$1,999</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled text-start text-muted mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> All modules included</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Priority support</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Custom development</li>
                                <li><i class="fas fa-check text-success me-2"></i> Training & onboarding</li>
                            </ul>
                            <a href="#contact" class="btn btn-success w-100 py-2">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-4 fw-bold text-dark mb-3">Why Choose Rozwel Control?</h2>
                    <p class="lead text-muted mx-auto" style="max-width: 600px;">
                        Experience the difference with our comprehensive business solutions
                    </p>
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
                            <p class="text-muted">Get your system up and running in days, not months with our streamlined implementation process.</p>
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
                            <p class="text-muted">Bank-level security with encryption, regular backups, and compliance with industry standards.</p>
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
                            <p class="text-muted">Round-the-clock customer support with dedicated account managers and technical experts.</p>
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
                            <p class="text-muted">Regular feature updates and improvements based on customer feedback and industry trends.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 company-gradient text-white">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-4 fw-bold mb-3">Get In Touch</h2>
                    <p class="lead opacity-90 mx-auto" style="max-width: 600px;">
                        Ready to transform your business? Contact us today for a free consultation and demo.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="fw-bold text-dark mb-4">Contact Information</h4>
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">Address</h6>
                                                <p class="text-muted mb-0">123 Business District, Industrial Area</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-success text-white rounded-circle p-3 me-3">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">Phone</h6>
                                                <p class="text-muted mb-0">+1 (555) 123-4567</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning text-white rounded-circle p-3 me-3">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">Email</h6>
                                                <p class="text-muted mb-0">info@rozwelcontrol.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="fw-bold text-dark mb-4">Send us a Message</h4>
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg" placeholder="Your Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-lg" placeholder="Your Email" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="tel" class="form-control form-control-lg" placeholder="Your Phone">
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control form-control-lg" rows="3" placeholder="Your Message" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                            <i class="fas fa-paper-plane me-2"></i>Send Message
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-5 bg-dark-custom text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Get Started?</h2>
            <p class="fs-4 mb-4 opacity-90 mx-auto" style="max-width: 600px;">
                Join hundreds of businesses that trust Rozwel Control for their business management needs
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="#contact" class="btn btn-light btn-lg px-5 py-3 fw-bold fs-5">
                    <i class="fas fa-calendar-check me-2"></i>Schedule Demo
                </a>
                <a href="tel:+15551234567" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold fs-5">
                    <i class="fas fa-phone me-2"></i>Call Now
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        console.log('Rozwel Control landing page loaded');

        // Smooth scrolling for navigation links
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });

        // Add hover effects
        $('.feature-card, .product-card').hover(
            function() {
                $(this).addClass('shadow-lg');
            }
            , function() {
                $(this).removeClass('shadow-lg');
            }
        );

        // Animation on scroll
        function animateOnScroll() {
            $('.feature-card, .product-card').each(function() {
                const elementTop = $(this).offset().top;
                const elementBottom = elementTop + $(this).outerHeight();
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();

                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('animate__animated animate__fadeInUp');
                }
            });
        }

        // Initial check
        animateOnScroll();

        // Check on scroll
        $(window).on('scroll', function() {
            animateOnScroll();
        });
    });

</script>
@endsection
