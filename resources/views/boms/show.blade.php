@extends('layouts.app')

@section('title', $bom->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $bom->name }}</h1>
            <p class="text-gray-600">Bill of Material Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('production-runs.create') }}?bom_id={{ $bom->id }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-play mr-2"></i>Start Production
            </a>
            <a href="{{ route('boms.edit', $bom) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>Edit BOM
            </a>
            <a href="{{ route('boms.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- BOM Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">BOM Information</h3>
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
                    <dd class="text-sm text-gray-900">{{ $bom->description ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Estimated Cost</dt>
                    <dd class="text-lg font-semibold text-blue-600">₹{{ number_format($bom->total_estimated_cost, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Items Count</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->bomItems->count() }} items</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm">
                        @if($bom->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Production Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Production Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Production Runs</dt>
                    <dd class="text-sm text-gray-900">{{ $bom->productionRuns->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Quantity Produced</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $bom->productionRuns->sum('actual_quantity') }} units
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Production</dt>
                    <dd class="text-sm text-gray-900">
                        @if($bom->productionRuns->count() > 0)
                            {{ $bom->productionRuns->last()->production_date->format('M j, Y') }}
                        @else
                            Never
                        @endif
                    </dd>
                </div>
            </dl>

            <!-- Quick Production -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('production-runs.create') }}?bom_id={{ $bom->id }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-industry mr-2"></i>Start New Production Run
                </a>
            </div>
        </div>

        <!-- Cost Analysis -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Cost Analysis</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Material Cost</dt>
                    <dd class="text-sm text-gray-900">₹{{ number_format($bom->total_estimated_cost, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Product Price</dt>
                    <dd class="text-sm text-gray-900">₹{{ number_format($bom->product->selling_price, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Gross Margin</dt>
                    <dd class="text-sm font-semibold {{ ($bom->product->selling_price - $bom->total_estimated_cost) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ₹{{ number_format($bom->product->selling_price - $bom->total_estimated_cost, 2) }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Margin Percentage</dt>
                    <dd class="text-sm font-semibold {{ ($bom->product->selling_price - $bom->total_estimated_cost) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        @if($bom->product->selling_price > 0)
                            {{ number_format((($bom->product->selling_price - $bom->total_estimated_cost) / $bom->product->selling_price) * 100, 1) }}%
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- BOM Items -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">BOM Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Required Quantity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Cost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bom->bomItems as $bomItem)
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
                                ₹{{ number_format($item->current_price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                ₹{{ number_format($bomItem->quantity * $item->current_price, 2) }}
                            </td>
                            <td class="px-4 py-3">
                                @if($hasEnoughStock)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sufficient
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Short: {{ $requiredStock - $item->current_stock }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Total Material Cost:</td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">
                            ₹{{ number_format($bom->total_estimated_cost, 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Recent Production Runs -->
    @if($bom->productionRuns->count() > 0)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Production Runs</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($bom->productionRuns->take(5) as $run)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $run->batch_number }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $run->production_date->format('M j, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $run->actual_quantity ?? $run->quantity_to_produce }} units
                                </td>
                                <td class="px-4 py-3">
                                    @if($run->status === 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($run->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-medium">
                                    <a href="{{ route('production-runs.show', $run) }}" class="text-blue-600 hover:text-blue-900">
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
