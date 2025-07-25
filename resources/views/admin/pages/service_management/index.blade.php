@extends('admin.layout.app')

@section('content')
    <div class="space-y-6" x-data="serviceManagement()">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Service Management</h1>
            <a href="{{ route('admin.service.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Service</span>
            </a>
        </div>

        <!-- Modal Success Notification -->
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


        <!-- Search and Filter -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="relative flex-1 md:max-w-md">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <form method="GET" action="">
                        <input type="text" name="search" placeholder="Search services..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                            value="{{ request('search') }}" x-model="searchTerm" @input.debounce.300ms="search()" />
                    </form>
                </div>
                <div class="flex items-center space-x-2">
                    <form method="GET" action="{{ route('admin.service.index') }}" class="flex items-center space-x-2">
                        <input type="hidden" name="search" :value="searchTerm">
                        <select name="device_type_name" onchange="this.form.submit()"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach ($deviceTypes as $type)
                                <option value="{{ $type->device_type_name }}"
                                    {{ request('device_type_name') == $type->device_type_name ? 'selected' : '' }}>
                                    {{ $type->device_type_name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <select name="device_type" onchange="this.form.submit()"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Devices</option>
                            @foreach ($deviceTypes as $deviceType)
                                <option value="{{ $deviceType }}"
                                    {{ request('device_type') === $deviceType ? 'selected' : '' }}>
                                    {{ $deviceType }}
                                </option>
                            @endforeach
                        </select> --}}
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
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium text-blue-600">{{ $service->device_type_name }}</span>
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $service->issue_category_name }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ $service->description }}</p>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Device:</span>
                                <span class="text-sm font-medium">{{ $service->device_type_name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Price:</span>
                                <span
                                    class="text-sm font-medium text-green-600">${{ number_format($service->base_price, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Duration:</span>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">2-3 days</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.service.detail',['service' => $service->id]) }}" class="text-blue-600 hover:text-blue-800 transition-colors"
                                    title="Edit Service">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <button
                                    @click="deleteService({{ $service->device_type_name }}, '{{ $service->device_type_name }}')"
                                    class="text-red-600 hover:text-red-800 transition-colors" title="Delete Service">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No services found</h3>
                    <p class="text-gray-500 mb-4">Get started by creating your first service.</p>
                    <a href="{{ route('admin.service.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Service
                </div>
            @endforelse

            </a>
        </div>

        <!-- Pagination -->
        {{-- @if ($services->hasPages())
        <div class="flex justify-center">
            {{ $services->appends(request()->query())->links() }}
</div>
@endif --}}



        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;"
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
                searchTerm: '{{ request('
                                            search ') }}',

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
                    this.serviceToDelete = {
                        id: serviceId,
                        name: serviceName
                    };
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




{{--
    <!-- Service Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($datas as $data)
        <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow relative">
            <div class="p-6 pb-12">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="text-sm font-medium text-blue-600">{{ $data->device_type_name }}</span>
</div>
</div>

<h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $data->issue_category_name }}</h3>
<p class="text-sm text-gray-600 mb-4">{{ $data->description }}</p>

<div class="space-y-2 mb-4">
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-500">Device:</span>
        <span class="text-sm font-medium">{{ $data->device_type_name }}</span>
    </div>
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-500">Price:</span>
        <span class="text-sm font-medium text-green-600">${{ number_format($data->base_price, 2) }}</span>
    </div>
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-500">Duration:</span>
        <div class="flex items-center space-x-1">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">2-3 days</span>
        </div>
    </div>
</div>
</div>
<div class="absolute bottom-3 right-3 flex gap-2">
    <a href=" " class="text-blue-500 hover:text-blue-700" title="Edit">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
    </a>
    <button class="text-red-500 hover:text-red-700" title="Delete" @click="deleteService({{ $data->id }}, '{{ $data->issue_category_name }}')">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2" />
        </svg>
    </button>
</div>
</div>
@empty
<!-- empty state UI -->
@endforelse --}}
