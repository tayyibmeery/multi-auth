@extends("layouts.app")

@section("title", " Bill of Materials ")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900"> Bill of Materials </h1>
            <p class="text-gray-600">Manage product recipes and components</p>
        </div>
        <a href="{{ route("boms.create") }}" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Create BOM
        </a>
    </div>

    <!--  Bill of Materials Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">BOM
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Spare Parts
                            Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Estimated Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Production Runs</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($boms as $bom)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-purple-100">
                                    <i class="fas fa-list-alt text-purple-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $bom->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($bom->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $bom->product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $bom->product->code }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $bom->bomItems->count() }} Spare Parts </div>

                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                            Rs {{ number_format($bom->total_estimated_cost, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $bom->productionRuns->count() }} runs</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
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
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route("boms.show", $bom) }}" class="mr-3 text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route("boms.edit", $bom) }}" class="mr-3 text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route("production-runs.create") }}?bom_id={{ $bom->id }}" class="mr-3 text-orange-600 hover:text-orange-900">
                                <i class="fas fa-play"></i>
                            </a>
                            <form action="{{ route("boms.destroy", $bom) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
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
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No Bill of Materials found. <a href="{{ route("boms.create") }}" class="text-blue-600 hover:text-blue-500">Create the first BOM</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($boms->hasPages())
        <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            {{ $boms->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
