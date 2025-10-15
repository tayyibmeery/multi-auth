@extends("layouts.app")

@section("title", $bom->name)

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $bom->name }}</h1>
            <p class="text-gray-600">Bill of Material Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route("production-runs.create") }}?bom_id={{ $bom->id }}" class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                <i class="fas fa-play mr-2"></i>Start Production
            </a>
            <a href="{{ route("boms.edit", $bom) }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit BOM
            </a>
            <a href="{{ route("boms.index") }}" class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!--  Bill of Materials Information -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">BOM Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Product</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->product->name }} ({{ $bom->product->code }})</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->description ?? "N/A" }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Estimated Cost</dt>
                    <dd class="text-lg font-semibold text-blue-600">Rs
                        {{ number_format($bom->total_estimated_cost, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Spare Parts Count</dt>

                    <dd class="text-sm text-gray-900">{{ $bom->bomItems->count() }} Spare Parts </dd>

                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm">
                        @if ($bom->is_active)
                        <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                            Active
                        </span>
                        @else
                        <span class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
                            Inactive
                        </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->created_at->format("M j, Y") }}</dd>
                </div>
            </dl>
        </div>

        <!-- Production Information -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Production Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Production Runs</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->productionRuns->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Quantity Produced</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $bom->productionRuns->sum("actual_quantity") }} units
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Production</dt>
                    <dd class="text-sm text-gray-900">
                        @if ($bom->productionRuns->count() > 0)
                        {{ $bom->productionRuns->last()->production_date->format("M j, Y") }}
                        @else
                        Never
                        @endif
                    </dd>
                </div>
            </dl>

            <!-- Quick Production -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <a href="{{ route("production-runs.create") }}?bom_id={{ $bom->id }}" class="block w-full rounded-lg bg-green-600 px-4 py-2 text-center text-white hover:bg-green-700">
                    <i class="fas fa-industry mr-2"></i>Start New Production Run
                </a>
            </div>
        </div>

        <!-- Cost Analysis -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Cost Analysis</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Material Cost</dt>
                    <dd class="text-sm text-gray-900">Rs {{ number_format($bom->total_estimated_cost, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Product Price</dt>
                    <dd class="text-sm text-gray-900">Rs {{ number_format($bom->product->selling_price, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Gross Margin</dt>
                    <dd class="{{ $bom->product->selling_price - $bom->total_estimated_cost >= 0 ? "text-green-600" : "text-red-600" }} text-sm font-semibold">
                        Rs {{ number_format($bom->product->selling_price - $bom->total_estimated_cost, 2) }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Margin Percentage</dt>
                    <dd class="{{ $bom->product->selling_price - $bom->total_estimated_cost >= 0 ? "text-green-600" : "text-red-600" }} text-sm font-semibold">
                        @if ($bom->product->selling_price > 0)
                        {{ number_format((($bom->product->selling_price - $bom->total_estimated_cost) / $bom->product->selling_price) * 100, 1) }}%
                        @else
                        N/A
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!--  Bill of Materials Spare Parts  -->

    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">BOM Spare Parts </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Spare Parts </th>

                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Required Quantity
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Cost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($bom->bomItems as $bomItem)
                    @php
                    $item = $bomItem->item;
                    $requiredStock = $bomItem->quantity;
                    $hasEnoughStock = $item->current_stock >= $requiredStock;
                    @endphp
                    <tr>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                            <div class="text-sm text-gray-500">{{ $item->code }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $item->current_stock }} {{ $item->unit }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $bomItem->quantity }} {{ $item->unit }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                            Rs {{ number_format($bomItem->quantity * $item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($hasEnoughStock)
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                Sufficient
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                Short: {{ $requiredStock - $item->current_stock }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total Material
                            Cost:</td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">
                            Rs {{ number_format($bom->total_estimated_cost, 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Recent Production Runs -->
    @if ($bom->productionRuns->count() > 0)
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Recent Production Runs</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Batch No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($bom->productionRuns->take(5) as $run)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $run->batch_number }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $run->production_date->format("M j, Y") }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $run->actual_quantity ?? $run->quantity_to_produce }} units
                        </td>
                        <td class="px-4 py-3">
                            @if ($run->status === "completed")
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                Completed
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
                                {{ ucfirst($run->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            <a href="{{ route("production-runs.show", $run) }}" class="text-blue-600 hover:text-blue-900">
                                View Details
                            </a>
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
