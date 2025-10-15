@extends("layouts.app")

@section("title", "Products Management")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Products Management</h1>
            <p class="text-gray-600">Manage your finished products</p>
        </div>
        <a href="{{ route("products.create") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Add New Product
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-2">
                    <i class="fas fa-cube text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-lg font-semibold">{{ $products->total() }}</p>
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
                    <p class="text-lg font-semibold">{{ \App\Models\Product::where("current_stock", ">", 0)->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-red-100 p-2">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Product::where("current_stock", 0)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-2">
                    <i class="fas fa-industry text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">With BOM</p>
                    <p class="text-lg font-semibold">{{ \App\Models\Product::has("billOfMaterials")->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Code
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Current Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Selling Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock
                            Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">BOM
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-purple-100">
                                    <i class="fas fa-cube text-purple-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $product->code }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $product->current_stock }} pcs</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($product->selling_price, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($product->stock_value, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($product->billOfMaterials->count() > 0)
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                {{ $product->billOfMaterials->count() }} BOM(s)
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
                                No BOM
                            </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($product->current_stock == 0)
                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                Out of Stock
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                In Stock
                            </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route("products.show", $product) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route("products.edit", $product) }}" class="mr-3 text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route("boms.create") }}?product_id={{ $product->id }}" class="mr-3 text-purple-600 hover:text-purple-900">
                                <i class="fas fa-list-alt"></i>
                            </a>
                            <form action="{{ route("products.destroy", $product) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
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
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            No products found. <a href="{{ route("products.create") }}" class="text-blue-600 hover:text-blue-500">Create the first product</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
        <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
