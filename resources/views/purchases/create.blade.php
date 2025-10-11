@extends("layouts.app")

@section("title", "Create Purchase")

@section("content")
				<div class="mx-auto max-w-7xl">
								<div class="rounded-lg bg-white shadow">
												<div class="border-b border-gray-200 px-6 py-4">
																<h2 class="text-xl font-semibold text-gray-800">Create New Purchase</h2>
												</div>
												<form action="{{ route("purchases.store") }}" method="POST" class="p-6" id="purchaseForm">
																@csrf

																<!-- Purchase Header -->
																<div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
																				<div>
																								<label for="vendor_id" class="block text-sm font-medium text-gray-700">Vendor *</label>
																								<select name="vendor_id" id="vendor_id" required
																												class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																												<option value="">Select Vendor</option>
																												@foreach ($vendors as $vendor)
																																<option value="{{ $vendor->id }}" {{ old("vendor_id") == $vendor->id ? "selected" : "" }}>
																																				{{ $vendor->name }}
																																</option>
																												@endforeach
																								</select>
																								@error("vendor_id")
																												<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																								@enderror
																				</div>

																				<div>
																								<label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date *</label>
																								<input type="date" name="purchase_date" id="purchase_date" required
																												class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																												value="{{ old("purchase_date", date("Y-m-d")) }}">
																								@error("purchase_date")
																												<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																								@enderror
																				</div>
																</div>

																<!-- Purchase Items -->
																<div class="mb-6">
																				<div class="mb-4 flex items-center justify-between">
																								<h3 class="text-lg font-medium text-gray-900">Purchase Items</h3>
																								<button type="button" id="addItem"
																												class="rounded-lg bg-green-600 px-3 py-2 text-sm text-white hover:bg-green-700">
																												<i class="fas fa-plus mr-1"></i> Add Item
																								</button>
																				</div>

																				<div id="items-container">
																								<!-- Items will be added here dynamically -->
																								<div class="item-row mb-4 grid grid-cols-12 items-end gap-4">
																												<div class="col-span-5">
																																<label class="block text-sm font-medium text-gray-700">Item *</label>
																																<select name="items[0][item_id]" required
																																				class="item-select mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																																				<option value="">Select Item</option>
																																				@foreach ($items as $item)
																																								<option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
																																												{{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }}
																																								</option>
																																				@endforeach
																																</select>
																												</div>
																												<div class="col-span-2">
																																<label class="block text-sm font-medium text-gray-700">Quantity *</label>
																																<input type="number" name="items[0][quantity]" required min="1"
																																				class="quantity-input mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																												</div>
																												<div class="col-span-2">
																																<label class="block text-sm font-medium text-gray-700">Unit Price (Rs ) *</label>
																																<input type="number" name="items[0][unit_price]" required step="0.01" min="0"
																																				class="price-input mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																												</div>
																												<div class="col-span-2">
																																<label class="block text-sm font-medium text-gray-700">Total (Rs )</label>
																																<input type="text" readonly
																																				class="total-input mt-1 block w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 shadow-sm">
																												</div>
																												<div class="col-span-1">
																																<button type="button"
																																				class="remove-item rounded-lg bg-red-600 p-2 text-white hover:bg-red-700">
																																				<i class="fas fa-times"></i>
																																</button>
																												</div>
																								</div>
																				</div>
																</div>

																<!-- Total Amount -->
																<div class="mb-6 rounded-lg bg-gray-50 p-4">
																				<div class="flex items-center justify-between">
																								<span class="text-lg font-semibold text-gray-900">Total Amount:</span>
																								<span id="totalAmount" class="text-2xl font-bold text-blue-600">Rs 0.00</span>
																				</div>
																</div>

																<!-- Notes -->
																<div class="mb-6">
																				<label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
																				<textarea name="notes" id="notes" rows="3"
																				    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">{{ old("notes") }}</textarea>
																</div>

																<div class="flex justify-end space-x-3">
																				<a href="{{ route("purchases.index") }}"
																								class="rounded-lg bg-gray-300 px-4 py-2 font-medium text-gray-800 hover:bg-gray-400">
																								Cancel
																				</a>
																				<button type="submit"
																								class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
																								Create Purchase
																				</button>
																</div>
												</form>
								</div>
				</div>

				<script>
								document.addEventListener('DOMContentLoaded', function() {
												let itemCount = 1;
												const itemsContainer = document.getElementById('items-container');
												const addItemBtn = document.getElementById('addItem');
												const totalAmountSpan = document.getElementById('totalAmount');

												// Add new item row
												addItemBtn.addEventListener('click', function() {
																const newRow = document.createElement('div');
																newRow.className = 'item-row grid grid-cols-12 gap-4 mb-4 items-end';
																newRow.innerHTML = `
            <div class="col-span-5">
                <select name="items[${itemCount}][item_id]" required
                        class="item-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->current_price }}">
                            {{ $item->name }} ({{ $item->code }}) - Stock: {{ $item->current_stock }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <input type="number" name="items[${itemCount}][quantity]" required min="1"
                       class="quantity-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="col-span-2">
                <input type="number" name="items[${itemCount}][unit_price]" required step="0.01" min="0"
                       class="price-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="col-span-2">
                <input type="text" readonly
                       class="total-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100">
            </div>
            <div class="col-span-1">
                <button type="button" class="remove-item bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
																itemsContainer.appendChild(newRow);
																itemCount++;

																// Add event listeners to new row
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
																itemSelect.addEventListener('change', function() {
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

												// Add event listeners to initial row
												document.querySelectorAll('.item-row').forEach(row => {
																addEventListenersToRow(row);
												});

												// Pre-fill item if provided in URL
												const urlParams = new URLSearchParams(window.location.search);
												const itemId = urlParams.get('item_id');
												if (itemId) {
																const firstItemSelect = document.querySelector('.item-select');
																firstItemSelect.value = itemId;
																firstItemSelect.dispatchEvent(new Event('change'));
												}
								});
				</script>
@endsection
