@extends("layouts.app")

@section("title", "Spare Parts Management")


@section("content")
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Spare Parts Management</h1>

            <p class="text-gray-600">Manage your inventory Spare Parts and components</p>

        </div>
        <div class="flex space-x-3">
            <a href="{{ route("items.low-stock") }}" class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700">
                <i class="fas fa-exclamation-triangle mr-2"></i>Low Stock
            </a>
            <a href="{{ route("items.create") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add New Spare Parts

            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-2">
                    <i class="fas fa-boxes text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Spare Parts </p>

                    <p class="text-lg font-semibold">{{ $items->total() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">In Stock</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Item::where("current_stock", ">", 0)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-red-100 p-2">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Low Stock</p>
                    <p class="text-lg font-semibold">
                        {{ \App\Models\Item::whereRaw("current_stock <= min_stock")->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-gray-100 p-2">
                    <i class="fas fa-times-circle text-gray-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Item::where("current_stock", 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="rounded-lg bg-white p-4 shadow">
        <div class="flex flex-col space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="max-w-md flex-1">
                <input type="text" placeholder="Search Spare Parts..." class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500">

            </div>
            <div class="flex space-x-3">
                <select class="rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <!-- Categories will be populated dynamically -->
                </select>
                <select class="rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Stock Status</option>
                    <option value="in_stock">In Stock</option>
                    <option value="low_stock">Low Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Spare Parts  Table -->

    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Spare Part
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Current Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Price
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock
                            Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100">
                                    <i class="fas fa-box text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->code }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item->category->name }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item->current_stock }} {{ $item->unit }}</div>
                            <div class="text-xs text-gray-500">Min: {{ $item->min_stock }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($item->stock_value, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
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
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route("items.show", $item) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route("items.edit", $item) }}" class="mr-3 text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route("items.destroy", $item) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No Spare Part found. <a href="{{ route("items.create") }}" class="text-blue-600 hover:text-blue-500">Create the first item</a>.

                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($items->hasPages())
        <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{ $items->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
