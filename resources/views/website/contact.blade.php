@extends('website.layout')

@section('title', 'Contact Us - Rozwel Control')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient py-5 text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-3 fw-bold mb-4">Contact Us</h1>
                <p class="lead fs-4 opacity-90">
                    Get in touch with us to discuss how we can help transform your business
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="display-6 fw-bold text-dark mb-4 text-center">Send us a Message</h2>

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('website.contact.submit') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject *</label>
                                        <input type="text" class="form-control form-control-lg" id="subject" name="subject" value="{{ request()->get('product') ? 'Inquiry about: ' . request()->get('product') : '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control form-control-lg" id="message" name="message" rows="5" required></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-map-marker-alt fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Address</h5>
                        <p class="text-muted mb-0">
                            {{ $company->address ?? '123 Business District, Industrial Area' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card border-0 text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-success text-white rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-phone fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Phone</h5>
                        <p class="text-muted mb-0">
                            {{ $company->phone ?? '+1 (555) 123-4567' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card border-0 text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-warning text-white rounded-circle p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Email</h5>
                        <p class="text-muted mb-0">
                            {{ $company->email ?? 'info@rozwelcontrol.com' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
