@extends("layouts.app")

@section("title", "Create BOM")

@section("content")
				<div class="mx-auto max-w-7xl">
								<div class="rounded-lg bg-white shadow">
												<div class="border-b border-gray-200 px-6 py-4">
																<h2 class="text-xl font-semibold text-gray-800">Create Bill of Material</h2>
												</div>
												<form action="{{ route("boms.store") }}" method="POST" class="p-6" id="bomForm">
																@csrf

																<!--  Bill of Materials Header -->
																<div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
																				<div>
																								<label for="product_id" class="block text-sm font-medium text-gray-700">Product *</label>
																								<select name="product_id" id="product_id" required
																												class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																												<option value="">Select Product</option>
																												@foreach ($products as $product)
																																<option value="{{ $product->id }}"
																																				{{ old("product_id") == $product->id ? "selected" : "" }}>
																																				{{ $product->name }} ({{ $product->code }})
																																</option>
																												@endforeach
																								</select>
																								@error("product_id")
																												<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																								@enderror
																				</div>

																				<div>
																								<label for="name" class="block text-sm font-medium text-gray-700">BOM Name *</label>
																								<input type="text" name="name" id="name" required
																												class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																												value="{{ old("name") }}">
																								@error("name")
																												<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																								@enderror
																				</div>
																</div>

																<div class="mb-6">
																				<label for="description" class="block text-sm font-medium text-gray-700">Description</label>
																				<textarea name="description" id="description" rows="3"
																				    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">{{ old("description") }}</textarea>
																</div>

																<!--  Bill of Materials Items -->
																<div class="mb-6">
																				<div class="mb-4 flex items-center justify-between">
																								<h3 class="text-lg font-medium text-gray-900">BOM Items</h3>
																								<button type="button" id="addBomItem"
																												class="rounded-lg bg-green-600 px-3 py-2 text-sm text-white hover:bg-green-700">
																												<i class="fas fa-plus mr-1"></i> Add Item
																								</button>
																				</div>

																				<div id="bom-items-container">
																								<!-- Items will be added here dynamically -->
																								<div class="bom-item-row mb-4 grid grid-cols-12 items-end gap-4">
																												<div class="col-span-6">
																																<label class="block text-sm font-medium text-gray-700">Item *</label>
																																<select name="items[0][item_id]" required
																																				class="item-select mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																																				<option value="">Select Item</option>
																																				@foreach ($items as $item)
																																								<option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
																																												{{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }}
																																												- Rs {{ number_format($item->current_price, 2) }}
																																								</option>
																																				@endforeach
																																</select>
																												</div>
																												<div class="col-span-3">
																																<label class="block text-sm font-medium text-gray-700">Quantity *</label>
																																<input type="number" name="items[0][quantity]" required min="1" step="0.001"
																																				class="quantity-input mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																												</div>
																												<div class="col-span-2">
																																<label class="block text-sm font-medium text-gray-700">Estimated Cost</label>
																																<input type="text" readonly
																																				class="cost-input mt-1 block w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 shadow-sm">
																												</div>
																												<div class="col-span-1">
																																<button type="button"
																																				class="remove-bom-item rounded-lg bg-red-600 p-2 text-white hover:bg-red-700">
																																				<i class="fas fa-times"></i>
																																</button>
																												</div>
																								</div>
																				</div>
																</div>

																<!-- Total Estimated Cost -->
																<div class="mb-6 rounded-lg bg-gray-50 p-4">
																				<div class="flex items-center justify-between">
																								<span class="text-lg font-semibold text-gray-900">Total Estimated Cost:</span>
																								<span id="totalEstimatedCost" class="text-2xl font-bold text-blue-600">Rs 0.00</span>
																				</div>
																</div>

																<div class="mb-6 flex items-center">
																				<input type="checkbox" name="is_active" id="is_active" value="1" checked
																								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
																				<label for="is_active" class="ml-2 block text-sm text-gray-900">
																								Active Bill of Materials (can be used for production)
																				</label>
																</div>

																<div class="flex justify-end space-x-3">
																				<a href="{{ route("boms.index") }}"
																								class="rounded-lg bg-gray-300 px-4 py-2 font-medium text-gray-800 hover:bg-gray-400">
																								Cancel
																				</a>
																				<button type="submit"
																								class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
																								Create BOM
																				</button>
																</div>
												</form>
								</div>
				</div>

				<script>
								document.addEventListener('DOMContentLoaded', function() {
												let bomItemCount = 1;
												const bomItemsContainer = document.getElementById('bom-items-container');
												const addBomItemBtn = document.getElementById('addBomItem');
												const totalEstimatedCostSpan = document.getElementById('totalEstimatedCost');

												// Add new  Bill of Materials item row
												addBomItemBtn.addEventListener('click', function() {
																const newRow = document.createElement('div');
																newRow.className = 'bom-item-row grid grid-cols-12 gap-4 mb-4 items-end';
																newRow.innerHTML = `
            <div class="col-span-6">
                <select name="items[${bomItemCount}][item_id]" required
                        class="item-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
                            {{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }} - Rs {{ number_format($item->current_price, 2) }}
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

												// Add event listeners to a  Bill of Materials item row
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

												// Add event listeners to initial row
												document.querySelectorAll('.bom-item-row').forEach(row => {
																addBomItemEventListeners(row);
												});

												// Pre-fill product if provided in URL
												const urlParams = new URLSearchParams(window.location.search);
												const productId = urlParams.get('product_id');
												if (productId) {
																document.getElementById('product_id').value = productId;
												}
								});
				</script>
@endsection
