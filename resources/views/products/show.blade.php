@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-gray-600">Product Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('products.edit', $product) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('boms.create') }}?product_id={{ $product->id }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-list-alt mr-2"></i>Create BOM
            </a>
            <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Product Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900">{{ $product->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Code</dt>
                    <dd class="text-sm text-gray-900">{{ $product->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900">{{ $product->description ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $product->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Stock & Pricing -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock & Pricing</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Current Stock</dt>
                    <dd class="text-2xl font-bold {{ $product->current_stock == 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $product->current_stock }} pcs
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Selling Price</dt>
                    <dd class="text-lg font-semibold text-gray-900">₹{{ number_format($product->selling_price, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Stock Value</dt>
                    <dd class="text-lg font-semibold text-blue-600">₹{{ number_format($product->stock_value, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm">
                        @if($product->current_stock == 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                In Stock
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('production-runs.create') }}?product_id={{ $product->id }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-industry mr-2"></i>Start Production
                </a>
                <a href="{{ route('stock-ledgers.product', $product->id ) }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center block">
                    <i class="fas fa-history mr-2"></i>View Stock History
                </a>
                @if($product->billOfMaterials->count() > 0)
                    <a href="{{ route('boms.index') }}?product_id={{ $product->id }}"
                       class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-center block">
                        <i class="fas fa-list-alt mr-2"></i>View BOMs ({{ $product->billOfMaterials->count() }})
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Bill of Materials -->
    @if($product->billOfMaterials->count() > 0)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill of Materials</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">BOM Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items Count</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estimated Cost</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($product->billOfMaterials as $bom)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $bom->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $bom->description ?? 'N/A' }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $bom->bomItems->count() }} items
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    ₹{{ number_format($bom->total_estimated_cost, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($bom->is_active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-medium">
                                    <a href="{{ route('boms.show', $bom) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('production-runs.create') }}?bom_id={{ $bom->id }}" class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-play"></i> Use
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Recent Stock Movements -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Stock Movements</h3>
        @if($product->stockLedgers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity In</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity Out</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock After</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($product->stockLedgers->take(10) as $ledger)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $ledger->date->format('M j, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $ledger->type)) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-green-600">
                                    @if($ledger->quantity_in > 0)
                                        +{{ $ledger->quantity_in }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-red-600">
                                    @if($ledger->quantity_out > 0)
                                        -{{ $ledger->quantity_out }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $ledger->stock_after_transaction }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $ledger->notes }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('stock-ledgers.product', $product->id) }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    View Full Stock History →
                </a>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No stock movements recorded yet.</p>
        @endif
    </div>
</div>
@endsection