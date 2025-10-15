@extends("layouts.app")

@section("title", $item->name . " - Stock Ledger")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $item->name }} - Stock Ledger</h1>
            <p class="text-gray-600">Complete stock history for {{ $item->code }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route("items.show", $item) }}" class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Spare Part
            </a>
            <a href="{{ route("stock-ledgers.index") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-list mr-2"></i>All Ledgers
            </a>
        </div>
    </div>

    <!-- Item Summary -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-2">
                    <i class="fas fa-box text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Current Stock</p>
                    <p class="text-lg font-semibold">{{ $item->current_stock }} {{ $item->unit }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-2">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Current Price</p>
                    <p class="text-lg font-semibold">Rs {{ number_format($item->current_price, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-2">
                    <i class="fas fa-calculator text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Stock Value</p>
                    <p class="text-lg font-semibold">Rs {{ number_format($item->stock_value, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-orange-100 p-2">
                    <i class="fas fa-exclamation-triangle text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Minimum Stock</p>
                    <p class="text-lg font-semibold">{{ $item->min_stock }} {{ $item->unit }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Ledger Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Quantity In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Quantity Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Unit
                            Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total
                            Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock
                            After</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Notes
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($ledgers as $ledger)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            {{ $ledger->date->format("M j, Y") }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="{{ $ledger->type == "purchase" ? "bg-green-100 text-green-800" : "" }} {{ $ledger->type == "production_output" ? "bg-blue-100 text-blue-800" : "" }} {{ $ledger->type == "production_usage" ? "bg-yellow-100 text-yellow-800" : "" }} {{ $ledger->type == "adjustment" ? "bg-purple-100 text-purple-800" : "" }} {{ $ledger->type == "sale" ? "bg-red-100 text-red-800" : "" }} inline-flex rounded-full px-2 text-xs font-semibold leading-5">
                                {{ ucfirst(str_replace("_", " ", $ledger->type)) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ $ledger->reference_type }} #{{ $ledger->reference_id }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-green-600">
                            @if ($ledger->quantity_in > 0)
                            +{{ $ledger->quantity_in }}
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-red-600">
                            @if ($ledger->quantity_out > 0)
                            -{{ $ledger->quantity_out }}
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($ledger->unit_cost, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($ledger->total_cost, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            {{ $ledger->stock_after_transaction }} {{ $item->unit }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $ledger->notes }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                            No stock movements recorded for this Spare Part.

                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($ledgers->hasPages())
        <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{ $ledgers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
