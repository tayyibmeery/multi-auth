@extends("layouts.app")

@section("title", "Stock Valuation Report")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stock Valuation Report</h1>
            <p class="text-gray-600">Complete inventory valuation and cost analysis</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route("reports.stock") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-boxes mr-2"></i>Stock Report
            </a>
            <a href="{{ route("reports.low-stock") }}" class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700">
                <i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Report
            </a>
        </div>
    </div>

    <!-- Total Valuation Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-3">
                    <i class="fas fa-boxes text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Spare Parts Stock Value</p>

                    <p class="text-2xl font-bold text-blue-600">Rs {{ number_format($totalItemValue, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-3">
                    <i class="fas fa-cube text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Products Stock Value</p>
                    <p class="text-2xl font-bold text-green-600">Rs {{ number_format($totalProductValue, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-3">
                    <i class="fas fa-calculator text-2xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Inventory Value</p>
                    <p class="text-2xl font-bold text-purple-600">Rs
                        {{ number_format($totalItemValue + $totalProductValue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Valuation -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Items Valuation (Raw Materials)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Spare Part</th>

                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Unit Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">% of Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
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
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                            Rs {{ number_format($item->total_value, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $totalItemValue > 0 ? number_format(($item->total_value / $totalItemValue) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total Spare Parts

                            Value:</td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">
                            Rs {{ number_format($totalItemValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Products Valuation -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Products Valuation (Finished Goods)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Current Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Selling Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">% of Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->code }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $product->current_stock }} units
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($product->selling_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                            Rs {{ number_format($product->total_value, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $totalProductValue > 0 ? number_format(($product->total_value / $totalProductValue) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900">Total Products
                            Value:</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">
                            Rs {{ number_format($totalProductValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Valuation Summary -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Valuation Summary</h2>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Spare Parts  vs Products -->

            <div>
                <h3 class="mb-3 text-lg font-medium text-gray-900">Inventory Distribution</h3>
                <div class="space-y-3">
                    <div>
                        <div class="mb-1 flex justify-between text-sm">
                            <span class="text-gray-600">Raw Materials (Spare Parts )</span>

                            <span class="font-medium">Rs {{ number_format($totalItemValue, 2) }}</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-gray-200">
                            <div class="h-2 rounded-full bg-blue-600" style="width: {{ $totalItemValue + $totalProductValue > 0 ? ($totalItemValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 flex justify-between text-sm">
                            <span class="text-gray-600">Finished Goods (Products)</span>
                            <span class="font-medium">Rs {{ number_format($totalProductValue, 2) }}</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-gray-200">
                            <div class="h-2 rounded-full bg-green-600" style="width: {{ $totalItemValue + $totalProductValue > 0 ? ($totalProductValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top 5 Most Valuable -->
            <div>
                <h3 class="mb-3 text-lg font-medium text-gray-900">Top 5 Most Valuable Spare Parts </h3>

                <div class="space-y-2">
                    @foreach ($items->sortByDesc("total_value")->take(5) as $item)
                    <div class="flex items-center justify-between text-sm">
                        <span class="truncate text-gray-600">{{ $item->name }}</span>
                        <span class="font-medium text-blue-600">Rs
                            {{ number_format($item->total_value, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
