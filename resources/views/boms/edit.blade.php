@extends('layouts.app')

@section('title', 'Edit BOM')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Edit Bill of Material: {{ $bom->name }}</h2>
        </div>
        <form action="{{ route('boms.update', $bom) }}" method="POST" class="p-6" id="bomForm">
            @csrf
            @method('PUT')

            <!-- BOM Header -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Product *</label>
                    <select name="product_id" id="product_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $bom->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ $product->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">BOM Name *</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('name', $bom->name) }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $bom->description) }}</textarea>
            </div>

            <!-- BOM Items -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">BOM Items</h3>
                    <button type="button" id="addBomItem" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm">
                        <i class="fas fa-plus mr-1"></i> Add Item
                    </button>
                </div>

                <div id="bom-items-container">
                    <!-- Existing items -->
                    @foreach($bom->bomItems as $index => $bomItem)
                        <div class="bom-item-row grid grid-cols-12 gap-4 mb-4 items-end">
                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Item *</label>
                                <select name="items[{{ $index }}][item_id]" required
                                        class="item-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}"
                                                data-price="{{ $item->current_price }}"
                                                {{ old("items.$index.item_id", $bomItem->item_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }} - ₹{{ number_format($item->current_price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Quantity *</label>
                                <input type="number" name="items[{{ $index }}][quantity]" required min="1" step="0.001"
                                       class="quantity-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old("items.$index.quantity", $bomItem->quantity) }}">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Estimated Cost</label>
                                <input type="text" readonly
                                       class="cost-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100"
                                       value="₹{{ number_format($bomItem->quantity * $bomItem->item->current_price, 2) }}">
                            </div>
                            <div class="col-span-1">
                                <button type="button" class="remove-bom-item bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Total Estimated Cost -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Total Estimated Cost:</span>
                    <span id="totalEstimatedCost" class="text-2xl font-bold text-blue-600">₹{{ number_format($bom->total_estimated_cost, 2) }}</span>
                </div>
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $bom->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Active BOM (can be used for production)
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('boms.show', $bom) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    Update BOM
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Same JavaScript as create form but initialized with existing data
document.addEventListener('DOMContentLoaded', function() {
    let bomItemCount = {{ $bom->bomItems->count() }};
    const bomItemsContainer = document.getElementById('bom-items-container');
    const addBomItemBtn = document.getElementById('addBomItem');
    const totalEstimatedCostSpan = document.getElementById('totalEstimatedCost');

    // Add new BOM item row
    addBomItemBtn.addEventListener('click', function() {
        const newRow = document.createElement('div');
        newRow.className = 'bom-item-row grid grid-cols-12 gap-4 mb-4 items-end';
        newRow.innerHTML = `
            <div class="col-span-6">
                <select name="items[${bomItemCount}][item_id]" required
                        class="item-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Item</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
                            {{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }} - ₹{{ number_format($item->current_price, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3">
                <input type="number" name="items[${bomItemCount}][quantity]" required min="1" step="0.001"
                       class="quantity-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="col-span-2">
                <input type="text" readonly
                       class="cost-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100">
            </div>
            <div class="col-span-1">
                <button type="button" class="remove-bom-item bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        bomItemsContainer.appendChild(newRow);
        bomItemCount++;

        // Add event listeners to new row
        addBomItemEventListeners(newRow);
    });

    // Add event listeners to a BOM item row
    function addBomItemEventListeners(row) {
        const itemSelect = row.querySelector('.item-select');
        const quantityInput = row.querySelector('.quantity-input');
        const costInput = row.querySelector('.cost-input');
        const removeBtn = row.querySelector('.remove-bom-item');

        // Calculate cost when item or quantity changes
        itemSelect.addEventListener('change', calculateBomItemCost);
        quantityInput.addEventListener('input', calculateBomItemCost);

        // Remove row
        removeBtn.addEventListener('click', function() {
            if (document.querySelectorAll('.bom-item-row').length > 1) {
                row.remove();
                calculateTotalEstimatedCost();
            }
        });

        function calculateBomItemCost() {
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
            const quantity = parseFloat(quantityInput.value) || 0;

            if (price && quantity) {
                const cost = (price * quantity).toFixed(2);
                costInput.value = '₹' + cost;
            } else {
                costInput.value = '';
            }

            calculateTotalEstimatedCost();
        }

        // Calculate initial cost for existing rows
        calculateBomItemCost();
    }

    // Calculate total estimated cost
    function calculateTotalEstimatedCost() {
        let total = 0;
        document.querySelectorAll('.bom-item-row').forEach(row => {
            const costInput = row.querySelector('.cost-input');
            const costValue = costInput.value.replace('₹', '');
            if (costValue) {
                total += parseFloat(costValue);
            }
        });
        totalEstimatedCostSpan.textContent = '₹' + total.toFixed(2);
    }

    // Add event listeners to all existing rows
    document.querySelectorAll('.bom-item-row').forEach(row => {
        addBomItemEventListeners(row);
    });
});
</script>
@endsection