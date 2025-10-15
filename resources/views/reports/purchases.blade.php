@extends("layouts.app")

@section("title", "Purchases Report")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Purchases Report</h1>
            <p class="text-gray-600">Detailed purchase analysis and statistics</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route("reports.stock") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                <i class="fas fa-boxes mr-2"></i>Stock Report
            </a>
            <a href="{{ route("reports.production") }}" class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                <i class="fas fa-industry mr-2"></i>Production Report
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="rounded-lg bg-white p-4 shadow">
        <form method="GET" action="{{ route("reports.purchases") }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <label for="vendor_id" class="block text-sm font-medium text-gray-700">Vendor</label>
                <select name="vendor_id" id="vendor_id" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                    <option value="">All Vendors</option>
                    @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ request("vendor_id") == $vendor->id ? "selected" : "" }}>
                        {{ $vendor->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" name="date_from" id="date_from" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500" value="{{ request("date_from") }}">
            </div>
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" name="date_to" id="date_to" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500" value="{{ request("date_to") }}">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-2">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Purchases</p>
                    <p class="text-lg font-semibold">{{ $purchases->count() }}</p>
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
                    <p class="text-lg font-semibold">{{ $purchases->groupBy("vendor_id")->count() }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-orange-100 p-2">
                    <i class="fas fa-boxes text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Spare Parts Purchased</p>

                    <p class="text-lg font-semibold">
                        {{ $purchases->sum(function ($purchase) {return $purchase->purchaseItems->count();}) }}</p>
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
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total
                            Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Created By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $purchase->purchase_number }}</div>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No purchases found for the selected criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if ($purchases->count() > 0)
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total:
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-blue-600">
                            Rs {{ number_format($purchases->sum("total_amount"), 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Vendor Breakdown -->
    @if ($purchases->count() > 0)
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Vendor Breakdown</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Vendor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Purchases</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Total Amount
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Average
                            Purchase</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">% of Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                    $vendorGroups = $purchases->groupBy("vendor_id");
                    $totalAmount = $purchases->sum("total_amount");
                    @endphp
                    @foreach ($vendorGroups as $vendorId => $vendorPurchases)
                    @php
                    $vendor = $vendorPurchases->first()->vendor;
                    $vendorTotal = $vendorPurchases->sum("total_amount");
                    $percentage = $totalAmount > 0 ? ($vendorTotal / $totalAmount) * 100 : 0;
                    @endphp
                    <tr>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $vendor->name }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $vendorPurchases->count() }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($vendorTotal, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($vendorTotal / $vendorPurchases->count(), 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ number_format($percentage, 1) }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
