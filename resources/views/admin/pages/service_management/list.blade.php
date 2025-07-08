@extends('admin/layout.app')

@section('title', 'Service Management')

@section('content')
@php
    $categories = $categories ?? ['Laptop', 'Phone', 'Tablet'];
    $deviceTypes = $deviceTypes ?? ['iOS', 'Android', 'Windows'];
    $services = $services ?? collect([
    (object)[
        'id' => 1,
        'name' => 'Screen Replacement',
        'category' => 'Display Repair',
        'device_type' => 'smartphone, tablet',
        'price' => 200.00,
        'estimated_time' => '2h',
        'is_active' => true,
        'description' => 'Complete screen assembly replacement including LCD/OLED and digitizer'
    ],
    (object)[
        'id' => 2,
        'name' => 'Battery Replacement',
        'category' => 'Power System',
        'device_type' => 'smartphone, tablet, laptop',
        'price' => 110.00,
        'estimated_time' => '1h',
        'is_active' => true,
        'description' => 'Replace worn-out battery with genuine or high-quality compatible battery'
    ],
    (object)[
        'id' => 3,
        'name' => 'Water Damage Restoration',
        'category' => 'Liquid Damage',
        'device_type' => 'smartphone, tablet, laptop',
        'price' => 200.00,
        'estimated_time' => '4h',
        'is_active' => true,
        'description' => 'Complete liquid damage assessment and restoration service'
    ],
    (object)[
        'id' => 4,
        'name' => 'Motherboard Repair',
        'category' => 'Logic Board',
        'device_type' => 'smartphone, tablet, laptop',
        'price' => 350.00,
        'estimated_time' => '8h',
        'is_active' => false,
        'description' => 'Advanced motherboard component-level repair and reballing'
    ],
]);

    $categoryStats = $categoryStats ?? [
        'Repair' => ['total' => 5, 'active' => 3],
        'Replacement' => ['total' => 8, 'active' => 6],
        'Maintenance' => ['total' => 2, 'active' => 1],
    ];
@endphp

<div class="space-y-6" x-data="serviceManagement()">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Service Management</h1>
        <a href="" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add Service</span>
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="relative flex-1 md:max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <form method="GET" action="">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search services..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                        value="{{ request('search') }}"
                        x-model="searchTerm"
                        @input.debounce.300ms="search()"
                    />
                </form>
            </div>
            <div class="flex items-center space-x-2">
                <form method="GET" action="" class="flex items-center space-x-2">
                    <input type="hidden" name="search" :value="searchTerm">
            
                    <select name="category" 
                    onchange="this.form.submit()"
                    class="px-4 py-2 pr-14 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Categories</option>
                <option value="Repair" {{ request('category') === 'Repair' ? 'selected' : '' }}>Repair</option>
                <option value="Replacement" {{ request('category') === 'Replacement' ? 'selected' : '' }}>Replacement</option>
                <option value="Maintenance" {{ request('category') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            
                </form>
            </div>
            
        </div>
    </div>

    <!-- Service Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-600">{{ $service->category }}</span>
                        </div>
                        <button 
                            @click="toggleServiceStatus({{ $service->id }})"
                            class="{{ $service->is_active ? 'text-green-600' : 'text-gray-400' }} hover:scale-110 transition-transform">
                            @if($service->is_active)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.7m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17.294 15M10 14l4.724-2.013a1.998 1.998 0 011.789 2.894l-3.5 7A2 2 0 0111.264 21h-4.017a2 2 0 01-.485-.06l-3.76-.7"></path>
                                </svg>
                            @endif
                        </button>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $service->description }}</p>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Device:</span>
                            <span class="text-sm font-medium">{{ $service->device_type }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Price:</span>
                            <span class="text-sm font-medium text-green-600">${{ number_format($service->price, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Duration:</span>
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $service->estimated_time }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="" 
                               class="text-blue-600 hover:text-blue-800 transition-colors"
                               title="Edit Service">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <button 
                                @click="deleteService({{ $service->id }}, '{{ $service->name }}')"
                                class="text-red-600 hover:text-red-800 transition-colors"
                                title="Delete Service">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No services found</h3>
                <p class="text-gray-500 mb-4">Get started by creating your first service.</p>
                <a href="" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Add Service
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    {{-- @if($services->hasPages())
        <div class="flex justify-center">
            {{ $services->appends(request()->query())->links() }}
        </div>
    @endif --}}

    {{-- Hiển thị UI pagination giả nếu cần --}}
<div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500 text-center">
    Page 1 / 1
</div>


    <!-- Service Categories Summary -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Category Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categoryStats as $category => $stats)
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-medium text-gray-900">{{ $category }}</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-500">{{ $stats['active'] }} active</p>
                </div>
            @endforeach
        </div>
    </div>
    

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         style="display: none;"
         @click.self="showDeleteModal = false">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">
                Are you sure you want to delete the service <strong x-text="serviceToDelete.name"></strong>? 
                This action cannot be undone.
            </p>
            <div class="flex justify-end space-x-2">
                <button @click="showDeleteModal = false" 
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button @click="confirmDelete()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function serviceManagement() {
    return {
        showDeleteModal: false,
        serviceToDelete: null,
        searchTerm: '{{ request("search") }}',

        async toggleServiceStatus(serviceId) {
            try {
                const response = await fetch(`/${serviceId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error toggling service status:', error);
            }
        },

        deleteService(serviceId, serviceName) {
            this.serviceToDelete = { id: serviceId, name: serviceName };
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await fetch(`/${this.serviceToDelete.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    this.showDeleteModal = false;
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error deleting service:', error);
            }
        },

        search() {
            const url = new URL(window.location);
            if (this.searchTerm) {
                url.searchParams.set('search', this.searchTerm);
            } else {
                url.searchParams.delete('search');
            }
            window.history.pushState({}, '', url);
        }
    }
}
</script>
@endsection
