@extends('layouts.app')

@section('title', $vendor->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $vendor->name }}</h1>
            <p class="text-gray-600">Vendor Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('vendors.edit', $vendor) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('vendors.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Vendors
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Vendor Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Vendor Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900">{{ $vendor->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                    <dd class="text-sm text-gray-900">{{ $vendor->contact_person ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="text-sm text-gray-900">
                        @if($vendor->email)
                            <a href="mailto:{{ $vendor->email }}" class="text-blue-600 hover:text-blue-500">
                                {{ $vendor->email }}
                            </a>
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                    <dd class="text-sm text-gray-900">
                        @if($vendor->phone)
                            <a href="tel:{{ $vendor->phone }}" class="text-blue-600 hover:text-blue-500">
                                {{ $vendor->phone }}
                            </a>
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                    <dd class="text-sm text-gray-900">{{ $vendor->address ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Purchases</dt>
                    <dd class="text-lg font-semibold text-blue-600">₹{{ number_format($vendor->total_purchases, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Purchase Count</dt>
                    <dd class="text-sm text-gray-900">{{ $vendor->purchases_count }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Average Purchase</dt>
                    <dd class="text-sm text-gray-900">
                        @if($vendor->purchases_count > 0)
                            ₹{{ number_format($vendor->total_purchases / $vendor->purchases_count, 2) }}
                        @else
                            ₹0.00
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('purchases.create') }}?vendor_id={{ $vendor->id }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-shopping-cart mr-2"></i>Create Purchase
                </a>
                <a href="mailto:{{ $vendor->email }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-envelope mr-2"></i>Send Email
                </a>
                @if($vendor->phone)
                    <a href="tel:{{ $vendor->phone }}"
                       class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-center block">
                        <i class="fas fa-phone mr-2"></i>Call Vendor
                    </a>
                @endif
            </div>

            <!-- Statistics -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Performance Metrics</h4>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Reliability Score</span>
                        <span class="font-medium text-green-600">Excellent</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Response Time</span>
                        <span class="font-medium text-gray-600">24-48 hours</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Payment Terms</span>
                        <span class="font-medium text-gray-600">Net 30</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Statistics -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Purchase Statistics</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Total Purchase Value</span>
                        <span class="text-sm font-semibold text-blue-600">₹{{ number_format($vendor->total_purchases, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Number of Purchases</span>
                        <span class="text-sm font-semibold text-green-600">{{ $vendor->purchases_count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(($vendor->purchases_count / max($vendor->purchases_count, 1)) * 100, 100) }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Average Purchase Value</span>
                        <span class="text-sm font-semibold text-purple-600">
                            @if($vendor->purchases_count > 0)
                                ₹{{ number_format($vendor->total_purchases / $vendor->purchases_count, 2) }}
                            @else
                                ₹0.00
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Monthly Trend</h4>
                @php
                    $monthlyPurchases = $vendor->purchases()
                        ->selectRaw('MONTH(purchase_date) as month, YEAR(purchase_date) as year, SUM(total_amount) as total')
                        ->whereYear('purchase_date', now()->year)
                        ->groupBy('year', 'month')
                        ->orderBy('year', 'asc')
                        ->orderBy('month', 'asc')
                        ->get();
                @endphp

                @if($monthlyPurchases->count() > 0)
                    <div class="space-y-2">
                        @foreach($monthlyPurchases as $data)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">
                                    {{ DateTime::createFromFormat('!m', $data->month)->format('M') }}
                                </span>
                                <span class="font-medium text-gray-900">
                                    ₹{{ number_format($data->total, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center">No purchases this year</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Purchases -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Purchases</h3>
            <a href="{{ route('purchases.create') }}?vendor_id={{ $vendor->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">
                <i class="fas fa-plus mr-1"></i> New Purchase
            </a>
        </div>

        @if($vendor->purchases->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Purchase No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items Count</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($vendor->purchases->take(10) as $purchase)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $purchase->purchase_number }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $purchase->purchase_date->format('M j, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $purchase->purchaseItems->count() }} items
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    ₹{{ number_format($purchase->total_amount, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium">
                                    <a href="{{ route('purchases.show', $purchase) }}" class="text-blue-600 hover:text-blue-900">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('purchases.index') }}?vendor_id={{ $vendor->id }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    View All Purchases from this Vendor →
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">No purchases from this vendor yet</p>
                <p class="text-gray-400 text-sm mb-4">Start by creating your first purchase order</p>
                <a href="{{ route('purchases.create') }}?vendor_id={{ $vendor->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Create First Purchase
                </a>
            </div>
        @endif
    </div>

    <!-- Top Purchased Items -->
    @if($vendor->purchases->count() > 0)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Frequently Purchased Items</h3>
            @php
                $purchaseItems = $vendor->purchases->flatMap->purchaseItems;
                $itemGroups = $purchaseItems->groupBy('item_id');
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($itemGroups->take(6) as $itemId => $items)
                    @php
                        $item = $items->first()->item;
                        $totalQuantity = $items->sum('quantity');
                        $totalSpent = $items->sum('total_price');
                    @endphp
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $item->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $item->code }}</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ $items->count() }} purchases
                            </span>
                        </div>
                        <div class="space-y-1 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Quantity:</span>
                                <span class="font-medium">{{ $totalQuantity }} {{ $item->unit }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Spent:</span>
                                <span class="font-medium text-green-600">₹{{ number_format($totalSpent, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Avg Price:</span>
                                <span class="font-medium">₹{{ number_format($totalSpent / $totalQuantity, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection