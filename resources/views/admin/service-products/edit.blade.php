@extends('layouts.app')

@section('title', 'Edit Service Product - Admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Service Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.website.dashboard') }}">Website Settings</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.service-products.index') }}">Service Products</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Service Product: {{ $serviceProduct->name }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.service-products.update', $serviceProduct->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Product Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $serviceProduct->name) }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icon" class="form-label">Icon *</label>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $serviceProduct->icon) }}" placeholder="fas fa-boxes" required>
                                        <small class="form-text text-muted">Font Awesome icon class</small>
                                        @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $serviceProduct->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="features" class="form-label">Features *</label>
                                <textarea class="form-control @error('features') is-invalid @enderror" id="features" name="features" rows="4" required>
                                {{ old('features', implode("\n", json_decode($serviceProduct->features, true) ?? [])) }}
                                </textarea>
                                <small class="form-text text-muted">Enter each feature on a new line</small>
                                @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monthly_price" class="form-label">Monthly Price *</label>
                                        <input type="number" step="0.01" class="form-control @error('monthly_price') is-invalid @enderror" id="monthly_price" name="monthly_price" value="{{ old('monthly_price', $serviceProduct->monthly_price) }}" required>
                                        @error('monthly_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="yearly_price" class="form-label">Yearly Price</label>
                                        <input type="number" step="0.01" class="form-control @error('yearly_price') is-invalid @enderror" id="yearly_price" name="yearly_price" value="{{ old('yearly_price', $serviceProduct->yearly_price) }}">
                                        @error('yearly_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="color" class="form-label">Color *</label>
                                        <select class="form-control @error('color') is-invalid @enderror" id="color" name="color" required>
                                            <option value="blue" {{ old('color', $serviceProduct->color) == 'blue' ? 'selected' : '' }}>Blue</option>
                                            <option value="green" {{ old('color', $serviceProduct->color) == 'green' ? 'selected' : '' }}>Green</option>
                                            <option value="purple" {{ old('color', $serviceProduct->color) == 'purple' ? 'selected' : '' }}>Purple</option>
                                            <option value="orange" {{ old('color', $serviceProduct->color) == 'orange' ? 'selected' : '' }}>Orange</option>
                                            <option value="cyan" {{ old('color', $serviceProduct->color) == 'cyan' ? 'selected' : '' }}>Cyan</option>
                                            <option value="emerald" {{ old('color', $serviceProduct->color) == 'emerald' ? 'selected' : '' }}>Emerald</option>
                                        </select>
                                        @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sort_order" class="form-label">Sort Order *</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $serviceProduct->sort_order) }}" required>
                                        @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $serviceProduct->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Product</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $serviceProduct->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                                <a href="{{ route('admin.service-products.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Icon Reference</h3>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted">Common Font Awesome icons:</p>
                        <ul class="list-unstyled small">
                            <li><code>fas fa-boxes</code> - Inventory</li>
                            <li><code>fas fa-industry</code> - Production</li>
                            <li><code>fas fa-cash-register</code> - Sales</li>
                            <li><code>fas fa-chart-line</code> - Analytics</li>
                            <li><code>fas fa-mobile-alt</code> - Mobile</li>
                            <li><code>fas fa-star</code> - Featured</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Current Product Preview</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="{{ $serviceProduct->icon }} fa-3x text-{{ $serviceProduct->color }}"></i>
                        </div>
                        <h5>{{ $serviceProduct->name }}</h5>
                        <p class="text-muted small">{{ Str::limit($serviceProduct->description, 100) }}</p>
                        <div class="mt-2">
                            <span class="badge badge-{{ $serviceProduct->is_featured ? 'success' : 'secondary' }}">
                                {{ $serviceProduct->is_featured ? 'Featured' : 'Not Featured' }}
                            </span>
                            <span class="badge badge-{{ $serviceProduct->is_active ? 'success' : 'danger' }}">
                                {{ $serviceProduct->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trim the features textarea content
        const featuresTextarea = document.getElementById('features');
        if (featuresTextarea) {
            featuresTextarea.value = featuresTextarea.value.trim();
        }
    });

</script>
@endpush
