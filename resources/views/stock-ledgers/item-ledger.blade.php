@extends('layouts.app')

@section('title', $item->name . ' - Stock Ledger')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $item->name }} - Stock Ledger</h1>
            <p class="text-gray-600">Complete stock history for {{ $item->code }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('items.show', $item) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Item
            </a>
            <a href="{{ route('stock-ledgers.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-list mr-2"></i>All Ledgers
            </a>
        </div>
    </div>

    <!-- Item Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-box text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Current Stock</p>
                    <p class="text-lg font-semibold">{{ $item->current_stock }} {{ $item->unit }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Current Price</p>
                    <p class="text-lg font-semibold">₹{{ number_format($item->current_price, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-calculator text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Stock Value</p>
                    <p class="text-lg font-semibold">₹{{ number_format($item->stock_value, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Minimum Stock</p>
                    <p class="text-lg font-semibold">{{ $item->min_stock }} {{ $item->unit }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Ledger Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock After</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ledgers as $ledger)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $ledger->date->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $ledger->type == 'purchase' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $ledger->type == 'production_output' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $ledger->type == 'production_usage' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $ledger->type == 'adjustment' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $ledger->type == 'sale' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ledger->type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $ledger->reference_type }} #{{ $ledger->reference_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                @if($ledger->quantity_in > 0)
                                    +{{ $ledger->quantity_in }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                                @if($ledger->quantity_out > 0)
                                    -{{ $ledger->quantity_out }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($ledger->unit_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($ledger->total_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $ledger->stock_after_transaction }} {{ $item->unit }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $ledger->notes }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                                No stock movements recorded for this item.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ledgers->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $ledgers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection