@extends('layouts.app')

@section('title', 'Create Service Product - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Create New Service Product</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.service-products.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon *</label>
                                    <input type="text" class="form-control" id="icon" name="icon" placeholder="fas fa-boxes" required>
                                    <small class="form-text text-muted">Font Awesome icon class</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features *</label>
                            <textarea class="form-control" id="features" name="features" rows="4" required></textarea>
                            <small class="form-text text-muted">Enter each feature on a new line</small>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="monthly_price" class="form-label">Monthly Price *</label>
                                    <input type="number" step="0.01" class="form-control" id="monthly_price" name="monthly_price" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="yearly_price" class="form-label">Yearly Price</label>
                                    <input type="number" step="0.01" class="form-control" id="yearly_price" name="yearly_price">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color *</label>
                                    <select class="form-select" id="color" name="color" required>
                                        <option value="blue">Blue</option>
                                        <option value="green">Green</option>
                                        <option value="purple">Purple</option>
                                        <option value="orange">Orange</option>
                                        <option value="cyan">Cyan</option>
                                        <option value="emerald">Emerald</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order *</label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                                        <label class="form-check-label" for="is_featured">Featured Product</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.service-products.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Icon Reference</h6>
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
        </div>
    </div>
</div>
@endsection
