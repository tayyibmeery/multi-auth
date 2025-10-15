@extends("layouts.app")

@section("title", "Low Stock Report")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Low Stock Report</h1>
            <p class="text-gray-600">Spare Parts that need immediate attention and reordering</p>

        </div>
        <div class="flex space-x-3">
            <a href="{{ route("reports.stock") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-boxes mr-2"></i>Stock Report
            </a>
            <a href="{{ route("reports.stock-valuation") }}" class="rounded-lg bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700">
                <i class="fas fa-calculator mr-2"></i>Stock Valuation
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-red-100 p-2">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Critical Spare Parts </p>

                    <p class="text-lg font-semibold">{{ $items->where("current_stock", 0)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-yellow-100 p-2">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Low Stock Spare Parts </p>

                    <p class="text-lg font-semibold">
                        {{ $items->where("current_stock", ">", 0)->where("is_low_stock", true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-orange-100 p-2">
                    <i class="fas fa-shopping-cart text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total to Order</p>
                    <p class="text-lg font-semibold">
                        {{ $items->sum(function ($item) {return max(0, $item->min_stock - $item->current_stock);}) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-2">
                    <i class="fas fa-money-bill-wave text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Estimated Cost</p>
                    <p class="text-lg font-semibold">
                        Rs
                        {{ number_format(
																												    $items->sum(function ($item) {
																												        return max(0, $item->min_stock - $item->current_stock) * $item->current_price;
																												    }),
																												    2,
																												) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if ($items->count() > 0)
    <!-- Critical Items (Out of Stock) -->
    @php
    $criticalItems = $items->where("current_stock", 0);
    @endphp

    @if ($criticalItems->count() > 0)
    <div class="rounded-lg border border-red-200 bg-red-50 p-6">
        <div class="mb-4 flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-xl text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-red-800">Critical Alert - Out of Stock Spare Parts </h3>

                <p class="text-red-700">These Spare Parts are completely out of stock and need immediate attention.

                </p>
            </div>
            <span class="ml-auto rounded-full bg-red-100 px-3 py-1 text-sm text-red-800">
                {{ $criticalItems->count() }} Spare Part

            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-red-200">
                <thead class="bg-red-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-red-800">Spare Part</th>

                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-red-800">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-red-800">Required</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-red-800">Unit Price
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-red-800">Total Cost
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-red-800">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-200">
                    @foreach ($criticalItems as $item)
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
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-red-600">
                            Rs
                            {{ number_format(max(0, $item->min_stock - $item->current_stock) * $item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            <a href="{{ route("purchases.create") }}?item_id={{ $item->id }}" class="mr-3 text-green-600 hover:text-green-900">
                                <i class="fas fa-shopping-cart mr-1"></i>Purchase
                            </a>
                            <a href="{{ route("items.show", $item) }}" class="text-blue-600 hover:text-blue-900">
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
    $lowStockItems = $items->where("current_stock", ">", 0)->where("is_low_stock", true);
    @endphp

    @if ($lowStockItems->count() > 0)
    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-6">
        <div class="mb-4 flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-xl text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-yellow-800">Low Stock Warning</h3>
                <p class="text-yellow-700">These Spare Parts are below minimum stock levels and should be reordered

                    soon.</p>
            </div>
            <span class="ml-auto rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-800">
                {{ $lowStockItems->count() }} Spare Parts
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-yellow-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Spare Part</th>

                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Category
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Current
                            Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Min Stock
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Required
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Unit Price
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Total Cost
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-yellow-800">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yellow-200">
                    @foreach ($lowStockItems as $item)
                    <tr class="hover:bg-yellow-100">
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                            <div class="text-sm text-gray-500">{{ $item->code }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $item->category->name }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-yellow-600">
                            {{ $item->current_stock }} {{ $item->unit }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $item->min_stock }} {{ $item->unit }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-yellow-600">
                            {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-yellow-600">
                            Rs
                            {{ number_format(max(0, $item->min_stock - $item->current_stock) * $item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            <a href="{{ route("purchases.create") }}?item_id={{ $item->id }}" class="mr-3 text-green-600 hover:text-green-900">
                                <i class="fas fa-shopping-cart mr-1"></i>Purchase
                            </a>
                            <a href="{{ route("items.show", $item) }}" class="text-blue-600 hover:text-blue-900">
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
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Purchase Actions</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-lg border border-gray-200 p-4">
                <h4 class="mb-2 text-sm font-medium text-gray-900">Create Bulk Purchase</h4>
                <p class="mb-3 text-sm text-gray-600">Create a purchase order for all low stock Spare Parts </p>

                <a href="{{ route("purchases.create") }}?low_stock=true" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    <i class="fas fa-cart-plus mr-2"></i>Create Bulk Purchase
                </a>
            </div>
            <div class="rounded-lg border border-gray-200 p-4">
                <h4 class="mb-2 text-sm font-medium text-gray-900">Export Report</h4>
                <p class="mb-3 text-sm text-gray-600">Download this report for procurement team</p>
                <button onclick="window.print()" class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>
            </div>
        </div>
    </div>

    <!-- Category-wise Breakdown -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Low Stock by Category</h3>
        @php
        $categoryGroups = $items->groupBy("category_id");
        @endphp

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($categoryGroups as $categoryId => $categoryItems)
            @php
            $category = $categoryItems->first()->category;
            $criticalCount = $categoryItems->where("current_stock", 0)->count();
            $lowCount = $categoryItems
            ->where("current_stock", ">", 0)
            ->where("is_low_stock", true)
            ->count();
            @endphp
            <div class="rounded-lg border border-gray-200 p-4 transition-shadow hover:shadow-md">
                <div class="mb-2 flex items-start justify-between">
                    <h4 class="text-sm font-medium text-gray-900">{{ $category->name }}</h4>
                    <span class="rounded-full bg-red-100 px-2 py-1 text-xs text-red-800">
                        {{ $criticalCount + $lowCount }} Spare Parts
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
                            {{ $categoryItems->sum(function ($item) {return max(0, $item->min_stock - $item->current_stock);}) }}
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route("items.index") }}?category_id={{ $category->id }}&stock_status=low_stock" class="text-xs font-medium text-blue-600 hover:text-blue-500">
                        View Spare Part →

                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <!-- No Low Stock Spare Parts  -->

    <div class="rounded-lg bg-white p-8 text-center shadow">
        <div class="flex flex-col items-center justify-center">
            <i class="fas fa-check-circle mb-4 text-6xl text-green-500"></i>
            <h3 class="mb-2 text-2xl font-bold text-gray-900">All Spare Parts Are Sufficiently Stocked!</h3>

            <p class="mb-6 text-gray-600">Great job! No Spare Parts are currently below minimum stock levels.</p>

            <div class="flex space-x-3">
                <a href="{{ route("reports.stock") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                    View Stock Report
                </a>
                <a href="{{ route("items.index") }}" class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
                    Manage Spare Parts

                </a>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    @media print {

        nav,
        .flex.justify-between.items-center>div:last-child,
        .bg-white.shadow.rounded-lg.p-6:last-child {
            display: none !important;
        }

        .bg-red-50,
        .bg-yellow-50 {
            border: 2px solid #000 !important;
        }
    }

</style>
@endsection
