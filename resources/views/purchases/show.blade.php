@extends('layouts.app')

@section('title', $purchase->purchase_number)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Purchase: {{ $purchase->purchase_number }}</h1>
            <p class="text-gray-600">Purchase Order Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('purchases.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Purchases
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Purchase Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Purchase Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Purchase Number</dt>
                    <dd class="text-sm text-gray-900">{{ $purchase->purchase_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Vendor</dt>
                    <dd class="text-sm text-gray-900">{{ $purchase->vendor->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Purchase Date</dt>
                    <dd class="text-sm text-gray-900">{{ $purchase->purchase_date->format('M j, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                    <dd class="text-lg font-semibold text-blue-600">₹{{ number_format($purchase->total_amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created By</dt>
                    <dd class="text-sm text-gray-900">{{ $purchase->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created On</dt>
                    <dd class="text-sm text-gray-900">{{ $purchase->created_at->format('M j, Y g:i A') }}</dd>
                </div>
            </dl>

            @if($purchase->notes)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $purchase->notes }}</dd>
                </div>
            @endif
        </div>

        <!-- Purchase Items -->
        <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Purchase Items</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($purchase->purchaseItems as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->item->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->item->code }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $item->quantity }} {{ $item->item->unit }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    ₹{{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    ₹{{ number_format($item->total_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Total:</td>
                            <td class="px-4 py-3 text-sm font-bold text-blue-600">
                                ₹{{ number_format($purchase->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock Impact -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Impact</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Previous Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity Added</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">New Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($purchase->purchaseItems as $item)
                        @php
                            $previousStock = $item->item->current_stock - $item->quantity;
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $item->item->name }}</div>
                                <div class="text-sm text-gray-500">{{ $item->item->code }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $previousStock }} {{ $item->item->unit }}
                            </td>
                            <td class="px-4 py-3 text-sm text-green-600 font-semibold">
                                +{{ $item->quantity }} {{ $item->item->unit }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $item->item->current_stock }} {{ $item->item->unit }}
                            </td>
                            <td class="px-4 py-3">
                                @if($item->item->current_stock == 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                @elseif($item->item->is_low_stock)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection