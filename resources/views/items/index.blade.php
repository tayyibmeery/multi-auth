@extends('layouts.app')

@section('title', 'Items Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Items Management</h1>
            <p class="text-gray-600">Manage your inventory items and components</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('items.low-stock') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-exclamation-triangle mr-2"></i>Low Stock
            </a>
            <a href="{{ route('items.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-plus mr-2"></i>Add New Item
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-boxes text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Items</p>
                    <p class="text-lg font-semibold">{{ $items->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">In Stock</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Item::where('current_stock', '>', 0)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Low Stock</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Item::whereRaw('current_stock <= min_stock')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <i class="fas fa-times-circle text-gray-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Item::where('current_stock', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
            <div class="flex-1 max-w-md">
                <input type="text" placeholder="Search items..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex space-x-3">
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Categories</option>
                    <!-- Categories will be populated dynamically -->
                </select>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Stock Status</option>
                    <option value="in_stock">In Stock</option>
                    <option value="low_stock">Low Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-blue-600"></i>
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
                                <div class="text-sm text-gray-900">{{ $item->current_stock }} {{ $item->unit }}</div>
                                <div class="text-xs text-gray-500">Min: {{ $item->min_stock }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($item->current_price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($item->stock_value, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('items.edit', $item) }}" class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No items found. <a href="{{ route('items.create') }}" class="text-blue-600 hover:text-blue-500">Create the first item</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection