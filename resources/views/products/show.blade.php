@extends("layouts.app")

@section("title", $product->name)

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-gray-600">Product Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route("products.edit", $product) }}" class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route("boms.create") }}?product_id={{ $product->id }}" class="rounded-lg bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700">
                <i class="fas fa-list-alt mr-2"></i>Create BOM
            </a>
            <a href="{{ route("products.index") }}" class="rounded-lg bg-gray-600 px-4 py-2 font-medium text-white hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Product Information -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Product Information</h3>
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
                    <dd class="text-sm text-gray-900">{{ $product->description ?? "N/A" }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $product->created_at->format("M j, Y") }}</dd>
                </div>
            </dl>
        </div>

        <!-- Stock & Pricing -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Stock & Pricing</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Current Stock</dt>
                    <dd class="{{ $product->current_stock == 0 ? "text-red-600" : "text-green-600" }} text-2xl font-bold">
                        {{ $product->current_stock }} pcs
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Selling Price</dt>
                    <dd class="text-lg font-semibold text-gray-900">Rs {{ number_format($product->selling_price, 2) }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Stock Value</dt>
                    <dd class="text-lg font-semibold text-blue-600">Rs {{ number_format($product->stock_value, 2) }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm">
                        @if ($product->current_stock == 0)
                        <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                            Out of Stock
                        </span>
                        @else
                        <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                            In Stock
                        </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route("production-runs.create") }}?product_id={{ $product->id }}" class="block w-full rounded-lg bg-blue-600 px-4 py-2 text-center text-white hover:bg-blue-700">
                    <i class="fas fa-industry mr-2"></i>Start Production
                </a>
                <a href="{{ route("stock-ledgers.product", $product->id) }}" class="block w-full rounded-lg bg-green-600 px-4 py-2 text-center text-white hover:bg-green-700">
                    <i class="fas fa-history mr-2"></i>View Stock History
                </a>
                @if ($product->billOfMaterials->count() > 0)
                <a href="{{ route("boms.index") }}?product_id={{ $product->id }}" class="block w-full rounded-lg bg-purple-600 px-4 py-2 text-center text-white hover:bg-purple-700">
                    <i class="fas fa-list-alt mr-2"></i>ViewBill of
                    Materials({{ $product->billOfMaterials->count() }})
                </a>
                @endif
            </div>
        </div>
    </div>

    <!--   Bill of Materials  -->
    @if ($product->billOfMaterials->count() > 0)
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900"> Bill of Materials </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">BOM Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Spare Parts Count</th>

                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Estimated Cost
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($product->billOfMaterials as $bom)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $bom->name }}</div>
                            <div class="text-sm text-gray-500">{{ $bom->description ?? "N/A" }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $bom->bomItems->count() }} Spare Parts

                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            Rs {{ number_format($bom->total_estimated_cost, 2) }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($bom->is_active)
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                Active
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
                                Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            <a href="{{ route("boms.show", $bom) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route("production-runs.create") }}?bom_id={{ $bom->id }}" class="text-green-600 hover:text-green-900">
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
    <div class="rounded-lg bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Recent Stock Movements</h3>
        @if ($product->stockLedgers->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity In</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Quantity Out
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Stock After</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($product->stockLedgers->take(10) as $ledger)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $ledger->date->format("M j, Y") }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ ucfirst(str_replace("_", " ", $ledger->type)) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-green-600">
                            @if ($ledger->quantity_in > 0)
                            +{{ $ledger->quantity_in }}
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-red-600">
                            @if ($ledger->quantity_out > 0)
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
            <a href="{{ route("stock-ledgers.product", $product->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                View Full Stock History →
            </a>
        </div>
        @else
        <p class="py-4 text-center text-gray-500">No stock movements recorded yet.</p>
        @endif
    </div>
</div>
@endsection
