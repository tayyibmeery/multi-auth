@extends('layouts.app')

@section('title', 'Create New Sale')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Create New Sale</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Customer</label>
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value="">Walk-in Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sale_date" class="form-label">Sale Date *</label>
                                    <input type="datetime-local" name="sale_date" id="sale_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Items -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6>Sale Items</h6>
                                <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                                    <i class="fas fa-plus me-1"></i> Add Item
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40%">Product</th>
                                            <th width="15%">Quantity</th>
                                            <th width="15%">Unit Price</th>
                                            <th width="15%">Total</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <!-- Items will be added here dynamically -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted" id="emptyCartMessage">
                                                No items added. Click "Add Item" to start.
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Totals -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Payment Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">Subtotal:</div>
                                            <div class="col-6 text-end">Rs <span id="subtotal">0.00</span></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Tax Amount:</div>
                                            <div class="col-6 text-end">
                                                <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control form-control-sm" value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Discount Amount:</div>
                                            <div class="col-6 text-end">
                                                <input type="number" step="0.01" name="discount_amount" id="discount_amount" class="form-control form-control-sm" value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6"><strong>Total Amount:</strong></div>
                                            <div class="col-6 text-end"><strong>Rs <span id="total_amount">0.00</span></strong></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Paid Amount:</div>
                                            <div class="col-6 text-end">
                                                <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control form-control-sm" value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">Payment Method:</div>
                                            <div class="col-6 text-end">
                                                <select name="payment_method" id="payment_method" class="form-control form-control-sm">
                                                    <option value="cash">Cash</option>
                                                    <option value="bank_transfer">Bank Transfer</option>
                                                    <option value="card">Card</option>
                                                    <option value="cheque">Cheque</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Select Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="productSearch" placeholder="Search products...">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="productList">
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>Rs {{ number_format($product->selling_price, 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary select-product" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-code="{{ $product->code }}" data-product-price="{{ $product->selling_price }}" data-product-stock="{{ $product->current_stock }}">
                                        Select
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-card {
        cursor: pointer;
        transition: all 0.3s;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .item-row {
        border-bottom: 1px solid #dee2e6;
    }

    .item-row:last-child {
        border-bottom: none;
    }

</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        console.log('Sales form initialized');

        let itemCount = 0;
        let productModal = null;

        // Initialize Bootstrap 5 modal
        const modalElement = document.getElementById('productModal');
        if (modalElement) {
            productModal = new bootstrap.Modal(modalElement);
            console.log('Modal initialized successfully');
        } else {
            console.error('Modal element not found');
        }

        // Add Item Button Click
        $('#addItemBtn').on('click', function() {
            console.log('Add item button clicked');
            if (productModal) {
                productModal.show();
                console.log('Modal shown');
            } else {
                console.error('Modal not initialized');
                alert('Error: Modal not initialized. Please refresh the page.');
            }
        });

        // Product Search
        $('#productSearch').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            $('#productList tr').each(function() {
                const rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchText) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Product Selection
        $(document).on('click', '.select-product', function() {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const productCode = $(this).data('product-code');
            const productPrice = $(this).data('product-price');
            const productStock = $(this).data('product-stock');

            console.log('Product selected:', productName);

            // Check if product already exists
            let existingRow = null;
            $('#itemsBody tr').each(function() {
                if ($(this).data('product-id') == productId) {
                    existingRow = $(this);
                    return false;
                }
            });

            if (existingRow) {
                // Update quantity
                const qtyInput = existingRow.find('.item-quantity');
                const currentQty = parseFloat(qtyInput.val()) || 0;
                qtyInput.val(currentQty + 1);
                updateItemTotal(existingRow);
            } else {
                // Add new row
                addNewItem(productId, productName, productCode, productPrice, productStock);
            }

            // Hide modal
            if (productModal) {
                productModal.hide();
            }
            updateTotals();
        });

        // Remove item
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateTotals();
            checkEmptyCart();
        });

        // Update quantities and prices
        $(document).on('input', '.item-quantity, .item-price', function() {
            const row = $(this).closest('tr');
            updateItemTotal(row);
            updateTotals();
        });

        // Update totals when tax/discount changes
        $('#tax_amount, #discount_amount').on('input', updateTotals);

        // Form validation
        $('#saleForm').on('submit', function(e) {
            if ($('#itemsBody tr').length === 0) {
                e.preventDefault();
                alert('Please add at least one item to the sale.');
                return false;
            }
        });

        function addNewItem(productId, productName, productCode, productPrice, productStock) {
            const rowId = 'item-' + Date.now();
            const rowIndex = itemCount;

            const rowHtml = `
                <tr id="${rowId}" data-product-id="${productId}" class="item-row">
                    <td>
                        <strong>${productName}</strong><br>
                        <small class="text-muted">Code: ${productCode}</small>
                        <input type="hidden" name="items[${rowIndex}][product_id]" value="${productId}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[${rowIndex}][quantity]"
                               class="form-control form-control-sm item-quantity"
                               value="1" min="0.01" max="${productStock}" required>
                        <small class="text-muted">Stock: ${productStock}</small>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[${rowIndex}][unit_price]"
                               class="form-control form-control-sm item-price"
                               value="${productPrice}" min="0" required>
                    </td>
                    <td class="item-total">${parseFloat(productPrice).toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#itemsBody').append(rowHtml);
            $('#emptyCartMessage').hide();
            itemCount++;
        }

        function updateItemTotal(row) {
            const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
            const price = parseFloat(row.find('.item-price').val()) || 0;
            const total = quantity * price;
            row.find('.item-total').text(total.toFixed(2));
        }

        function updateTotals() {
            let subtotal = 0;

            $('.item-row').each(function() {
                const total = parseFloat($(this).find('.item-total').text()) || 0;
                subtotal += total;
            });

            const taxAmount = parseFloat($('#tax_amount').val()) || 0;
            const discountAmount = parseFloat($('#discount_amount').val()) || 0;
            const totalAmount = subtotal + taxAmount - discountAmount;

            $('#subtotal').text(subtotal.toFixed(2));
            $('#total_amount').text(totalAmount.toFixed(2));
        }

        function checkEmptyCart() {
            if ($('.item-row').length === 0) {
                $('#emptyCartMessage').show();
            }
        }

        // Initial check
        checkEmptyCart();
    });

</script>
@endpush
