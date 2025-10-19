@extends('website.layout')

@section('title', 'About Us - Rozwel Control')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient py-5 text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-3 fw-bold mb-4">About Rozwel Control</h1>
                <p class="lead fs-4 opacity-90">
                    Learn more about our mission, vision, and the values that drive our success
                </p>
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold text-dark mb-4">Our Story</h2>
                <p class="lead text-muted mb-4">
                    {{ $company->about ?? 'Rozwel Control was founded with a simple mission: to empower businesses with innovative technology solutions that drive efficiency and growth.' }}
                </p>
                <p class="text-muted mb-4">
                    With years of experience in business management software development, we understand the challenges that modern enterprises face. Our team of experts is dedicated to creating solutions that not only meet your current needs but also scale with your business.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="row text-center">
                            <div class="col-6 mb-4">
                                <div class="bg-primary text-white rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-calendar-check fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark">5+ Years</h5>
                                <p class="text-muted mb-0">Experience</p>
                            </div>
                            <div class="col-6 mb-4">
                                <div class="bg-success text-white rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-users fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark">100+</h5>
                                <p class="text-muted mb-0">Clients</p>
                            </div>
                            <div class="col-6">
                                <div class="bg-warning text-white rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-project-diagram fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark">50+</h5>
                                <p class="text-muted mb-0">Projects</p>
                            </div>
                            <div class="col-6">
                                <div class="bg-info text-white rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-award fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark">98%</h5>
                                <p class="text-muted mb-0">Satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5 text-center">
                        <div class="bg-primary text-white rounded-circle p-4 mx-auto mb-4" style="width: 100px; height: 100px;">
                            <i class="fas fa-bullseye fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-4">Our Mission</h3>
                        <p class="text-muted fs-5">
                            {{ $company->mission ?? 'To empower businesses with innovative technology solutions that drive efficiency and growth.' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5 text-center">
                        <div class="bg-success text-white rounded-circle p-4 mx-auto mb-4" style="width: 100px; height: 100px;">
                            <i class="fas fa-eye fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-4">Our Vision</h3>
                        <p class="text-muted fs-5">
                            {{ $company->vision ?? 'To be the preferred partner for business automation and digital transformation.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center">
                <h2 class="display-4 fw-bold text-dark mb-3">Our Values</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle p-4 mx-auto mb-4" style="width: 100px; height: 100px;">
                        <i class="fas fa-lightbulb fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Innovation</h4>
                    <p class="text-muted">We constantly push boundaries to deliver cutting-edge solutions that transform businesses.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success text-white rounded-circle p-4 mx-auto mb-4" style="width: 100px; height: 100px;">
                        <i class="fas fa-handshake fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Integrity</h4>
                    <p class="text-muted">We build trust through transparency, honesty, and delivering on our promises.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning text-white rounded-circle p-4 mx-auto mb-4" style="width: 100px; height: 100px;">
                        <i class="fas fa-users fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Collaboration</h4>
                    <p class="text-muted">We work closely with our clients to understand their needs and deliver tailored solutions.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
