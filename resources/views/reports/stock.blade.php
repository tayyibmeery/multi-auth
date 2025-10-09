@extends('layouts.app')

@section('title', 'Stock Report')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stock Report</h1>
            <p class="text-gray-600">Current inventory levels and valuations</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('reports.stock-valuation') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-calculator mr-2"></i>Stock Valuation
            </a>
            <a href="{{ route('reports.low-stock') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Report
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-boxes text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Items</p>
                    <p class="text-lg font-semibold">{{ $items->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-cube text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-lg font-semibold">{{ $products->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
                    <p class="text-lg font-semibold">{{ $items->where('is_low_stock', true)->count() }}</p>
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
                    <p class="text-lg font-semibold">{{ $items->where('current_stock', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Stock -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Items Stock</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($items as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                <div class="text-sm text-gray-500">{{ $item->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $item->category->name }}
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Products Stock -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Products Stock</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selling Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">BOM Count</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ $product->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $product->current_stock }} units
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ₹{{ number_format($product->selling_price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ₹{{ number_format($product->stock_value, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $product->billOfMaterials->count() }}
                            </td>
                            <td class="px-4 py-3">
                                @if($product->current_stock == 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection