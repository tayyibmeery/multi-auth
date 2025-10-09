@extends('layouts.app')

@section('title', $productionRun->batch_number)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Production Run: {{ $productionRun->batch_number }}</h1>
            <p class="text-gray-600">Production Batch Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('production-runs.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Production
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Production Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Production Information</h3>
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
                    <dd class="text-sm font-semibold {{ $productionRun->actual_quantity ? 'text-green-600' : 'text-gray-600' }}">
                        {{ $productionRun->actual_quantity ?? 'Not recorded' }} units
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Production Date</dt>
                    <dd class="text-sm text-gray-900">{{ $productionRun->production_date->format('M j, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Completion Date</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $productionRun->completion_date ? $productionRun->completion_date->format('M j, Y') : 'Not completed' }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Status & Cost -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Cost</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm">
                        @if($productionRun->status === 'completed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        @elseif($productionRun->status === 'in_progress')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                In Progress
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($productionRun->status) }}
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Material Cost</dt>
                    <dd class="text-lg font-semibold text-blue-600">
                        ₹{{ number_format($productionRun->total_production_cost, 2) }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Cost Per Unit</dt>
                    <dd class="text-sm text-gray-900">
                        @if($productionRun->actual_quantity)
                            ₹{{ number_format($productionRun->total_production_cost / $productionRun->actual_quantity, 2) }}
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
                    <dd class="text-sm text-gray-900">{{ $productionRun->created_at->format('M j, Y g:i A') }}</dd>
                </div>
            </dl>

            @if($productionRun->notes)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $productionRun->notes }}</dd>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('boms.show', $productionRun->billOfMaterial) }}"
                   class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-list-alt mr-2"></i>View BOM Details
                </a>
                <a href="{{ route('products.show', $productionRun->billOfMaterial->product) }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-cube mr-2"></i>View Product
                </a>
                <a href="{{ route('stock-ledgers.index') }}?reference_id={{ $productionRun->id }}&reference_type=production_run"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-history mr-2"></i>View Stock Impact
                </a>
            </div>
        </div>
    </div>

    <!-- Materials Used -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Materials Used</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Material</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity Used</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Cost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Cost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Before</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock After</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $usageLedgers = $productionRun->stockLedgers->where('type', 'production_usage');
                    @endphp
                    @foreach($usageLedgers as $ledger)
                        @php
                            $stockBefore = $ledger->stock_after_transaction + $ledger->quantity_out;
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $ledger->item->name }}</div>
                                <div class="text-sm text-gray-500">{{ $ledger->item->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-red-600 font-semibold">
                                -{{ $ledger->quantity_out }} {{ $ledger->item->unit }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ₹{{ number_format($ledger->unit_cost, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                ₹{{ number_format($ledger->total_cost, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $stockBefore }} {{ $ledger->item->unit }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $ledger->stock_after_transaction }} {{ $ledger->item->unit }}
                            </td>
                        </tr>
                    @endforeach
                    @if($usageLedgers->count() == 0)
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">
                                No material usage recorded.
                            </td>
                        </tr>
                    @endif
                </tbody>
                @if($usageLedgers->count() > 0)
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Total Material Cost:</td>
                            <td class="px-4 py-3 text-sm font-bold text-blue-600">
                                ₹{{ number_format($usageLedgers->sum('total_cost'), 2) }}
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Products Produced -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Products Produced</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity Produced</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Cost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Before</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock After</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $outputLedgers = $productionRun->stockLedgers->where('type', 'production_output');
                    @endphp
                    @foreach($outputLedgers as $ledger)
                        @php
                            $stockBefore = $ledger->stock_after_transaction - $ledger->quantity_in;
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $ledger->product->name }}</div>
                                <div class="text-sm text-gray-500">{{ $ledger->product->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-green-600 font-semibold">
                                +{{ $ledger->quantity_in }} units
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ₹{{ number_format($ledger->unit_cost, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                ₹{{ number_format($ledger->total_cost, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $stockBefore }} units
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $ledger->stock_after_transaction }} units
                            </td>
                        </tr>
                    @endforeach
                    @if($outputLedgers->count() == 0)
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