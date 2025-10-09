@extends('layouts.app')

@section('title', 'Vendors Management')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Vendors</h1>
            <p class="text-gray-600">Manage your suppliers and vendors</p>
        </div>
        <a href="{{ route('vendors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            <i class="fas fa-plus mr-2"></i>Add Vendor
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email/Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Purchases</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vendors as $vendor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $vendor->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($vendor->address, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $vendor->contact_person ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $vendor->email ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $vendor->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">₹{{ number_format($vendor->total_purchases, 2) }}</div>
                                <div class="text-xs text-gray-500">{{ $vendor->purchases_count }} purchases</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('vendors.show', $vendor) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('vendors.edit', $vendor) }}" class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="inline" onsubmit="return confirmDelete('Are you sure you want to delete this vendor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No vendors found. <a href="{{ route('vendors.create') }}" class="text-blue-600 hover:text-blue-500">Create the first vendor</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($vendors->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $vendors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection