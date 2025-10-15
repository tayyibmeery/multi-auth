@extends("layouts.app")

@section("title", $category->name)

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
            <p class="text-gray-600">Category Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route("categories.edit", $category) }}" class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route("categories.index") }}" class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Category Information -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Category Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900">{{ $category->description ?? "No description provided" }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Spare Parts Count</dt>

                    <dd class="text-sm text-gray-900">{{ $category->items_count }} Spare Parts </dd>

                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $category->created_at->format("M j, Y") }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="text-sm text-gray-900">{{ $category->updated_at->format("M j, Y") }}</dd>
                </div>
            </dl>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route("items.create") }}?category_id={{ $category->id }}" class="block w-full rounded-lg bg-blue-600 px-4 py-2 text-center text-white hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Add Spare Parts to this Category

                </a>
                <a href="{{ route("items.index") }}?category_id={{ $category->id }}" class="block w-full rounded-lg bg-green-600 px-4 py-2 text-center text-white hover:bg-green-700">
                    <i class="fas fa-list mr-2"></i>View All Spare Parts ({{ $category->items_count }})

                </a>
            </div>

            <!-- Category Statistics -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h4 class="mb-3 text-sm font-medium text-gray-900">Category Statistics</h4>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Spare Parts </span>

                        <span class="font-medium text-blue-600">{{ $category->items_count }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">In Stock Spare Parts </span>

                        <span class="font-medium text-green-600">
                            {{ $category->items->where("current_stock", ">", 0)->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Low Stock Spare Parts </span>

                        <span class="font-medium text-yellow-600">
                            {{ $category->items->where("current_stock", "<=", \DB::raw("min_stock"))->where("current_stock", ">", 0)->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Out of Stock</span>
                        <span class="font-medium text-red-600">
                            {{ $category->items->where("current_stock", 0)->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Summary -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Stock Summary</h3>
            <div class="space-y-4">
                <div>
                    <div class="mb-1 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Total Stock Value</span>
                        <span class="text-sm font-semibold text-blue-600">
                            Rs {{ number_format($category->items->sum("stock_value"), 2) }}
                        </span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-blue-600" style="width: 100%"></div>
                    </div>
                </div>

                <div>
                    <div class="mb-1 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Average Item Price</span>
                        <span class="text-sm font-semibold text-green-600">
                            @if ($category->items_count > 0)
                            Rs {{ number_format($category->items->avg("current_price"), 2) }}
                            @else
                            Rs 0.00
                            @endif
                        </span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-green-600" style="width: 75%"></div>
                    </div>
                </div>

                <div>
                    <div class="mb-1 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Stock Health</span>
                        <span class="@if ($category->items->where(" current_stock", 0)->count() > 0) text-red-600
                            @elseif($category->items->where("current_stock", "<=", \DB::raw("min_stock"))->count() > 0) text-yellow-600
                                @else text-green-600 @endif text-sm font-semibold">
                                @if ($category->items->where("current_stock", 0)->count() > 0)
                                Needs Attention
                                @elseif($category->items->where("current_stock", "<=", \DB::raw("min_stock"))->count() > 0)
                                    Low Stock
                                    @else
                                    Healthy
                                    @endif
                        </span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        <div class="@if ($category->items->where(" current_stock", 0)->count() > 0) bg-red-600
                            @elseif($category->items->where("current_stock", "<=", \DB::raw("min_stock"))->count() > 0) bg-yellow-600
                                @else bg-green-600 @endif h-2 rounded-full"
                                style="width:
                                @if ($category->items->where("current_stock", 0)->count() > 0) 40%
                                @elseif($category->items->where("current_stock", "<=", \DB::raw("min_stock"))->count() > 0) 70%
                                    @else 100% @endif">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items in this Category -->
    <div class="rounded-lg bg-white p-6 shadow">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Spare Parts in this Category ({{ $category->items_count }})</h3>

            <a href="{{ route("items.create") }}?category_id={{ $category->id }}" class="rounded-lg bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Add Spare Part
            </a>
        </div>

        @if ($category->items_count > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Spare Part</th>

                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Current Stock
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Min Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($category->items as $item)
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
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($item->stock_value, 2) }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($item->current_stock == 0)
                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                Out of Stock
                            </span>
                            @elseif($item->is_low_stock)
                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
                                Low Stock
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                In Stock
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            <a href="{{ route("items.show", $item) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                View
                            </a>
                            <a href="{{ route("items.edit", $item) }}" class="text-green-600 hover:text-green-900">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-8 text-center">
            <i class="fas fa-boxes mb-4 text-4xl text-gray-400"></i>
            <p class="mb-2 text-lg text-gray-500">No Spare Parts in this category yet</p>

            <p class="mb-4 text-sm text-gray-400">Start by adding Spare Parts to this category</p>

            <a href="{{ route("items.create") }}?category_id={{ $category->id }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add First Spare Part
            </a>
        </div>
        @endif
    </div>

    <!-- Low Stock Spare Parts  -->

    @php
    $lowStockItems = $category->items->filter(function ($item) {
    return $item->is_low_stock || $item->current_stock == 0;
    });
    @endphp

    @if ($lowStockItems->count() > 0)
    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-6">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-yellow-800">Low Stock Alert</h3>
            <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-800">
                {{ $lowStockItems->count() }} Spare Parts need attention

            </span>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($lowStockItems->take(6) as $item)
            <div class="rounded-lg border border-yellow-200 bg-white p-4">
                <div class="mb-2 flex items-start justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">{{ $item->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->code }}</p>
                    </div>
                    @if ($item->current_stock == 0)
                    <span class="rounded-full bg-red-100 px-2 py-1 text-xs text-red-800">Out of
                        Stock</span>
                    @else
                    <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800">Low
                        Stock</span>
                    @endif
                </div>
                <div class="text-xs text-gray-600">
                    <p>Current: {{ $item->current_stock }} {{ $item->unit }}</p>
                    <p>Minimum: {{ $item->min_stock }} {{ $item->unit }}</p>
                    <p>Need: {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}</p>
                </div>
                <div class="mt-2">
                    <a href="{{ route("purchases.create") }}?item_id={{ $item->id }}" class="text-xs font-medium text-blue-600 hover:text-blue-500">
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
