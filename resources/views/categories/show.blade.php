@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
            <p class="text-gray-600">Category Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('categories.edit', $category) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900">{{ $category->description ?? 'No description provided' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Items Count</dt>
                    <dd class="text-sm text-gray-900">{{ $category->items_count }} items</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $category->created_at->format('M j, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="text-sm text-gray-900">{{ $category->updated_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('items.create') }}?category_id={{ $category->id }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-plus mr-2"></i>Add Item to this Category
                </a>
                <a href="{{ route('items.index') }}?category_id={{ $category->id }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-list mr-2"></i>View All Items ({{ $category->items_count }})
                </a>
            </div>

            <!-- Category Statistics -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Category Statistics</h4>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Items</span>
                        <span class="font-medium text-blue-600">{{ $category->items_count }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">In Stock Items</span>
                        <span class="font-medium text-green-600">
                            {{ $category->items->where('current_stock', '>', 0)->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Low Stock Items</span>
                        <span class="font-medium text-yellow-600">
                            {{ $category->items->where('current_stock', '<=', \DB::raw('min_stock'))->where('current_stock', '>', 0)->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Out of Stock</span>
                        <span class="font-medium text-red-600">
                            {{ $category->items->where('current_stock', 0)->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Summary -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Summary</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Total Stock Value</span>
                        <span class="text-sm font-semibold text-blue-600">
                            ₹{{ number_format($category->items->sum('stock_value'), 2) }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Average Item Price</span>
                        <span class="text-sm font-semibold text-green-600">
                            @if($category->items_count > 0)
                                ₹{{ number_format($category->items->avg('current_price'), 2) }}
                            @else
                                ₹0.00
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Stock Health</span>
                        <span class="text-sm font-semibold
                            @if($category->items->where('current_stock', 0)->count() > 0) text-red-600
                            @elseif($category->items->where('current_stock', '<=', \DB::raw('min_stock'))->count() > 0) text-yellow-600
                            @else text-green-600 @endif">
                            @if($category->items->where('current_stock', 0)->count() > 0)
                                Needs Attention
                            @elseif($category->items->where('current_stock', '<=', \DB::raw('min_stock'))->count() > 0)
                                Low Stock
                            @else
                                Healthy
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full
                            @if($category->items->where('current_stock', 0)->count() > 0) bg-red-600
                            @elseif($category->items->where('current_stock', '<=', \DB::raw('min_stock'))->count() > 0) bg-yellow-600
                            @else bg-green-600 @endif"
                            style="width:
                            @if($category->items->where('current_stock', 0)->count() > 0) 40%
                            @elseif($category->items->where('current_stock', '<=', \DB::raw('min_stock'))->count() > 0) 70%
                            @else 100% @endif">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items in this Category -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Items in this Category ({{ $category->items_count }})</h3>
            <a href="{{ route('items.create') }}?category_id={{ $category->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">
                <i class="fas fa-plus mr-1"></i> Add Item
            </a>
        </div>

        @if($category->items_count > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Value</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($category->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $item->code }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $item->current_stock }} {{ $item->unit }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $item->min_stock }} {{ $item->unit }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    ₹{{ number_format($item->current_price, 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    ₹{{ number_format($item->stock_value, 2) }}
                                </td>
                                <td class="px-4 py-3">
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
                                <td class="px-4 py-3 text-sm font-medium">
                                    <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        View
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}" class="text-green-600 hover:text-green-900">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-boxes text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">No items in this category yet</p>
                <p class="text-gray-400 text-sm mb-4">Start by adding items to this category</p>
                <a href="{{ route('items.create') }}?category_id={{ $category->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add First Item
                </a>
            </div>
        @endif
    </div>

    <!-- Low Stock Items -->
    @php
        $lowStockItems = $category->items->filter(function($item) {
            return $item->is_low_stock || $item->current_stock == 0;
        });
    @endphp

    @if($lowStockItems->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-yellow-800">Low Stock Alert</h3>
                <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">
                    {{ $lowStockItems->count() }} items need attention
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($lowStockItems->take(6) as $item)
                    <div class="bg-white border border-yellow-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $item->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $item->code }}</p>
                            </div>
                            @if($item->current_stock == 0)
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Out of Stock</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Low Stock</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-600">
                            <p>Current: {{ $item->current_stock }} {{ $item->unit }}</p>
                            <p>Minimum: {{ $item->min_stock }} {{ $item->unit }}</p>
                            <p>Need: {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}</p>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('purchases.create') }}?item_id={{ $item->id }}" class="text-blue-600 hover:text-blue-500 text-xs font-medium">
                                Purchase Now →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection