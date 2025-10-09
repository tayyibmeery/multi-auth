@extends('layouts.app')

@section('title', $item->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $item->name }}</h1>
            <p class="text-gray-600">Item Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('items.edit', $item) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('items.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Item Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900">{{ $item->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Code</dt>
                    <dd class="text-sm text-gray-900">{{ $item->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                    <dd class="text-sm text-gray-900">{{ $item->category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900">{{ $item->description ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Unit</dt>
                    <dd class="text-sm text-gray-900">{{ $item->unit }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $item->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Stock Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Current Stock</dt>
                    <dd class="text-2xl font-bold {{ $item->current_stock == 0 ? 'text-red-600' : ($item->is_low_stock ? 'text-yellow-600' : 'text-green-600') }}">
                        {{ $item->current_stock }} {{ $item->unit }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Minimum Stock</dt>
                    <dd class="text-sm text-gray-900">{{ $item->min_stock }} {{ $item->unit }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Current Price</dt>
                    <dd class="text-lg font-semibold text-gray-900">₹{{ number_format($item->current_price, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Stock Value</dt>
                    <dd class="text-lg font-semibold text-blue-600">₹{{ number_format($item->stock_value, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm">
                        @if($item->current_stock == 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @elseif($item->is_low_stock)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Low Stock
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                In Stock
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('purchases.create') }}?item_id={{ $item->id }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-shopping-cart mr-2"></i>Purchase This Item
                </a>
                <a href="{{ route('stock-ledgers.item', $item->id ) }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-history mr-2"></i>View Stock History
                </a>
                <a href="{{ route('boms.create') }}?item_id={{ $item->id }}"
                   class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-list-alt mr-2"></i>Use in BOM
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Stock Movements -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Stock Movements</h3>
        @if($item->stockLedgers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity In</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity Out</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock After</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($item->stockLedgers->take(10) as $ledger)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $ledger->date->format('M j, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $ledger->type)) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-green-600">
                                    @if($ledger->quantity_in > 0)
                                        +{{ $ledger->quantity_in }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-red-600">
                                    @if($ledger->quantity_out > 0)
                                        -{{ $ledger->quantity_out }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $ledger->stock_after_transaction }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $ledger->notes }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('stock-ledgers.item', $item->id) }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    View Full Stock History →
                </a>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No stock movements recorded yet.</p>
        @endif
    </div>
</div>
@endsection