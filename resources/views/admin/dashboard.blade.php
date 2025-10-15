@extends("layouts.app")

@section("title", "Admin Dashboard")

@section("content")
<div class="space-y-6">
    <!-- Page Header -->
    <div class="rounded-lg bg-white p-6 shadow">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="text-gray-600">System overview and administration</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">System Status</p>
                <p class="text-lg font-semibold text-green-600">All Systems Operational</p>
            </div>
        </div>
    </div>

    <!-- Admin Stats Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-3">
                    <i class="fas fa-users text-xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_users"] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-3">
                    <i class="fas fa-truck text-xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Vendors</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_vendors"] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-3">
                    <i class="fas fa-layer-group text-xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_categories"] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-orange-100 p-3">
                    <i class="fas fa-clipboard-list text-xl text-orange-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Bills of Materials</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats["total_boms"] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Top Vendors -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Top Vendors</h2>
            @if ($topVendors->count() > 0)
            <div class="space-y-4">
                @foreach ($topVendors as $vendor)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="rounded-lg bg-gray-100 p-2">
                            <i class="fas fa-building text-gray-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $vendor->name }}</p>
                            <p class="text-sm text-gray-600">{{ $vendor->purchases_count }} purchases</p>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Rs
                        {{ number_format($vendor->total_purchases, 2) }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="py-4 text-center text-gray-500">No vendor data available</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route("vendors.create") }}" class="rounded-lg bg-blue-50 p-4 text-center transition hover:bg-blue-100">
                    <i class="fas fa-plus mb-2 text-xl text-blue-600"></i>
                    <p class="text-sm font-medium text-gray-900">Add Vendor</p>
                </a>
                <a href="{{ route("categories.create") }}" class="rounded-lg bg-green-50 p-4 text-center transition hover:bg-green-100">
                    <i class="fas fa-tag mb-2 text-xl text-green-600"></i>
                    <p class="text-sm font-medium text-gray-900">Add Category</p>
                </a>
                <a href="{{ route("items.create") }}" class="rounded-lg bg-purple-50 p-4 text-center transition hover:bg-purple-100">
                    <i class="fas fa-box mb-2 text-xl text-purple-600"></i>
                    <p class="text-sm font-medium text-gray-900">Add Spare Parts </p>

                </a>
                <a href="{{ route("products.create") }}" class="rounded-lg bg-orange-50 p-4 text-center transition hover:bg-orange-100">
                    <i class="fas fa-cube mb-2 text-xl text-orange-600"></i>
                    <p class="text-sm font-medium text-gray-900">Add Product</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Monthly Purchases Chart -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Monthly Purchases ({{ date("Y") }})</h2>
        @if ($monthlyPurchases->count() > 0)
        <div class="space-y-4">
            @foreach ($monthlyPurchases as $purchase)
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-600">
                    {{ DateTime::createFromFormat("!m", $purchase->month)->format("F") }}
                </span>
                <div class="h-2 w-3/4 rounded-full bg-gray-200">
                    <div class="h-2 rounded-full bg-blue-600" style="width: {{ min(($purchase->total / 10000) * 100, 100) }}%"></div>
                </div>
                <span class="text-sm font-medium text-gray-900">Rs
                    {{ number_format($purchase->total, 2) }}</span>
            </div>
            @endforeach
        </div>
        @else
        <p class="py-4 text-center text-gray-500">No purchase data available for this year</p>
        @endif
    </div>
</div>
@endsection
