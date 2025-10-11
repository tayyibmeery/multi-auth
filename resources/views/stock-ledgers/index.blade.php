@extends("layouts.app")

@section("title", "Stock Ledger")

@section("content")
				<div class="space-y-6">
								<div class="flex items-center justify-between">
												<div>
																<h1 class="text-2xl font-bold text-gray-900">Stock Ledger</h1>
																<p class="text-gray-600">Complete audit trail of all stock movements</p>
												</div>
								</div>

								<!-- Filters -->
								<div class="rounded-lg bg-white p-4 shadow">
												<form method="GET" action="{{ route("stock-ledgers.index") }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
																<div>
																				<label for="type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
																				<select name="type" id="type"
																								class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																								<option value="">All Types</option>
																								<option value="purchase" {{ request("type") == "purchase" ? "selected" : "" }}>Purchase</option>
																								<option value="production_usage" {{ request("type") == "production_usage" ? "selected" : "" }}>
																												Production Usage</option>
																								<option value="production_output" {{ request("type") == "production_output" ? "selected" : "" }}>
																												Production Output</option>
																								<option value="adjustment" {{ request("type") == "adjustment" ? "selected" : "" }}>Adjustment
																								</option>
																								<option value="sale" {{ request("type") == "sale" ? "selected" : "" }}>Sale</option>
																				</select>
																</div>
																<div>
																				<label for="item_id" class="block text-sm font-medium text-gray-700">Item</label>
																				<select name="item_id" id="item_id"
																								class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
																								<option value="">All Items</option>
																								@foreach (\App\Models\Item::all() as $item)
																												<option value="{{ $item->id }}" {{ request("item_id") == $item->id ? "selected" : "" }}>
																																{{ $item->name }} ({{ $item->code }})
																												</option>
																								@endforeach
																				</select>
																</div>
																<div>
																				<label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
																				<input type="date" name="date_from" id="date_from"
																								class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																								value="{{ request("date_from") }}">
																</div>
																<div>
																				<label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
																				<input type="date" name="date_to" id="date_to"
																								class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																								value="{{ request("date_to") }}">
																</div>
																<div class="flex justify-end space-x-3 md:col-span-4">
																				<a href="{{ route("stock-ledgers.index") }}"
																								class="rounded-lg bg-gray-300 px-4 py-2 font-medium text-gray-800 hover:bg-gray-400">
																								Clear Filters
																				</a>
																				<button type="submit"
																								class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
																								Apply Filters
																				</button>
																</div>
												</form>
								</div>

								<!-- Stock Ledger Table -->
								<div class="overflow-hidden rounded-lg bg-white shadow">
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date
																												</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Type
																												</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Item/Product</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Reference</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Quantity In</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Quantity Out</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Unit
																																Cost</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total
																																Cost</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock
																																After</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">User
																												</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200 bg-white">
																								@forelse($stockLedgers as $ledger)
																												<tr class="hover:bg-gray-50">
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">

																																				{{ \Carbon\Carbon::parse($ledger->date)->format("d M, Y") }}
																																</td>
																																<td class="whitespace-nowrap px-6 py-4">
																																				<span
																																								class="{{ $ledger->type == "purchase" ? "bg-green-100 text-green-800" : "" }} {{ $ledger->type == "production_output" ? "bg-blue-100 text-blue-800" : "" }} {{ $ledger->type == "production_usage" ? "bg-yellow-100 text-yellow-800" : "" }} {{ $ledger->type == "adjustment" ? "bg-purple-100 text-purple-800" : "" }} {{ $ledger->type == "sale" ? "bg-red-100 text-red-800" : "" }} inline-flex rounded-full px-2 text-xs font-semibold leading-5">
																																								{{ ucfirst(str_replace("_", " ", $ledger->type)) }}
																																				</span>
																																</td>
																																<td class="whitespace-nowrap px-6 py-4">
																																				@if ($ledger->item)
																																								<div class="text-sm font-medium text-gray-900">{{ $ledger->item->name }}</div>
																																								<div class="text-sm text-gray-500">{{ $ledger->item->code }}</div>
																																				@elseif($ledger->product)
																																								<div class="text-sm font-medium text-gray-900">{{ $ledger->product->name }}</div>
																																								<div class="text-sm text-gray-500">{{ $ledger->product->code }}</div>
																																				@else
																																								<span class="text-sm text-gray-500">N/A</span>
																																				@endif
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
																																				{{ $ledger->reference_type }} #{{ $ledger->reference_id }}
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-green-600">
																																				@if ($ledger->quantity_in > 0)
																																								+{{ $ledger->quantity_in }}
																																				@endif
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-red-600">
																																				@if ($ledger->quantity_out > 0)
																																								-{{ $ledger->quantity_out }}
																																				@endif
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
																																				Rs {{ number_format($ledger->unit_cost, 2) }}
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
																																				Rs {{ number_format($ledger->total_cost, 2) }}
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
																																				{{ $ledger->stock_after_transaction }}
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
																																				{{ $ledger->user->name }}
																																</td>
																												</tr>
																								@empty
																												<tr>
																																<td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
																																				No stock movements found.
																																</td>
																												</tr>
																								@endforelse
																				</tbody>
																</table>
												</div>

												@if ($stockLedgers->hasPages())
																<div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
																				{{ $stockLedgers->links() }}
																</div>
												@endif
								</div>
				</div>
@endsection
