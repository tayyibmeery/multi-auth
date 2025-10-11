@extends("layouts.app")

@section("title", "Production Report")

@section("content")
				<div class="space-y-6">
								<div class="flex items-center justify-between">
												<div>
																<h1 class="text-2xl font-bold text-gray-900">Production Report</h1>
																<p class="text-gray-600">Manufacturing analysis and production statistics</p>
												</div>
												<div class="flex space-x-3">
																<a href="{{ route("reports.stock") }}"
																				class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
																				<i class="fas fa-boxes mr-2"></i>Stock Report
																</a>
																<a href="{{ route("reports.purchases") }}"
																				class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
																				<i class="fas fa-shopping-cart mr-2"></i>Purchases Report
																</a>
												</div>
								</div>

								<!-- Summary Cards -->
								<div class="grid grid-cols-1 gap-4 md:grid-cols-4">
												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-blue-100 p-2">
																								<i class="fas fa-industry text-blue-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Total Runs</p>
																								<p class="text-lg font-semibold">{{ $productionRuns->count() }}</p>
																				</div>
																</div>
												</div>
												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-green-100 p-2">
																								<i class="fas fa-check-circle text-green-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Completed</p>
																								<p class="text-lg font-semibold">{{ $productionRuns->where("status", "completed")->count() }}</p>
																				</div>
																</div>
												</div>
												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-orange-100 p-2">
																								<i class="fas fa-cube text-orange-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Total Produced</p>
																								<p class="text-lg font-semibold">{{ $productionRuns->sum("actual_quantity") }} units</p>
																				</div>
																</div>
												</div>
												<div class="rounded-lg bg-white p-4 shadow">
																<div class="flex items-center">
																				<div class="rounded-lg bg-purple-100 p-2">
																								<i class="fas fa-money-bill-wave text-purple-600"></i>
																				</div>
																				<div class="ml-3">
																								<p class="text-sm font-medium text-gray-600">Products</p>
																								<p class="text-lg font-semibold">{{ $productionRuns->groupBy("bom_id")->count() }}</p>
																				</div>
																</div>
												</div>
								</div>

								<!-- Production Runs Table -->
								<div class="overflow-hidden rounded-lg bg-white shadow">
												<div class="overflow-x-auto">
																<table class="min-w-full divide-y divide-gray-200">
																				<thead class="bg-gray-50">
																								<tr>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Batch
																																No</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Product</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">BOM
																												</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Quantity</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date
																												</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
																																Status</th>
																												<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cost
																												</th>
																								</tr>
																				</thead>
																				<tbody class="divide-y divide-gray-200 bg-white">
																								@forelse($productionRuns as $run)
																												<tr class="hover:bg-gray-50">
																																<td class="whitespace-nowrap px-6 py-4">
																																				<div class="text-sm font-medium text-gray-900">{{ $run->batch_number }}</div>
																																</td>
																																<td class="whitespace-nowrap px-6 py-4">
																																				<div class="text-sm text-gray-900">{{ $run->billOfMaterial->product->name }}</div>
																																				<div class="text-sm text-gray-500">{{ $run->billOfMaterial->product->code }}</div>
																																</td>
																																<td class="whitespace-nowrap px-6 py-4">
																																				<div class="text-sm text-gray-900">{{ $run->billOfMaterial->name }}</div>
																																</td>
																																<td class="whitespace-nowrap px-6 py-4">
																																				<div class="text-sm text-gray-900">
																																								{{ $run->actual_quantity ?? $run->quantity_to_produce }} units
																																				</div>
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
																																				{{ $run->production_date->format("M j, Y") }}
																																</td>
																																<td class="whitespace-nowrap px-6 py-4">
																																				@if ($run->status === "completed")
																																								<span
																																												class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
																																												Completed
																																								</span>
																																				@elseif($run->status === "in_progress")
																																								<span
																																												class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
																																												In Progress
																																								</span>
																																				@else
																																								<span
																																												class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
																																												{{ ucfirst($run->status) }}
																																								</span>
																																				@endif
																																</td>
																																<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
																																				Rs {{ number_format($run->total_production_cost, 2) }}
																																</td>
																												</tr>
																								@empty
																												<tr>
																																<td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
																																				No production runs found.
																																</td>
																												</tr>
																								@endforelse
																				</tbody>
																</table>
												</div>
								</div>

								<!-- Product Breakdown -->
								@if ($productionRuns->count() > 0)
												<div class="rounded-lg bg-white p-6 shadow">
																<h3 class="mb-4 text-lg font-semibold text-gray-900">Product Production Summary</h3>
																<div class="overflow-x-auto">
																				<table class="min-w-full divide-y divide-gray-200">
																								<thead class="bg-gray-50">
																												<tr>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Production Runs
																																</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Produced
																																</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Avg per Run</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Cost</th>
																																<th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Cost per Unit
																																</th>
																												</tr>
																								</thead>
																								<tbody class="divide-y divide-gray-200">
																												@php
																																$productGroups = $productionRuns->groupBy(function ($run) {
																																    return $run->billOfMaterial->product_id;
																																});
																												@endphp
																												@foreach ($productGroups as $productId => $runs)
																																@php
																																				$product = $runs->first()->billOfMaterial->product;
																																				$totalProduced = $runs->sum("actual_quantity");
																																				$totalCost = $runs->sum("total_production_cost");
																																				$avgPerRun = $runs->count() > 0 ? $totalProduced / $runs->count() : 0;
																																				$costPerUnit = $totalProduced > 0 ? $totalCost / $totalProduced : 0;
																																@endphp
																																<tr>
																																				<td class="px-4 py-3">
																																								<div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
																																								<div class="text-sm text-gray-500">{{ $product->code }}</div>
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								{{ $runs->count() }}
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								{{ $totalProduced }} units
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								{{ number_format($avgPerRun, 1) }} units
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								Rs {{ number_format($totalCost, 2) }}
																																				</td>
																																				<td class="px-4 py-3 text-sm text-gray-900">
																																								Rs {{ number_format($costPerUnit, 2) }}
																																				</td>
																																</tr>
																												@endforeach
																								</tbody>
																				</table>
																</div>
												</div>
								@endif
				</div>
@endsection
