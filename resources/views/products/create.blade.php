@extends("layouts.app")

@section("title", "Create Product")

@section("content")
				<div class="mx-auto max-w-4xl">
								<div class="rounded-lg bg-white shadow">
												<div class="border-b border-gray-200 px-6 py-4">
																<h2 class="text-xl font-semibold text-gray-800">Create New Product</h2>
												</div>
												<form action="{{ route("products.store") }}" method="POST" class="p-6">
																@csrf
																<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
																				<div class="space-y-4">
																								<div>
																												<label for="name" class="block text-sm font-medium text-gray-700">Product Name *</label>
																												<input type="text" name="name" id="name" required
																																class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																																value="{{ old("name") }}">
																												@error("name")
																																<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																												@enderror
																								</div>

																								<div>
																												<label for="code" class="block text-sm font-medium text-gray-700">Product Code *</label>
																												<input type="text" name="code" id="code" required
																																class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																																value="{{ old("code") }}">
																												@error("code")
																																<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																												@enderror
																								</div>
																				</div>

																				<div class="space-y-4">
																								<div>
																												<label for="selling_price" class="block text-sm font-medium text-gray-700">Selling Price (Rs )
																																*</label>
																												<input type="number" name="selling_price" id="selling_price" step="0.01" min="0"
																																required
																																class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																																value="{{ old("selling_price", 0) }}">
																												@error("selling_price")
																																<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																												@enderror
																								</div>

																								<div>
																												<label for="current_stock" class="block text-sm font-medium text-gray-700">Current Stock
																																*</label>
																												<input type="number" name="current_stock" id="current_stock" min="0" required
																																class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
																																value="{{ old("current_stock", 0) }}">
																												@error("current_stock")
																																<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
																												@enderror
																								</div>
																				</div>
																</div>

																<div class="mt-6">
																				<label for="description" class="block text-sm font-medium text-gray-700">Description</label>
																				<textarea name="description" id="description" rows="3"
																				    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">{{ old("description") }}</textarea>
																</div>

																<div class="mt-6 flex justify-end space-x-3">
																				<a href="{{ route("products.index") }}"
																								class="rounded-lg bg-gray-300 px-4 py-2 font-medium text-gray-800 hover:bg-gray-400">
																								Cancel
																				</a>
																				<button type="submit"
																								class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
																								Create Product
																				</button>
																</div>
												</form>
								</div>
				</div>
@endsection
