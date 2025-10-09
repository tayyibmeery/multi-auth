@extends('layouts.app')

@section('title', 'Stock Ledger')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stock Ledger</h1>
            <p class="text-gray-600">Complete audit trail of all stock movements</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <form method="GET" action="{{ route('stock-ledgers.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
                <select name="type" id="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Types</option>
                    <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Purchase</option>
                    <option value="production_usage" {{ request('type') == 'production_usage' ? 'selected' : '' }}>Production Usage</option>
                    <option value="production_output" {{ request('type') == 'production_output' ? 'selected' : '' }}>Production Output</option>
                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                </select>
            </div>
            <div>
                <label for="item_id" class="block text-sm font-medium text-gray-700">Item</label>
                <select name="item_id" id="item_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Items</option>
                    @foreach(\App\Models\Item::all() as $item)
                        <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} ({{ $item->code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" name="date_from" id="date_from"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       value="{{ request('date_from') }}">
            </div>
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" name="date_to" id="date_to"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       value="{{ request('date_to') }}">
            </div>
            <div class="md:col-span-4 flex justify-end space-x-3">
                <a href="{{ route('stock-ledgers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium">
                    Clear Filters
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Stock Ledger Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item/Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock After</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($stockLedgers as $ledger)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                             
                                  {{ \Carbon\Carbon::parse($ledger->date)->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $ledger->type == 'purchase' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $ledger->type == 'production_output' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $ledger->type == 'production_usage' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $ledger->type == 'adjustment' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $ledger->type == 'sale' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ledger->type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ledger->item)
                                    <div class="text-sm font-medium text-gray-900">{{ $ledger->item->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $ledger->item->code }}</div>
                                @elseif($ledger->product)
                                    <div class="text-sm font-medium text-gray-900">{{ $ledger->product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $ledger->product->code }}</div>
                                @else
                                    <span class="text-sm text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $ledger->reference_type }} #{{ $ledger->reference_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                @if($ledger->quantity_in > 0)
                                    +{{ $ledger->quantity_in }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                                @if($ledger->quantity_out > 0)
                                    -{{ $ledger->quantity_out }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($ledger->unit_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ₹{{ number_format($ledger->total_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $ledger->stock_after_transaction }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $ledger->user->name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                No stock movements found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stockLedgers->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $stockLedgers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection