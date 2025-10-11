@extends("layouts.app")

@section("title", "Stock Report")

@section("content")
				<div class="space-y-6">
								<div class="flex items-center justify-between">
												<div>
																<h1 class="text-2xl font-bold text-gray-900">Stock Report</h1>
																<p class="text-gray-600">Current inventory levels and valuations</p>
												</div>
												<div class="flex space-x-3">
																<a href="{{ route("reports.stock-valuation") }}"
																				class="rounded-lg bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700">
																				<i class="fas fa-calculator mr-2"></i>Stock Valuation
																</a>
																<a href="{{ route("reports.low-stock") }}"
																				class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700">
																				<i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Report
																</a>
												</div>
								</div>

								<!-- Summary Cards -->
								<div class="grid grid-cols-1 gap-4 md:grid-cols-4">
												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-blue-100 p-2">
																								<i class="fas fa-boxes text-blue-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Total Items</p>
																								<p class="text-lg font-semibold">{{ $items->count() }}</p>
																				</div>
																</div>
												</div>

												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-green-100 p-2">
																								<i class="fas fa-cube text-green-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Total Products</p>
																								<p class="text-lg font-semibold">{{ $products->count() }}</p>
																				</div>
																</div>
												</div>

												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-red-100 p-2">
																								<i class="fas fa-exclamation-triangle text-red-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Low Stock Items</p>
																								<p class="text-lg font-semibold">{{ $items->where("is_low_stock", true)->count() }}</p>
																				</div>
																</div>
												</div>

												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-gray-100 p-2">
																								<i class="fas fa-times-circle text-gray-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Out of Stock</p>
																								<p class="text-lg font-semibold">{{ $items->where("current_stock", 0)->count() }}</p>
																				</div>
																</div>
												</div>
								</div>

								<!-- Items Stock -->
								<div class="rounded-lg bg-white p-6 shadow">
												<h2 class="mb-4 text-xl font-semibold text-gray-900">Items Stock</h2>
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Item</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Category</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Current Stock</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Min Stock</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit Price</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Value</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200">
																								@foreach ($items as $item)
																												<tr>
																																<td class="px-4 py-3">
																																				<div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
																																				<div class="text-sm text-gray-500">{{ $item->code }}</div>
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $item->category->name }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $item->current_stock }} {{ $item->unit }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $item->min_stock }} {{ $item->unit }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				Rs {{ number_format($item->current_price, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				Rs {{ number_format($item->stock_value, 2) }}
																																</td>
																																<td class="px-4 py-3">
																																				@if ($item->current_stock == 0)
																																								<span
																																												class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
																																												Out of Stock
																																								</span>
																																				@elseif($item->is_low_stock)
																																								<span
																																												class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
																																												Low Stock
																																								</span>
																																				@else
																																								<span
																																												class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
																																												In Stock
																																								</span>
																																				@endif
																																</td>
																												</tr>
																								@endforeach
																				</tbody>
																</table>
												</div>
								</div>

								<!-- Products Stock -->
								<div class="rounded-lg bg-white p-6 shadow">
												<h2 class="mb-4 text-xl font-semibold text-gray-900">Products Stock</h2>
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Current Stock</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Selling Price</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Value</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">BOM Count</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200">
																								@foreach ($products as $product)
																												<tr>
																																<td class="px-4 py-3">
																																				<div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
																																				<div class="text-sm text-gray-500">{{ $product->code }}</div>
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $product->current_stock }} units
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				Rs {{ number_format($product->selling_price, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				Rs {{ number_format($product->stock_value, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $product->billOfMaterials->count() }}
																																</td>
																																<td class="px-4 py-3">
																																				@if ($product->current_stock == 0)
																																								<span
																																												class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
																																												Out of Stock
																																								</span>
																																				@else
																																								<span
																																												class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
																																												In Stock
																																								</span>
																																				@endif
																																</td>
																												</tr>
																								@endforeach
																				</tbody>
																</table>
												</div>
								</div>
				</div>
@endsection
