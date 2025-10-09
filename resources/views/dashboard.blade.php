@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Today is</p>
                <p class="text-lg font-semibold">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-boxes text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Items</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_items'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-cube text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Purchases</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_purchases'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-industry text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Production Runs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_production_runs'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Value -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Stock Valuation</h2>
            <span class="text-2xl font-bold text-green-600">₹{{ number_format($totalStockValue, 2) }}</span>
        </div>
        <p class="text-sm text-gray-600">Total value of all items and products in stock</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Low Stock Items -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Low Stock Items</h2>
            @if($lowStockItems->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockItems as $item)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->name }}</p>
                                <p class="text-sm text-gray-600">Stock: {{ $item->current_stock }} {{ $item->unit }}</p>
                            </div>
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">Low Stock</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">All items are sufficiently stocked</p>
            @endif
            <div class="mt-4">
                <a href="{{ route('items.low-stock') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    View all low stock items →
                </a>
            </div>
        </div>

        <!-- Recent Purchases -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Purchases</h2>
            @if($recentPurchases->count() > 0)
                <div class="space-y-3">
                    @foreach($recentPurchases as $purchase)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $purchase->purchase_number }}</p>
                                <p class="text-sm text-gray-600">{{ $purchase->vendor->name }} • ₹{{ number_format($purchase->total_amount, 2) }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $purchase->purchase_date->format('M j') }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No recent purchases</p>
            @endif
            <div class="mt-4">
                <a href="{{ route('purchases.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    View all purchases →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Production -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Production Runs</h2>
        @if($recentProductions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentProductions as $production)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $production->batch_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $production->billOfMaterial->product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $production->actual_quantity ?? $production->quantity_to_produce }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($production->status === 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($production->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $production->production_date->format('M j, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No recent production runs</p>
        @endif
        <div class="mt-4">
            <a href="{{ route('production-runs.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                View all production runs →
            </a>
        </div>
    </div>
</div>
@endsection