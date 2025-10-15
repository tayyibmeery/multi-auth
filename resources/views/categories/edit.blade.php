@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Edit Category: {{ $category->name }}</h2>
        </div>
        <form action="{{ route('categories.update', $category) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name *</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('name', $category->name) }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $category->description) }}</textarea>
                </div>

                <!-- Category Statistics -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Category Statistics</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Spare Parts in this category:</span>

                            <span class="font-semibold text-blue-600 ml-2">{{ $category->items_count }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Created:</span>
                            <span class="font-semibold text-gray-600 ml-2">{{ $category->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($category->items_count > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Important Notice</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>This category contains {{ $category->items_count }} Spare Parts . Editing the category name will update it for all associated items.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('categories.show', $category) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection