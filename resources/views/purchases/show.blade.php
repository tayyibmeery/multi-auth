@extends("layouts.app")

@section("title", $purchase->purchase_number)

@section("content")
				<div class="space-y-6">
								<div class="flex items-center justify-between">
												<div>
																<h1 class="text-2xl font-bold text-gray-900">Purchase: {{ $purchase->purchase_number }}</h1>
																<p class="text-gray-600">Purchase Order Details</p>
												</div>
												<div class="flex space-x-3">
																<a href="{{ route("purchases.index") }}"
																				class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
																				<i class="fas fa-arrow-left mr-2"></i>Back to Purchases
																</a>
												</div>
								</div>

								<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
												<!-- Purchase Information -->
												<div class="rounded-lg bg-white p-6 shadow">
																<h3 class="mb-4 text-lg font-semibold text-gray-900">Purchase Information</h3>
																<dl class="space-y-3">
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Purchase Number</dt>
																								<dd class="text-sm text-gray-900">{{ $purchase->purchase_number }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Vendor</dt>
																								<dd class="text-sm text-gray-900">{{ $purchase->vendor->name }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Purchase Date</dt>
																								<dd class="text-sm text-gray-900">{{ $purchase->purchase_date->format("M j, Y") }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Total Amount</dt>
																								<dd class="text-lg font-semibold text-blue-600">Rs {{ number_format($purchase->total_amount, 2) }}
																								</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Created By</dt>
																								<dd class="text-sm text-gray-900">{{ $purchase->user->name }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Created On</dt>
																								<dd class="text-sm text-gray-900">{{ $purchase->created_at->format("M j, Y g:i A") }}</dd>
																				</div>
																</dl>

																@if ($purchase->notes)
																				<div class="mt-4 border-t border-gray-200 pt-4">
																								<dt class="text-sm font-medium text-gray-500">Notes</dt>
																								<dd class="mt-1 text-sm text-gray-900">{{ $purchase->notes }}</dd>
																				</div>
																@endif
												</div>

												<!-- Purchase Items -->
												<div class="rounded-lg bg-white p-6 shadow lg:col-span-2">
																<h3 class="mb-4 text-lg font-semibold text-gray-900">Purchase Items</h3>
																<div class="overflow-x-auto">
																				<table class="min-w-full divide-y divide-gray-200">
																								<thead class="bg-gray-50">
																												<tr>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Item</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit Price</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Price</th>
																												</tr>
																								</thead>
																								<tbody class="divide-y divide-gray-200">
																												@foreach ($purchase->purchaseItems as $item)
																																<tr>
																																				<td class="px-4 py-3">
																																								<div class="text-sm font-medium text-gray-900">{{ $item->item->name }}</div>
																																								<div class="text-sm text-gray-500">{{ $item->item->code }}</div>
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								{{ $item->quantity }} {{ $item->item->unit }}
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								Rs {{ number_format($item->unit_price, 2) }}
																																				</td>
																																				<td class="px-4 py-3 text-sm font-semibold text-gray-900">
																																								Rs {{ number_format($item->total_price, 2) }}
																																				</td>
																																</tr>
																												@endforeach
																								</tbody>
																								<tfoot class="bg-gray-50">
																												<tr>
																																<td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total:
																																</td>
																																<td class="px-4 py-3 text-sm font-bold text-blue-600">
																																				Rs {{ number_format($purchase->total_amount, 2) }}
																																</td>
																												</tr>
																								</tfoot>
																				</table>
																</div>
												</div>
								</div>

								<!-- Stock Impact -->
								<div class="rounded-lg bg-white p-6 shadow">
												<h3 class="mb-4 text-lg font-semibold text-gray-900">Stock Impact</h3>
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Item</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Previous Stock</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity Added</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">New Stock</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200">
																								@foreach ($purchase->purchaseItems as $item)
																												@php
																																$previousStock = $item->item->current_stock - $item->quantity;
																												@endphp
																												<tr>
																																<td class="px-4 py-3">
																																				<div class="text-sm font-medium text-gray-900">{{ $item->item->name }}</div>
																																				<div class="text-sm text-gray-500">{{ $item->item->code }}</div>
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $previousStock }} {{ $item->item->unit }}
																																</td>
																																<td class="px-4 py-3 text-sm font-semibold text-green-600">
																																				+{{ $item->quantity }} {{ $item->item->unit }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $item->item->current_stock }} {{ $item->item->unit }}
																																</td>
																																<td class="px-4 py-3">
																																				@if ($item->item->current_stock == 0)
																																								<span
																																												class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
																																												Out of Stock
																																								</span>
																																				@elseif($item->item->is_low_stock)
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
				</div>
@endsection
