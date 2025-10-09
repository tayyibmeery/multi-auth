@extends('layouts.app')

@section('title', 'Stock Valuation Report')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stock Valuation Report</h1>
            <p class="text-gray-600">Complete inventory valuation and cost analysis</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('reports.stock') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-boxes mr-2"></i>Stock Report
            </a>
            <a href="{{ route('reports.low-stock') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Report
            </a>
        </div>
    </div>

    <!-- Total Valuation Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-boxes text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Items Stock Value</p>
                    <p class="text-2xl font-bold text-blue-600">₹{{ number_format($totalItemValue, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-cube text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Products Stock Value</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalProductValue, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-calculator text-purple-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Inventory Value</p>
                    <p class="text-2xl font-bold text-purple-600">₹{{ number_format($totalItemValue + $totalProductValue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Valuation -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Items Valuation (Raw Materials)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">% of Total</th>
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
                                ₹{{ number_format($item->current_price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                ₹{{ number_format($item->total_value, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $totalItemValue > 0 ? number_format(($item->total_value / $totalItemValue) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Total Items Value:</td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">
                            ₹{{ number_format($totalItemValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Products Valuation -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Products Valuation (Finished Goods)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selling Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">% of Total</th>
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
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                ₹{{ number_format($product->total_value, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $totalProductValue > 0 ? number_format(($product->total_value / $totalProductValue) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Total Products Value:</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">
                            ₹{{ number_format($totalProductValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Valuation Summary -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Valuation Summary</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Items vs Products -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-3">Inventory Distribution</h3>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Raw Materials (Items)</span>
                            <span class="font-medium">₹{{ number_format($totalItemValue, 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full"
                                 style="width: {{ $totalItemValue + $totalProductValue > 0 ? ($totalItemValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Finished Goods (Products)</span>
                            <span class="font-medium">₹{{ number_format($totalProductValue, 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full"
                                 style="width: {{ $totalItemValue + $totalProductValue > 0 ? ($totalProductValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top 5 Most Valuable -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-3">Top 5 Most Valuable Items</h3>
                <div class="space-y-2">
                    @foreach($items->sortByDesc('total_value')->take(5) as $item)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">{{ $item->name }}</span>
                            <span class="font-medium text-blue-600">₹{{ number_format($item->total_value, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection