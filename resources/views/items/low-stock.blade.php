@extends('layouts.app')

@section('title', 'Low Stock Items')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Low Stock Items</h1>
            <p class="text-gray-600">Items that need to be reordered</p>
        </div>
        <a href="{{ route('items.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Items
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Current Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Minimum Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Required</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-red-800 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $item)
                        <tr class="hover:bg-red-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->category->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-red-600">{{ $item->current_stock }} {{ $item->unit }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->min_stock }} {{ $item->unit }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-red-600">
                                    {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($item->current_price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('purchases.create') }}?item_id={{ $item->id }}"
                                   class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-shopping-cart"></i> Purchase
                                </a>
                                <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('items.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                                    <p class="text-lg font-medium text-gray-900">All items are sufficiently stocked!</p>
                                    <p class="text-gray-600">No low stock items found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection