@extends("layouts.app")

@section("title", "Edit Product")

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Product: {{ $product->name }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Product
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('products.update', $product) }}" method="POST" id="productForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-tag text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror rounded-right" id="name" name="name" placeholder="Enter product name" value="{{ old('name', $product->name) }}" required>
                                        </div>
                                        @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="form-label">Product Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-barcode text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror rounded-right" id="code" name="code" placeholder="Enter product code" value="{{ old('code', $product->code) }}" required>
                                        </div>
                                        @error('code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="selling_price" class="form-label">Selling Price (Rs) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-rupee-sign text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control @error('selling_price') is-invalid @enderror rounded-right" id="selling_price" name="selling_price" step="0.01" min="0" placeholder="0.00" value="{{ old('selling_price', $product->selling_price) }}" required>
                                        </div>
                                        @error('selling_price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_stock" class="form-label">Current Stock <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-boxes text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control @error('current_stock') is-invalid @enderror rounded-right" id="current_stock" name="current_stock" min="0" placeholder="0" value="{{ old('current_stock', $product->current_stock) }}" required>
                                        </div>
                                        @error('current_stock')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Statistics -->
                            <div class="bg-light p-4 rounded mb-4">
                                <h5 class="font-weight-bold text-dark mb-3">
                                    <i class="fas fa-chart-bar mr-2"></i>Product Statistics
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Stock Value:</span>
                                            <span class="font-weight-bold text-success">Rs {{ number_format($product->stock_value, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">BOM Count:</span>
                                            <span class="font-weight-bold text-primary">{{ $product->billOfMaterials->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Created:</span>
                                            <span class="font-weight-bold text-muted">{{ $product->created_at->format('M j, Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Last Updated:</span>
                                            <span class="font-weight-bold text-muted">{{ $product->updated_at->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch custom-switch-lg">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status">
                                        <span class="font-weight-bold">Active Product</span>
                                    </label>
                                </div>
                                <small class="form-text text-muted">Product will be available for sales when active</small>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Fields marked with <span class="text-danger">*</span> are required
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="reset" class="btn btn-outline-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Update Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        // Form validation enhancement
        $('#productForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        });

        // Real-time validation for required fields
        $('#name, #code').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

</script>
@endpush
