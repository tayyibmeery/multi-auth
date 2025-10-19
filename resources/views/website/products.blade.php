@extends('website.layout')

@section('title', 'Our Products - Rozwel Control')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient py-5 text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-3 fw-bold mb-4">Our Products & Services</h1>
                <p class="lead fs-4 opacity-90">
                    Comprehensive business management solutions tailored to your specific needs
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="product-card card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        @if($product->is_featured)
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning">Featured</span>
                        </div>
                        @endif
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 bg-{{ $product->color }}-100 mb-4">
                            <i class="{{ $product->icon }} fs-1 text-{{ $product->color }}-600"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">{{ $product->name }}</h4>
                        <p class="text-muted mb-4">
                            {{ $product->description }}
                        </p>
                        <div class="mb-3">
                            <span class="h3 fw-bold text-primary">${{ number_format($product->monthly_price, 2) }}</span>
                            <span class="text-muted">/month</span>
                            @if($product->yearly_price)
                            <div class="mt-1">
                                <small class="text-success">
                                    <i class="fas fa-tag me-1"></i>
                                    Yearly: ${{ number_format($product->yearly_price, 2) }}
                                    (Save ${{ number_format($product->getYearlySavingsAttribute(), 2) }})
                                </small>
                            </div>
                            @endif
                        </div>
                        <ul class="list-unstyled text-start text-muted mb-4">
                            @foreach($product->getFeaturesArrayAttribute() as $feature)
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('website.contact') }}?product={{ urlencode($product->name) }}" class="btn btn-primary w-100 py-2">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 company-gradient text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Need a Custom Solution?</h2>
        <p class="fs-4 mb-4 opacity-90 mx-auto" style="max-width: 600px;">
            We can tailor our products to meet your specific business requirements
        </p>
        <a href="{{ route('website.contact') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold fs-5">
            <i class="fas fa-calendar-check me-2"></i>Request Custom Quote
        </a>
    </div>
</section>
@endsection
