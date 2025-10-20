@extends("layouts.app")

@section("title", "Start Production Run")

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Start Production Run</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('production-runs.index') }}">Production Runs</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                            <i class="fas fa-industry mr-2"></i>
                            Start New Production Run
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('production-runs.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Production
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('production-runs.store') }}" method="POST" id="productionForm">
                        @csrf

                        <!-- Production Header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bom_id" class="form-label">Bill of Material <span class="text-danger">*</span></label>
                                        <select class="form-control select2bs4 @error('bom_id') is-invalid @enderror" name="bom_id" id="bom_id" style="width: 100%;" required>
                                            <option value="">Select BOM</option>
                                            @foreach ($boms as $bom)
                                            <option value="{{ $bom->id }}" data-product="{{ $bom->product->name }}" data-cost="{{ $bom->total_estimated_cost }}" {{ old('bom_id') == $bom->id ? 'selected' : '' }}>
                                                {{ $bom->name }} - {{ $bom->product->name }} (Cost: Rs {{ number_format($bom->total_estimated_cost, 2) }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('bom_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="production_date" class="form-label">Production Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('production_date') is-invalid @enderror" id="production_date" name="production_date" value="{{ old('production_date', date('Y-m-d')) }}" required>
                                        @error('production_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Product Information -->
                            <div id="productInfo" class="alert alert-info d-none">
                                <h5 class="alert-heading"><i class="fas fa-info-circle mr-2"></i>Product Information</h5>
                                <p class="mb-1">
                                    <strong>Product:</strong> <span id="productName"></span>
                                </p>
                                <p class="mb-0">
                                    <strong>Material Cost:</strong> <span id="materialCost"></span>
                                </p>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group">
                                <label for="quantity_to_produce" class="form-label">Quantity to Produce <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity_to_produce') is-invalid @enderror" id="quantity_to_produce" name="quantity_to_produce" value="{{ old('quantity_to_produce', 1) }}" required min="1">
                                @error('quantity_to_produce')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- BOM Spare Parts Preview -->
                            <div id="bomItemsPreview" class="d-none">
                                <h5 class="mb-3"><i class="fas fa-list mr-2"></i>Required Materials</h5>
                                <div class="bg-light p-3 rounded">
                                    <div id="stockCheckResults"></div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered table-sm" id="materialsTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Spare Parts</th>
                                                    <th>Required</th>
                                                    <th>Available</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="materialsTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Cost -->
                            <div id="totalCostSection" class="bg-light p-4 rounded mt-3 d-none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-calculator mr-2"></i>Cost Summary
                                        </h5>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="font-weight-bold text-dark">Total Material Cost</h4>
                                        <h2 id="totalProductionCost" class="font-weight-bold text-success">Rs 0.00</h2>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Enter production notes">{{ old('notes') }}</textarea>
                                @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
                                    <button type="submit" id="submitBtn" class="btn btn-primary">
                                        <i class="fas fa-play mr-1"></i> Start Production
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4'
            , placeholder: 'Select an option'
            , allowClear: true
        });

        const bomSelect = document.getElementById('bom_id');
        const productInfo = document.getElementById('productInfo');
        const productName = document.getElementById('productName');
        const materialCost = document.getElementById('materialCost');
        const quantityInput = document.getElementById('quantity_to_produce');
        const bomItemsPreview = document.getElementById('bomItemsPreview');
        const totalCostSection = document.getElementById('totalCostSection');
        const totalProductionCost = document.getElementById('totalProductionCost');
        const materialsTable = document.getElementById('materialsTable');
        const materialsTableBody = document.getElementById('materialsTableBody');
        const stockCheckResults = document.getElementById('stockCheckResults');
        const submitBtn = document.getElementById('submitBtn');

        // Load BOM details when selected
        bomSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const product = selectedOption.getAttribute('data-product');
                const cost = selectedOption.getAttribute('data-cost');

                productName.textContent = product;
                materialCost.textContent = 'Rs ' + parseFloat(cost).toFixed(2);
                productInfo.classList.remove('d-none');

                // Load BOM Spare Parts
                loadBomItems(selectedOption.value);
            } else {
                productInfo.classList.add('d-none');
                bomItemsPreview.classList.add('d-none');
                totalCostSection.classList.add('d-none');
            }
        });

        // Update quantities and costs when quantity changes
        quantityInput.addEventListener('input', function() {
            if (bomSelect.value) {
                loadBomItems(bomSelect.value);
            }
        });

        // Load BOM Spare Parts via AJAX
        function loadBomItems(bomId) {
            fetch(`/boms/${bomId}/items`)
                .then(response => response.json())
                .then(data => {
                    displayBomItems(data.items, quantityInput.value);
                    calculateTotalCost(data.items, quantityInput.value);
                    checkStockAvailability(data.items, quantityInput.value);
                })
                .catch(error => {
                    console.error('Error loading BOM items:', error);
                });
        }

        // Display BOM Spare Parts
        function displayBomItems(items, quantity) {
            materialsTableBody.innerHTML = '';
            let allItemsInStock = true;

            items.forEach(item => {
                const requiredQuantity = item.quantity * quantity;
                const hasEnoughStock = item.item.current_stock >= requiredQuantity;

                if (!hasEnoughStock) {
                    allItemsInStock = false;
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div class="font-weight-bold">${item.item.name}</div>
                        <small class="text-muted">${item.item.code}</small>
                    </td>
                    <td>${requiredQuantity} ${item.item.unit}</td>
                    <td>${item.item.current_stock} ${item.item.unit}</td>
                    <td>
                        ${hasEnoughStock ?
                            '<span class="badge badge-success">Sufficient</span>' :
                            '<span class="badge badge-danger">Short: ' + (requiredQuantity - item.item.current_stock) + '</span>'
                        }
                    </td>
                `;
                materialsTableBody.appendChild(row);
            });

            // Show/hide materials table
            if (items.length > 0) {
                bomItemsPreview.classList.remove('d-none');
            } else {
                bomItemsPreview.classList.add('d-none');
            }

            // Update stock check results
            if (allItemsInStock) {
                stockCheckResults.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        All materials are available in stock. Production can proceed.
                    </div>
                `;
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-primary');
            } else {
                stockCheckResults.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Some materials are insufficient. Please check stock levels before proceeding.
                    </div>
                `;
                submitBtn.disabled = false; // Still allow production but with warning
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-primary');
            }
        }

        // Calculate total cost
        function calculateTotalCost(items, quantity) {
            let totalCost = 0;
            items.forEach(item => {
                totalCost += item.item.current_price * item.quantity * quantity;
            });

            totalProductionCost.textContent = 'Rs ' + totalCost.toFixed(2);
            totalCostSection.classList.remove('d-none');
        }

        // Pre-fill BOM if provided in URL
        const urlParams = new URLSearchParams(window.location.search);
        const bomId = urlParams.get('bom_id');
        if (bomId) {
            bomSelect.value = bomId;
            $(bomSelect).trigger('change');
        }

        // Form validation enhancement
        $('#productionForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Starting...');
        });
    });

</script>
@endpush
