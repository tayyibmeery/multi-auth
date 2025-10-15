@extends("layouts.app")

@section("title", "Dashboard")

@section("content")
<div class="space-y-6">
    <!-- Page Header -->
    <div class="rounded-lg bg-white p-6 shadow">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Today is</p>
                <p class="text-lg font-semibold">{{ now()->format("l, F j, Y") }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-3">
                    <i class="fas fa-boxes text-xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Spare Parts</p>

                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_items"] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-3">
                    <i class="fas fa-cube text-xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_products"] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-3">
                    <i class="fas fa-shopping-cart text-xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Purchases</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_purchases"] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-orange-100 p-3">
                    <i class="fas fa-industry text-xl text-orange-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Production Runs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_production_runs"] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Value -->
    <div class="rounded-lg bg-white p-6 shadow">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Stock Valuation</h2>
            <span class="text-2xl font-bold text-green-600">Rs {{ number_format($totalStockValue, 2) }}</span>
        </div>
        <p class="text-sm text-gray-600">Total value of all Spare Parts and products in stock</p>

    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Low Stock Items -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Low Stock Spare Parts </h2>

            @if ($lowStockItems->count() > 0)
            <div class="space-y-3">
                @foreach ($lowStockItems as $item)
                <div class="flex items-center justify-between rounded-lg bg-red-50 p-3">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->name }}</p>
                        <p class="text-sm text-gray-600">Stock: {{ $item->current_stock }} {{ $item->unit }}
                        </p>
                    </div>
                    <span class="rounded bg-red-100 px-2 py-1 text-xs font-medium text-red-800">Low Stock</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="py-4 text-center text-gray-500">All Spare Parts are sufficiently stocked</p>

            @endif
            <div class="mt-4">
                <a href="{{ route("items.low-stock") }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View all low stock Spare Parts →

                </a>
            </div>
        </div>

        <!-- Recent Purchases -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Recent Purchases</h2>
            @if ($recentPurchases->count() > 0)
            <div class="space-y-3">
                @foreach ($recentPurchases as $purchase)
                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3">
                    <div>
                        <p class="font-medium text-gray-900">{{ $purchase->purchase_number }}</p>
                        <p class="text-sm text-gray-600">{{ $purchase->vendor->name }} • Rs
                            {{ number_format($purchase->total_amount, 2) }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ $purchase->purchase_date->format("M j") }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="py-4 text-center text-gray-500">No recent purchases</p>
            @endif
            <div class="mt-4">
                <a href="{{ route("purchases.index") }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View all purchases →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Production -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Recent Production Runs</h2>
        @if ($recentProductions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Batch No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($recentProductions as $production)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $production->batch_number }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            {{ $production->billOfMaterial->product->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            {{ $production->actual_quantity ?? $production->quantity_to_produce }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($production->status === "completed")
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                Completed
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
                                {{ ucfirst($production->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ $production->production_date->format("M j, Y") }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="py-4 text-center text-gray-500">No recent production runs</p>
        @endif
        <div class="mt-4">
            <a href="{{ route("production-runs.index") }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                View all production runs →
            </a>
        </div>
    </div>
</div>
@endsection
