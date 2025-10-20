@extends("layouts.app")

@section("title", "Edit Purchase")

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
                <h1 class="m-0">Edit Purchase</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchases.show', $purchase) }}">{{ $purchase->purchase_number }}</a></li>
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
                            Edit Purchase: {{ $purchase->purchase_number }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Purchase
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('purchases.update', $purchase) }}" method="POST" id="purchaseForm">
                        @csrf
                        @method('PUT')

                        <!-- Purchase Header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vendor_id" class="form-label">Vendor <span class="text-danger">*</span></label>
                                        <select class="form-control select2bs4 @error('vendor_id') is-invalid @enderror" name="vendor_id" style="width: 100%;" required>
                                            <option value="">Select Vendor</option>
                                            @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $purchase->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('vendor_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="fas fa-calendar text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror rounded-right" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" required>
                                        </div>
                                        @error('purchase_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Purchase Items -->
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0">Purchase Spare Parts <span class="text-danger">*</span></label>
                                    <button type="button" id="addItem" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Add Spare Part
                                    </button>
                                </div>

                                <div id="items-container">
                                    @foreach($purchase->purchaseItems as $index => $item)
                                    <div class="item-row mb-3 p-3 border rounded">
                                        <div class="row align-items-end">
                                            <div class="col-md-5">
                                                <label class="form-label">Spare Part <span class="text-danger">*</span></label>
                                                <select name="items[{{ $index }}][item_id]" required class="form-control item-select select2bs4" style="width: 100%;">
                                                    <option value="">Select Spare Part</option>
                                                    @foreach ($items as $sparePart)
                                                    <option value="{{ $sparePart->id }}"
                                                        data-price="{{ $sparePart->current_price }}"
                                                        {{ old("items.{$index}.item_id", $item->item_id) == $sparePart->id ? 'selected' : '' }}>
                                                        {{ $sparePart->name }} ({{ $sparePart->code }}) - Stock: {{ $sparePart->current_stock }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="items[{{ $index }}][quantity]" required min="1"
                                                       class="form-control quantity-input"
                                                       value="{{ old("items.{$index}.quantity", $item->quantity) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Unit Price (Rs) <span class="text-danger">*</span></label>
                                                <input type="number" name="items[{{ $index }}][unit_price]" required step="0.01" min="0"
                                                       class="form-control price-input"
                                                       value="{{ old("items.{$index}.unit_price", $item->unit_price) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Total (Rs)</label>
                                                <input type="text" readonly
                                                       class="form-control total-input bg-light"
                                                       value="Rs {{ number_format($item->quantity * $item->unit_price, 2) }}">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-item" {{ $loop->first ? 'disabled' : '' }}>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Total Amount -->
                            <div class="bg-light p-4 rounded mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold text-dark mb-3">
                                            <i class="fas fa-calculator mr-2"></i>Purchase Summary
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Items Count:</span>
                                            <span class="font-weight-bold text-primary">{{ $purchase->purchaseItems->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Created:</span>
                                            <span class="font-weight-bold text-muted">{{ $purchase->created_at->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <h4 class="font-weight-bold text-dark">Total Amount</h4>
                                            <h2 id="totalAmount" class="font-weight-bold text-success">Rs {{ number_format($purchase->total_amount, 2) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-group">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Enter purchase notes">{{ old('notes', $purchase->notes) }}</textarea>
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
                                    <button type="reset" class="btn btn-outline-secondary mr-2">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Update Purchase
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
            theme: 'bootstrap4',
            placeholder: 'Select an option',
            allowClear: true
        });

        let itemCount = {{ $purchase->purchaseItems->count() }};
        const itemsContainer = document.getElementById('items-container');
        const addItemBtn = document.getElementById('addItem');
        const totalAmountSpan = document.getElementById('totalAmount');

        // Add new item row
        addItemBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'item-row mb-3 p-3 border rounded';
            newRow.innerHTML = `
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Spare Part <span class="text-danger">*</span></label>
                        <select name="items[${itemCount}][item_id]" required class="form-control item-select select2bs4" style="width: 100%;">
                            <option value="">Select Spare Part</option>
                            @foreach ($items as $sparePart)
                            <option value="{{ $sparePart->id }}" data-price="{{ $sparePart->current_price }}">
                                {{ $sparePart->name }} ({{ $sparePart->code }}) - Stock: {{ $sparePart->current_stock }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="items[${itemCount}][quantity]" required min="1"
                               class="form-control quantity-input">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unit Price (Rs) <span class="text-danger">*</span></label>
                        <input type="number" name="items[${itemCount}][unit_price]" required step="0.01" min="0"
                               class="form-control price-input">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Total (Rs)</label>
                        <input type="text" readonly class="form-control total-input bg-light">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-item">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            itemsContainer.appendChild(newRow);

            // Initialize Select2 for new row
            $(newRow).find('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: 'Select an option',
                allowClear: true
            });

            itemCount++;
            addEventListenersToRow(newRow);
        });

        // Add event listeners to a row
        function addEventListenersToRow(row) {
            const itemSelect = row.querySelector('.item-select');
            const quantityInput = row.querySelector('.quantity-input');
            const priceInput = row.querySelector('.price-input');
            const totalInput = row.querySelector('.total-input');
            const removeBtn = row.querySelector('.remove-item');

            // Item select change - auto-fill price
            $(itemSelect).on('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                if (price && !priceInput.value) {
                    priceInput.value = price;
                    calculateRowTotal(this);
                }
            });

            // Calculate total when quantity or price changes
            quantityInput.addEventListener('input', () => calculateRowTotal(quantityInput));
            priceInput.addEventListener('input', () => calculateRowTotal(priceInput));

            // Remove row
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    calculateTotalAmount();
                    updateRemoveButtons();
                }
            });
        }

        // Calculate row total
        function calculateRowTotal(element) {
            const row = element.closest('.item-row');
            const quantity = row.querySelector('.quantity-input').value;
            const price = row.querySelector('.price-input').value;
            const totalInput = row.querySelector('.total-input');

            if (quantity && price) {
                const total = (parseFloat(quantity) * parseFloat(price)).toFixed(2);
                totalInput.value = 'Rs ' + total;
            } else {
                totalInput.value = '';
            }

            calculateTotalAmount();
        }

        // Calculate total amount
        function calculateTotalAmount() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const quantity = row.querySelector('.quantity-input').value;
                const price = row.querySelector('.price-input').value;
                if (quantity && price) {
                    total += parseFloat(quantity) * parseFloat(price);
                }
            });
            totalAmountSpan.textContent = 'Rs ' + total.toFixed(2);
        }

        // Update remove buttons state
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.item-row');
            const removeButtons = document.querySelectorAll('.remove-item');

            if (rows.length === 1) {
                removeButtons[0].disabled = true;
            } else {
                removeButtons.forEach(btn => btn.disabled = false);
            }
        }

        // Add event listeners to initial rows
        document.querySelectorAll('.item-row').forEach(row => {
            addEventListenersToRow(row);
        });

        // Initialize remove buttons state
        updateRemoveButtons();

        // Form validation enhancement
        $('#purchaseForm').on('submit', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        });

        // Real-time validation for required fields
        $('#vendor_id, #purchase_date').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush