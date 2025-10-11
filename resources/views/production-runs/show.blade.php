@extends("layouts.app")

@section("title", $productionRun->batch_number)

@section("content")
				<div class="space-y-6">
								<div class="flex items-center justify-between">
												<div>
																<h1 class="text-2xl font-bold text-gray-900">Production Run: {{ $productionRun->batch_number }}</h1>
																<p class="text-gray-600">Production Batch Details</p>
												</div>
												<div class="flex space-x-3">
																<a href="{{ route("production-runs.index") }}"
																				class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
																				<i class="fas fa-arrow-left mr-2"></i>Back to Production
																</a>
												</div>
								</div>

								<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
												<!-- Production Information -->
												<div class="rounded-lg bg-white p-6 shadow">
																<h3 class="mb-4 text-lg font-semibold text-gray-900">Production Information</h3>
																<dl class="space-y-3">
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Batch Number</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->batch_number }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Product</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->billOfMaterial->product->name }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">BOM Used</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->billOfMaterial->name }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Target Quantity</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->quantity_to_produce }} units</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Actual Quantity</dt>
																								<dd
																												class="{{ $productionRun->actual_quantity ? "text-green-600" : "text-gray-600" }} text-sm font-semibold">
																												{{ $productionRun->actual_quantity ?? "Not recorded" }} units
																								</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Production Date</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->production_date->format("M j, Y") }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Completion Date</dt>
																								<dd class="text-sm text-gray-900">
																												{{ $productionRun->completion_date ? $productionRun->completion_date->format("M j, Y") : "Not completed" }}
																								</dd>
																				</div>
																</dl>
												</div>

												<!-- Status & Cost -->
												<div class="rounded-lg bg-white p-6 shadow">
																<h3 class="mb-4 text-lg font-semibold text-gray-900">Status & Cost</h3>
																<dl class="space-y-3">
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Status</dt>
																								<dd class="text-sm">
																												@if ($productionRun->status === "completed")
																																<span
																																				class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
																																				Completed
																																</span>
																												@elseif($productionRun->status === "in_progress")
																																<span
																																				class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
																																				In Progress
																																</span>
																												@else
																																<span
																																				class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
																																				{{ ucfirst($productionRun->status) }}
																																</span>
																												@endif
																								</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Total Material Cost</dt>
																								<dd class="text-lg font-semibold text-blue-600">
																												Rs {{ number_format($productionRun->total_production_cost, 2) }}
																								</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Cost Per Unit</dt>
																								<dd class="text-sm text-gray-900">
																												@if ($productionRun->actual_quantity)
																																Rs
																																{{ number_format($productionRun->total_production_cost / $productionRun->actual_quantity, 2) }}
																												@else
																																N/A
																												@endif
																								</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Created By</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->user->name }}</dd>
																				</div>
																				<div>
																								<dt class="text-sm font-medium text-gray-500">Created On</dt>
																								<dd class="text-sm text-gray-900">{{ $productionRun->created_at->format("M j, Y g:i A") }}</dd>
																				</div>
																</dl>

																@if ($productionRun->notes)
																				<div class="mt-4 border-t border-gray-200 pt-4">
																								<dt class="text-sm font-medium text-gray-500">Notes</dt>
																								<dd class="mt-1 text-sm text-gray-900">{{ $productionRun->notes }}</dd>
																				</div>
																@endif
												</div>

												<!-- Quick Actions -->
												<div class="rounded-lg bg-white p-6 shadow">
																<h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
																<div class="space-y-3">
																				<a href="{{ route("boms.show", $productionRun->billOfMaterial) }}"
																								class="block w-full rounded-lg bg-purple-600 px-4 py-2 text-center text-white hover:bg-purple-700">
																								<i class="fas fa-list-alt mr-2"></i>View Bill of Materials Details
																				</a>
																				<a href="{{ route("products.show", $productionRun->billOfMaterial->product) }}"
																								class="block w-full rounded-lg bg-blue-600 px-4 py-2 text-center text-white hover:bg-blue-700">
																								<i class="fas fa-cube mr-2"></i>View Product
																				</a>
																				<a href="{{ route("stock-ledgers.index") }}?reference_id={{ $productionRun->id }}&reference_type=production_run"
																								class="block w-full rounded-lg bg-green-600 px-4 py-2 text-center text-white hover:bg-green-700">
																								<i class="fas fa-history mr-2"></i>View Stock Impact
																				</a>
																</div>
												</div>
								</div>

								<!-- Materials Used -->
								<div class="rounded-lg bg-white p-6 shadow">
												<h3 class="mb-4 text-lg font-semibold text-gray-900">Materials Used</h3>
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Material</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity Used</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit Cost</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Cost</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Before</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock After</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200">
																								@php
																												$usageLedgers = $productionRun->stockLedgers->where("type", "production_usage");
																								@endphp
																								@foreach ($usageLedgers as $ledger)
																												@php
																																$stockBefore = $ledger->stock_after_transaction + $ledger->quantity_out;
																												@endphp
																												<tr>
																																<td class="px-4 py-3">
																																				<div class="text-sm font-medium text-gray-900">{{ $ledger->item->name }}</div>
																																				<div class="text-sm text-gray-500">{{ $ledger->item->code }}</div>
																																</td>
																																<td class="px-4 py-3 text-sm font-semibold text-red-600">
																																				-{{ $ledger->quantity_out }} {{ $ledger->item->unit }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				Rs {{ number_format($ledger->unit_cost, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm font-semibold text-gray-900">
																																				Rs {{ number_format($ledger->total_cost, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $stockBefore }} {{ $ledger->item->unit }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $ledger->stock_after_transaction }} {{ $ledger->item->unit }}
																																</td>
																												</tr>
																								@endforeach
																								@if ($usageLedgers->count() == 0)
																												<tr>
																																<td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">
																																				No material usage recorded.
																																</td>
																												</tr>
																								@endif
																				</tbody>
																				@if ($usageLedgers->count() > 0)
																								<tfoot class="bg-gray-50">
																												<tr>
																																<td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total
																																				Material Cost:</td>
																																<td class="px-4 py-3 text-sm font-bold text-blue-600">
																																				Rs {{ number_format($usageLedgers->sum("total_cost"), 2) }}
																																</td>
																																<td colspan="2"></td>
																												</tr>
																								</tfoot>
																				@endif
																</table>
												</div>
								</div>

								<!-- Products Produced -->
								<div class="rounded-lg bg-white p-6 shadow">
												<h3 class="mb-4 text-lg font-semibold text-gray-900">Products Produced</h3>
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity Produced
																												</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit Cost</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Value</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Before</th>
																												<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock After</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200">
																								@php
																												$outputLedgers = $productionRun->stockLedgers->where("type", "production_output");
																								@endphp
																								@foreach ($outputLedgers as $ledger)
																												@php
																																$stockBefore = $ledger->stock_after_transaction - $ledger->quantity_in;
																												@endphp
																												<tr>
																																<td class="px-4 py-3">
																																				<div class="text-sm font-medium text-gray-900">{{ $ledger->product->name }}</div>
																																				<div class="text-sm text-gray-500">{{ $ledger->product->code }}</div>
																																</td>
																																<td class="px-4 py-3 text-sm font-semibold text-green-600">
																																				+{{ $ledger->quantity_in }} units
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				Rs {{ number_format($ledger->unit_cost, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm font-semibold text-gray-900">
																																				Rs {{ number_format($ledger->total_cost, 2) }}
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $stockBefore }} units
																																</td>
																																<td class="px-4 py-3 text-sm text-gray-900">
																																				{{ $ledger->stock_after_transaction }} units
																																</td>
																												</tr>
																								@endforeach
																								@if ($outputLedgers->count() == 0)
																												<tr>
																																<td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">
																																				No products produced recorded.
																																</td>
																												</tr>
																								@endif
																				</tbody>
																</table>
												</div>
								</div>
				</div>
@endsection
