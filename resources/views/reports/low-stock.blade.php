@extends('layouts.app')

@section('title', 'Low Stock Report')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Low Stock Report</h1>
            <p class="text-gray-600">Items that need immediate attention and reordering</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('reports.stock') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-boxes mr-2"></i>Stock Report
            </a>
            <a href="{{ route('reports.stock-valuation') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-calculator mr-2"></i>Stock Valuation
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Critical Items</p>
                    <p class="text-lg font-semibold">{{ $items->where('current_stock', 0)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
                    <p class="text-lg font-semibold">{{ $items->where('current_stock', '>', 0)->where('is_low_stock', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total to Order</p>
                    <p class="text-lg font-semibold">{{ $items->sum(function($item) { return max(0, $item->min_stock - $item->current_stock); }) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Estimated Cost</p>
                    <p class="text-lg font-semibold">
                        ₹{{ number_format($items->sum(function($item) {
                            return max(0, $item->min_stock - $item->current_stock) * $item->current_price;
                        }), 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($items->count() > 0)
        <!-- Critical Items (Out of Stock) -->
        @php
            $criticalItems = $items->where('current_stock', 0);
        @endphp

        @if($criticalItems->count() > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-red-800">Critical Alert - Out of Stock Items</h3>
                        <p class="text-red-700">These items are completely out of stock and need immediate attention.</p>
                    </div>
                    <span class="ml-auto bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">
                        {{ $criticalItems->count() }} items
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-red-200">
                        <thead class="bg-red-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-red-800 uppercase">Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-red-800 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-red-800 uppercase">Required</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-red-800 uppercase">Unit Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-red-800 uppercase">Total Cost</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-red-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-200">
                            @foreach($criticalItems as $item)
                                <tr class="hover:bg-red-100">
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->code }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $item->category->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-red-600">
                                        {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        ₹{{ number_format($item->current_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-red-600">
                                        ₹{{ number_format(max(0, $item->min_stock - $item->current_stock) * $item->current_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <a href="{{ route('purchases.create') }}?item_id={{ $item->id }}"
                                           class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-shopping-cart mr-1"></i>Purchase
                                        </a>
                                        <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Low Stock Items -->
        @php
            $lowStockItems = $items->where('current_stock', '>', 0)->where('is_low_stock', true);
        @endphp

        @if($lowStockItems->count() > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-yellow-800">Low Stock Warning</h3>
                        <p class="text-yellow-700">These items are below minimum stock levels and should be reordered soon.</p>
                    </div>
                    <span class="ml-auto bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">
                        {{ $lowStockItems->count() }} items
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-yellow-200">
                        <thead class="bg-yellow-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Current Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Min Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Required</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Unit Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Total Cost</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-yellow-200">
                            @foreach($lowStockItems as $item)
                                <tr class="hover:bg-yellow-100">
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->code }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $item->category->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-yellow-600 font-semibold">
                                        {{ $item->current_stock }} {{ $item->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $item->min_stock }} {{ $item->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-yellow-600">
                                        {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        ₹{{ number_format($item->current_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-yellow-600">
                                        ₹{{ number_format(max(0, $item->min_stock - $item->current_stock) * $item->current_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <a href="{{ route('purchases.create') }}?item_id={{ $item->id }}"
                                           class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-shopping-cart mr-1"></i>Purchase
                                        </a>
                                        <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Quick Purchase Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Purchase Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Create Bulk Purchase</h4>
                    <p class="text-sm text-gray-600 mb-3">Create a purchase order for all low stock items</p>
                    <a href="{{ route('purchases.create') }}?low_stock=true"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                        <i class="fas fa-cart-plus mr-2"></i>Create Bulk Purchase
                    </a>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Export Report</h4>
                    <p class="text-sm text-gray-600 mb-3">Download this report for procurement team</p>
                    <button onclick="window.print()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                        <i class="fas fa-print mr-2"></i>Print Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Category-wise Breakdown -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Low Stock by Category</h3>
            @php
                $categoryGroups = $items->groupBy('category_id');
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($categoryGroups as $categoryId => $categoryItems)
                    @php
                        $category = $categoryItems->first()->category;
                        $criticalCount = $categoryItems->where('current_stock', 0)->count();
                        $lowCount = $categoryItems->where('current_stock', '>', 0)->where('is_low_stock', true)->count();
                    @endphp
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-sm font-medium text-gray-900">{{ $category->name }}</h4>
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                {{ $criticalCount + $lowCount }} items
                            </span>
                        </div>
                        <div class="space-y-1 text-xs text-gray-600">
                            <div class="flex justify-between">
                                <span>Critical:</span>
                                <span class="font-medium text-red-600">{{ $criticalCount }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Low Stock:</span>
                                <span class="font-medium text-yellow-600">{{ $lowCount }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Required:</span>
                                <span class="font-medium">
                                    {{ $categoryItems->sum(function($item) { return max(0, $item->min_stock - $item->current_stock); }) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('items.index') }}?category_id={{ $category->id }}&stock_status=low_stock"
                               class="text-blue-600 hover:text-blue-500 text-xs font-medium">
                                View Items →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @else
        <!-- No Low Stock Items -->
        <div class="bg-white shadow rounded-lg p-8 text-center">
            <div class="flex flex-col items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">All Items Are Sufficiently Stocked!</h3>
                <p class="text-gray-600 mb-6">Great job! No items are currently below minimum stock levels.</p>
                <div class="flex space-x-3">
                    <a href="{{ route('reports.stock') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                        View Stock Report
                    </a>
                    <a href="{{ route('items.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                        Manage Items
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
@media print {
    nav, .flex.justify-between.items-center > div:last-child,
    .bg-white.shadow.rounded-lg.p-6:last-child {
        display: none !important;
    }

    .bg-red-50, .bg-yellow-50 {
        border: 2px solid #000 !important;
    }
}
</style>
@endsection