@extends('admin.layout.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quote Requests</h1>
                <p class="text-gray-600">Manage customer quote requests</p>
            </div>
            <a href="{{ route('admin.quote-requests.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Quote Request
            </a>
        </div>

        <!-- Success Notification -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 00-1.414 1.414L8.586 8.586l-2.934 2.934a1 1 0 101.414 1.414L10 9.828l2.934 2.934a1 1 0 001.414-1.414L11.414 8.586l2.934-2.934z" />
                    </svg>
                </span>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Requests</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $quoteRequests->total() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Quoted</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $quotedCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-green-600">{{ $completedCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <form method="GET" action="{{ route('admin.quote-requests.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, email, or device type..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="min-w-40">
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="quoted" {{ request('status') === 'quoted' ? 'selected' : '' }}>Quoted</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.quote-requests.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    Clear
                </a>
            </form>
        </div>

        <!-- Quote Requests Table -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Device Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($quoteRequests as $request)
                            <tr class="hover:bg-gray-50 {{ $request->deleted_at ? 'opacity-60 bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $request->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->email }}</div>
                                        @if ($request->phone)
                                            <div class="text-sm text-gray-500">{{ $request->phone }}</div>
                                        @endif
                                        @if ($request->deleted_at)
                                            <div class="text-xs text-red-600 font-medium">
                                                Deleted: {{ $request->deleted_at->format('d/m/Y H:i') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if ($request->is_existing_customer) bg-green-100 text-green-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                            {{ $request->is_existing_customer ? 'Existing' : 'New' }}
                                        </span>
                                        @if ($request->deleted_at)
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                Deleted
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->device_type }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        {{ $request->issue ? \Illuminate\Support\Str::limit($request->issue, 50) : 'No issue description' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if ($request->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status === 'quoted') bg-blue-100 text-blue-800
                                    @elseif($request->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $request->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-400">{{ $request->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.quote-requests.detail', $request) }}"
                                            class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        @if ($request->deleted_at)
                                            <!-- Restore button for deleted quote requests -->
                                            <form action="{{ route('admin.quote-requests.restore', $request->id) }}"
                                                method="POST" class="inline" id="restore-form-{{ $request->id }}">
                                                @csrf
                                                <button type="button"
                                                    onclick="confirmRestore('quote request #{{ $request->id }}', function() { document.getElementById('restore-form-{{ $request->id }}').submit(); })"
                                                    class="text-green-600 hover:text-green-900 transition-colors"
                                                    title="Restore">
                                                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Delete button for active quote requests -->
                                            <form action="{{ route('admin.quote-requests.destroy', $request) }}"
                                                method="POST" class="inline" id="delete-form-{{ $request->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="confirmDelete('quote request #{{ $request->id }}', function() { document.getElementById('delete-form-{{ $request->id }}').submit(); })"
                                                    class="text-red-600 hover:text-red-900 transition-colors">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i data-lucide="file-x" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                                        <p class="text-lg font-medium">No quote requests found</p>
                                        <p class="text-sm">Get started by creating a new quote request.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($quoteRequests->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $quoteRequests->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
