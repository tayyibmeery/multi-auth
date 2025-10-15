@extends("layouts.app")

@section("title", "Low Stock Spare Parts ")


@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Low Stock Spare Parts </h1>

            <p class="text-gray-600">Spare Parts that need to be reordered</p>

        </div>
        <a href="{{ route("items.index") }}" class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>Back to Spare Parts

        </a>
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-red-800">Spare Part
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-red-800">
                            Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-red-800">
                            Current Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-red-800">
                            Minimum Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-red-800">
                            Required</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-red-800">Price
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-red-800">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($items as $item)
                    <tr class="hover:bg-red-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-red-100">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
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
                            <div class="text-sm font-semibold text-red-600">{{ $item->current_stock }}
                                {{ $item->unit }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item->min_stock }} {{ $item->unit }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm font-semibold text-red-600">
                                {{ max(0, $item->min_stock - $item->current_stock) }} {{ $item->unit }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($item->current_price, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route("purchases.create") }}?item_id={{ $item->id }}" class="mr-3 text-green-600 hover:text-green-900">
                                <i class="fas fa-shopping-cart"></i> Purchase
                            </a>
                            <a href="{{ route("items.show", $item) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route("items.edit", $item) }}" class="text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <i class="fas fa-check-circle mb-4 text-4xl text-green-500"></i>
                                <p class="text-lg font-medium text-gray-900">All Spare Parts are sufficiently stocked!</p>

                                <p class="text-gray-600">No low stock Spare Parts found.</p>

                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
        <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{ $items->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
