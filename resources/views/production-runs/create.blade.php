@extends("layouts.app")

@section("title", "Start Production Run")

@section("content")
				<div class="mx-auto max-w-4xl">
								<div class="rounded-lg bg-white shadow">
												<div class="border-b border-gray-200 px-6 py-4">
																<h2 class="text-xl font-semibold text-gray-800">Start Production Run</h2>
												</div>
												<form action="{{ route("production-runs.store") }}" method="POST" class="p-6" id="productionForm">
																@csrf

																<!-- Production Header -->
																<div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
																				<div>
																								<label for="bom_id" class="block text-sm font-medium text-gray-700">Bill of Material *</label>
																								<select name="bom_id" id="bom_id" required
																												class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																												<option value="">Select BOM</option>
																												@foreach ($boms as $bom)
																																<option value="{{ $bom->id }}" data-product="{{ $bom->product->name }}"
																																				data-cost="{{ $bom->total_estimated_cost }}"
																																				{{ old("bom_id") == $bom->id ? "selected" : "" }}>
																																				{{ $bom->name }} - {{ $bom->product->name }} (Cost: Rs
																																				{{ number_format($bom->total_estimated_cost, 2) }})
																																</option>
																												@endforeach
																								</select>
																								@error("bom_id")
																												<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																								@enderror
																				</div>

																				<div>
																								<label for="production_date" class="block text-sm font-medium text-gray-700">Production Date
																												*</label>
																								<input type="date" name="production_date" id="production_date" required
																												class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																												value="{{ old("production_date", date("Y-m-d")) }}">
																								@error("production_date")
																												<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																								@enderror
																				</div>
																</div>

																<!-- Product Information -->
																<div id="productInfo" class="mb-6 hidden rounded-lg bg-blue-50 p-4">
																				<h4 class="mb-2 text-sm font-medium text-blue-900">Product Information</h4>
																				<p class="text-sm text-blue-700">
																								Product: <span id="productName" class="font-semibold"></span>
																				</p>
																				<p class="text-sm text-blue-700">
																								Material Cost: <span id="materialCost" class="font-semibold"></span>
																				</p>
																</div>

																<!-- Quantity -->
																<div class="mb-6">
																				<label for="quantity_to_produce" class="block text-sm font-medium text-gray-700">Quantity to Produce
																								*</label>
																				<input type="number" name="quantity_to_produce" id="quantity_to_produce" required min="1"
																								class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																								value="{{ old("quantity_to_produce", 1) }}">
																				@error("quantity_to_produce")
																								<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																				@enderror
																</div>

																<!--  Bill of Materials Items Preview -->
																<div id="bomItemsPreview" class="mb-6 hidden">
																				<h3 class="mb-4 text-lg font-medium text-gray-900">Required Materials</h3>
																				<div class="rounded-lg bg-gray-50 p-4">
																								<div id="stockCheckResults"></div>
																								<table class="mt-4 hidden min-w-full divide-y divide-gray-200" id="materialsTable">
																												<thead class="bg-gray-100">
																																<tr>
																																				<th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Item</th>
																																				<th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Required
																																				</th>
																																				<th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Available
																																				</th>
																																				<th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Status</th>
																																</tr>
																												</thead>
																												<tbody id="materialsTableBody" class="divide-y divide-gray-200">
																												</tbody>
																								</table>
																				</div>
																</div>

																<!-- Total Cost -->
																<div id="totalCostSection" class="mb-6 hidden rounded-lg bg-gray-50 p-4">
																				<div class="flex items-center justify-between">
																								<span class="text-lg font-semibold text-gray-900">Total Material Cost:</span>
																								<span id="totalProductionCost" class="text-2xl font-bold text-blue-600">Rs 0.00</span>
																				</div>
																</div>

																<!-- Notes -->
																<div class="mb-6">
																				<label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
																				<textarea name="notes" id="notes" rows="3"
																				    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">{{ old("notes") }}</textarea>
																</div>

																<div class="flex justify-end space-x-3">
																				<a href="{{ route("production-runs.index") }}"
																								class="rounded-lg bg-gray-300 px-4 py-2 font-medium text-gray-800 hover:bg-gray-400">
																								Cancel
																				</a>
																				<button type="submit" id="submitBtn"
																								class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
																								Start Production
																				</button>
																</div>
												</form>
								</div>
				</div>

				<script>
								document.addEventListener('DOMContentLoaded', function() {
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

												// Load  Bill of Materials details when selected
												bomSelect.addEventListener('change', function() {
																const selectedOption = this.options[this.selectedIndex];
																if (selectedOption.value) {
																				const product = selectedOption.getAttribute('data-product');
																				const cost = selectedOption.getAttribute('data-cost');

																				productName.textContent = product;
																				materialCost.textContent = 'Rs ' + parseFloat(cost).toFixed(2);
																				productInfo.classList.remove('hidden');

																				// Load  Bill of Materials items
																				loadBomItems(selectedOption.value);
																} else {
																				productInfo.classList.add('hidden');
																				bomItemsPreview.classList.add('hidden');
																				totalCostSection.classList.add('hidden');
																}
												});

												// Update quantities and costs when quantity changes
												quantityInput.addEventListener('input', function() {
																if (bomSelect.value) {
																				loadBomItems(bomSelect.value);
																}
												});

												// Load  Bill of Materials items via AJAX
												function loadBomItems(bomId) {
																fetch(`/boms/${bomId}/items`)
																				.then(response => response.json())
																				.then(data => {
																								displayBomItems(data.items, quantityInput.value);
																								calculateTotalCost(data.items, quantityInput.value);
																								checkStockAvailability(data.items, quantityInput.value);
																				})
																				.catch(error => {
																								console.error('Error loading  Bill of Materials items:', error);
																				});
												}

												// Display  Bill of Materials items
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
                <td class="px-4 py-2 text-sm text-gray-900">
                    ${item.item.name} (${item.item.code})
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    ${requiredQuantity} ${item.item.unit}
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    ${item.item.current_stock} ${item.item.unit}
                </td>
                <td class="px-4 py-2">
                    ${hasEnoughStock ?
                        '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sufficient</span>' :
                        '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Short: ' + (requiredQuantity - item.item.current_stock) + '</span>'
                    }
                </td>
            `;
																				materialsTableBody.appendChild(row);
																});

																// Show/hide materials table
																if (items.length > 0) {
																				materialsTable.classList.remove('hidden');
																				bomItemsPreview.classList.remove('hidden');
																} else {
																				materialsTable.classList.add('hidden');
																}

																// Update stock check results
																if (allItemsInStock) {
																				stockCheckResults.innerHTML = `
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    All materials are available in stock. Production can proceed.
                </div>
            `;
																				submitBtn.disabled = false;
																				submitBtn.classList.remove('bg-gray-400');
																				submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
																} else {
																				stockCheckResults.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Some materials are insufficient. Please check stock levels before proceeding.
                </div>
            `;
																				submitBtn.disabled = false; // Still allow production but with warning
																				submitBtn.classList.remove('bg-gray-400');
																				submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
																}
												}

												// Calculate total cost
												function calculateTotalCost(items, quantity) {
																let totalCost = 0;
																items.forEach(item => {
																				totalCost += item.item.current_price * item.quantity * quantity;
																});

																totalProductionCost.textContent = 'Rs ' + totalCost.toFixed(2);
																totalCostSection.classList.remove('hidden');
												}

												// Check stock availability
												function checkStockAvailability(items, quantity) {
																let allInStock = true;
																items.forEach(item => {
																				if (item.item.current_stock < (item.quantity * quantity)) {
																								allInStock = false;
																				}
																});
																return allInStock;
												}

												// Pre-fill  Bill of Materials if provided in URL
												const urlParams = new URLSearchParams(window.location.search);
												const bomId = urlParams.get('bom_id');
												const productId = urlParams.get('product_id');

												if (bomId) {
																bomSelect.value = bomId;
																bomSelect.dispatchEvent(new Event('change'));
												} else if (productId) {
																// If product ID is provided, select the first active  Bill of Materials for that product
																const options = Array.from(bomSelect.options);
																const productBom = options.find(option => {
																				return option.getAttribute('data-product-id') === productId && option.value !== '';
																});
																if (productBom) {
																				bomSelect.value = productBom.value;
																				bomSelect.dispatchEvent(new Event('change'));
																}
												}
								});
				</script>
@endsection
