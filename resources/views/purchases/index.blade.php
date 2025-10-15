@extends("layouts.app")

@section("title", "Purchases Management")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Purchases Management</h1>
            <p class="text-gray-600">Manage purchase orders and inventory receipts</p>
        </div>
        <a href="{{ route("purchases.create") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Create Purchase
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-2">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Purchases</p>
                    <p class="text-lg font-semibold">{{ $purchases->total() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-2">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Amount</p>
                    <p class="text-lg font-semibold">Rs {{ number_format($purchases->sum("total_amount"), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-2">
                    <i class="fas fa-truck text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Vendors</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Vendor::count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-orange-100 p-2">
                    <i class="fas fa-calendar text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">This Month</p>
                    <p class="text-lg font-semibold">
                        {{ \App\Models\Purchase::whereMonth("purchase_date", now()->month)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Purchase No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Vendor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Spare Parts
                            Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total
                            Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Created By</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-green-100">
                                    <i class="fas fa-shopping-cart text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $purchase->purchase_number }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $purchase->purchase_date->format("M j, Y") }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $purchase->vendor->name }}</div>
                            <div class="text-sm text-gray-500">{{ $purchase->vendor->contact_person ?? "N/A" }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ $purchase->purchase_date->format("M j, Y") }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $purchase->purchaseItems->count() }} Spare Parts </div>

                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">
                            Rs {{ number_format($purchase->total_amount, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ $purchase->user->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route("purchases.show", $purchase) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if (auth()->user()->isAdmin())
                            <form action="{{ route("purchases.destroy", $purchase) }}" method="POST" class="inline" onsubmit="return confirmDelete('Are you sure you want to delete this purchase? This action cannot be undone.')">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No purchases found. <a href="{{ route("purchases.create") }}" class="text-blue-600 hover:text-blue-500">Create the first purchase</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($purchases->hasPages())
        <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{ $purchases->links() }}
        </div>
        @endif
    </div>

    <!-- Monthly Purchase Chart -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Monthly Purchase Summary ({{ now()->year }})</h3>
        @php
        $monthlyData = \App\Models\Purchase::select(
        \DB::raw("MONTH(purchase_date) as month"),
        \DB::raw("YEAR(purchase_date) as year"),
        \DB::raw("COUNT(*) as count"),
        \DB::raw("SUM(total_amount) as total"),
        )
        ->whereYear("purchase_date", now()->year)
        ->groupBy("year", "month")
        ->orderBy("year", "asc")
        ->orderBy("month", "asc")
        ->get();
        @endphp

        @if ($monthlyData->count() > 0)
        <div class="space-y-4">
            @foreach ($monthlyData as $data)
            <div class="flex items-center justify-between">
                <span class="w-24 text-sm font-medium text-gray-600">
                    {{ DateTime::createFromFormat("!m", $data->month)->format("F") }}
                </span>
                <div class="mx-4 flex-1">
                    <div class="h-3 w-full rounded-full bg-gray-200">
                        <div class="h-3 rounded-full bg-blue-600" style="width: {{ min(($data->total / ($monthlyData->max("total") ?: 1)) * 100, 100) }}%">
                        </div>
                    </div>
                </div>
                <div class="w-32 text-right">
                    <span class="text-sm font-medium text-gray-900">Rs
                        {{ number_format($data->total, 2) }}</span>
                    <span class="ml-2 text-xs text-gray-500">({{ $data->count }} purchases)</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="py-4 text-center text-gray-500">No purchase data available for this year.</p>
        @endif
    </div>

    <!-- Top Vendors -->
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Top Vendors</h3>
        @php
        $topVendors = \App\Models\Vendor::withCount("purchases")
        ->withSum("purchases", "total_amount")
        ->orderBy("purchases_sum_total_amount", "desc")
        ->limit(5)
        ->get();
        @endphp

        @if ($topVendors->count() > 0)
        <div class="space-y-4">
            @foreach ($topVendors as $vendor)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="rounded-lg bg-gray-100 p-2">
                        <i class="fas fa-building text-gray-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $vendor->name }}</p>
                        <p class="text-xs text-gray-500">{{ $vendor->purchases_count }} purchases</p>
                    </div>
                </div>
                <span class="text-sm font-semibold text-blue-600">
                    Rs {{ number_format($vendor->purchases_sum_total_amount, 2) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <p class="py-4 text-center text-gray-500">No vendor data available.</p>
        @endif
    </div>
</div>
@endsection
