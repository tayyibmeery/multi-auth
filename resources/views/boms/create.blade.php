@extends("layouts.app")

@section("title", "Create BOM")

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
                <h1 class="m-0">Create Bill of Material</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('boms.index') }}">BOMs</a></li>
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
                            <i class="fas fa-plus-circle mr-2"></i>
                            Create New Bill of Material
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('boms.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to BOMs
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('boms.store') }}" method="POST" id="bomForm">
                        @csrf

                        <!-- BOM Header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                                        <select class="form-control select2bs4 @error('product_id') is-invalid @enderror" name="product_id" style="width: 100%;" required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->code }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">BOM Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter BOM name">
                                        @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter BOM description">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- BOM Spare Parts -->
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0">BOM Spare Parts <span class="text-danger">*</span></label>
                                    <button type="button" id="addBomItem" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Add Spare Part
                                    </button>
                                </div>

                                <div id="bom-items-container">
                                    <!-- Initial row -->
                                    <div class="bom-item-row mb-3 p-3 border rounded">
                                        <div class="row align-items-end">
                                            <div class="col-md-6">
                                                <label class="form-label">Spare Part <span class="text-danger">*</span></label>
                                                <select name="items[0][item_id]" required class="form-control item-select select2bs4" style="width: 100%;">
                                                    <option value="">Select Spare Part</option>
                                                    @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
                                                        {{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }} - Rs {{ number_format($item->current_price, 2) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="items[0][quantity]" required min="1" step="0.001" class="form-control quantity-input" placeholder="0.000">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Estimated Cost</label>
                                                <input type="text" readonly class="form-control cost-input bg-light">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-bom-item" disabled>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Estimated Cost -->
                            <div class="bg-light p-4 rounded mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-calculator mr-2"></i>Cost Summary
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Spare Parts Count:</span>
                                            <span id="sparePartsCount" class="font-weight-bold text-primary">1</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <h4 class="font-weight-bold text-dark">Total Estimated Cost</h4>
                                            <h2 id="totalEstimatedCost" class="font-weight-bold text-success">Rs 0.00</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                    <label class="custom-control-label" for="is_active">
                                        Active Bill of Materials (can be used for production)
                                    </label>
                                </div>
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
                                        <i class="fas fa-save mr-1"></i> Create BOM
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

        let bomItemCount = 1;
        const bomItemsContainer = document.getElementById('bom-items-container');
        const addBomItemBtn = document.getElementById('addBomItem');
        const totalEstimatedCostSpan = document.getElementById('totalEstimatedCost');
        const sparePartsCountSpan = document.getElementById('sparePartsCount');

        // Add new BOM item row
        addBomItemBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'bom-item-row mb-3 p-3 border rounded';
            newRow.innerHTML = `
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Spare Part <span class="text-danger">*</span></label>
                        <select name="items[${bomItemCount}][item_id]" required class="form-control item-select select2bs4" style="width: 100%;">
                            <option value="">Select Spare Part</option>
                            @foreach ($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
                                {{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }} - Rs {{ number_format($item->current_price, 2) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="items[${bomItemCount}][quantity]" required min="1" step="0.001"
                               class="form-control quantity-input" placeholder="0.000">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estimated Cost</label>
                        <input type="text" readonly class="form-control cost-input bg-light">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-bom-item">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            bomItemsContainer.appendChild(newRow);

            // Initialize Select2 for new row
            $(newRow).find('.select2bs4').select2({
                theme: 'bootstrap4'
                , placeholder: 'Select an option'
                , allowClear: true
            });

            bomItemCount++;
            updateSparePartsCount();
            addBomItemEventListeners(newRow);
            updateRemoveButtons();
        });

        // Add event listeners to a BOM item row
        function addBomItemEventListeners(row) {
            const itemSelect = row.querySelector('.item-select');
            const quantityInput = row.querySelector('.quantity-input');
            const costInput = row.querySelector('.cost-input');
            const removeBtn = row.querySelector('.remove-bom-item');

            // Calculate cost when item or quantity changes
            $(itemSelect).on('change', calculateBomItemCost);
            quantityInput.addEventListener('input', calculateBomItemCost);

            // Remove row
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.bom-item-row').length > 1) {
                    row.remove();
                    calculateTotalEstimatedCost();
                    updateSparePartsCount();
                    updateRemoveButtons();
                }
            });

            function calculateBomItemCost() {
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
                const quantity = parseFloat(quantityInput.value) || 0;

                if (price && quantity) {
                    const cost = (price * quantity).toFixed(2);
                    costInput.value = 'Rs ' + cost;
                } else {
                    costInput.value = '';
                }

                calculateTotalEstimatedCost();
            }
        }

        // Calculate total estimated cost
        function calculateTotalEstimatedCost() {
            let total = 0;
            document.querySelectorAll('.bom-item-row').forEach(row => {
                const costInput = row.querySelector('.cost-input');
                const costValue = costInput.value.replace('Rs ', '');
                if (costValue) {
                    total += parseFloat(costValue);
                }
            });
            totalEstimatedCostSpan.textContent = 'Rs ' + total.toFixed(2);
        }

        // Update spare parts count
        function updateSparePartsCount() {
            const count = document.querySelectorAll('.bom-item-row').length;
            sparePartsCountSpan.textContent = count;
        }

        // Update remove buttons state
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.bom-item-row');
            const removeButtons = document.querySelectorAll('.remove-bom-item');

            if (rows.length === 1) {
                removeButtons[0].disabled = true;
            } else {
                removeButtons.forEach(btn => btn.disabled = false);
            }
        }

        // Add event listeners to initial row
        document.querySelectorAll('.bom-item-row').forEach(row => {
            addBomItemEventListeners(row);
        });

        // Initialize remove buttons state
        updateRemoveButtons();

        // Pre-fill product if provided in URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('product_id');
        if (productId) {
            document.getElementById('product_id').value = productId;
            $('#product_id').trigger('change');
        }

        // Form validation enhancement
        $('#bomForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Creating...');
        });
    });

</script>
@endpush
