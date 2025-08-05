@extends('admin.layout.app')


@section('content')
    <div class="space-y-6" x-data="customerManagement()">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Customer Management</h1>
            <a href="{{ route('admin.customer.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Customer</span>
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
                        <input type="text" name="search" placeholder="Search by name, email..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                            value="{{ request('search') }}" x-model="searchTerm" @input.debounce.300ms="search()" />
                    </form>
                </div>
            </div>
        </div>

        <!-- Customer List -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                STT
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email Address
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Orders
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deleted Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 {{ $customer->deleted_at ? 'opacity-60 bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $customers->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $customer->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $customer->orders_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $customer->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($customer->deleted_at)
                                        <span class="text-red-600">{{ $customer->deleted_at->format('d/m/Y H:i') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.customer.detail', $customer->id) }}"
                                            class="text-blue-600 hover:text-blue-800" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        @if ($customer->deleted_at)
                                            <!-- Restore button for deleted users -->
                                            <form method="POST"
                                                action="{{ route('admin.customer.restore', $customer->id) }}"
                                                class="inline" id="restore-form-{{ $customer->id }}">
                                                @csrf
                                                <button type="button"
                                                    onclick="confirmRestore('{{ $customer->name }}', function() { document.getElementById('restore-form-{{ $customer->id }}').submit(); })"
                                                    class="text-green-600 hover:text-green-800" title="Restore">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Delete button for active users -->
                                            <form method="POST"
                                                action="{{ route('admin.customer.destroy', $customer->id) }}"
                                                class="inline" id="delete-form-{{ $customer->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="confirmDelete('{{ $customer->name }}', function() { document.getElementById('delete-form-{{ $customer->id }}').submit(); })"
                                                    class="text-red-600 hover:text-red-800" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No customers found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($customers->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $customers->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500 text-center">
                    Showing {{ $customers->count() }} of {{ $customers->total() }} customers
                </div>
            @endif
        </div>

        <!-- Customer Details Modal -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;"
            @click.self="showModal = false">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Customer Details</h2>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                        ×
                    </button>
                </div>

                <div x-show="selectedCustomer" class="space-y-4">
                    <template x-if="selectedCustomer">
                        <div>
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-xl"
                                        x-text="selectedCustomer.name ? selectedCustomer.name.charAt(0).toUpperCase() : ''"></span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900" x-text="selectedCustomer.name"></h3>
                                    <p class="text-sm text-gray-500">
                                        Customer since <span x-text="selectedCustomer.created_at"></span>
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Phone Number</p>
                                        <p class="font-medium" x-text="selectedCustomer.phone"></p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="font-medium" x-text="selectedCustomer.email"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 mt-4" x-show="selectedCustomer.address">
                                <svg class="w-5 h-5 text-gray-400 mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Address</p>
                                    <p class="font-medium" x-text="selectedCustomer.address"></p>
                                </div>
                            </div>

                            <div class="border-t pt-4 mt-6">
                                <h4 class="font-semibold text-gray-900 mb-2">Statistics</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <p class="text-2xl font-bold text-blue-600"
                                            x-text="selectedCustomer.orders_count || 0"></p>
                                        <p class="text-sm text-gray-500">Total Orders</p>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <p class="text-2xl font-bold text-green-600"
                                            x-text="selectedCustomer.status === 'active' ? 'Active' : 'Inactive'"></p>
                                        <p class="text-sm text-gray-500">Status</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2 mt-6 pt-4 border-t">
                                <a :href="`/${selectedCustomer.id}`"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Edit
                                </a>
                                <button @click="showModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Close
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <!-- Modal đã bỏ vì dùng form trực tiếp với confirm() -->
    </div>

    <script>
        function customerManagement() {
            return {
                showModal: false,
                selectedCustomer: null,
                searchTerm: '{{ request('search') }}',

                async viewCustomer(customerId) {
                    try {
                        const response = await fetch(`/${customerId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            this.selectedCustomer = await response.json();
                            this.showModal = true;
                        }
                    } catch (error) {
                        console.error('Error fetching customer details:', error);
                    }
                },

                search() {
                    // Tạo form tự động submit để giữ nguyên pagination
                    const form = document.createElement('form');
                    form.method = 'GET';
                    form.action = window.location.pathname;

                    // Thêm search term
                    if (this.searchTerm) {
                        const searchInput = document.createElement('input');
                        searchInput.type = 'hidden';
                        searchInput.name = 'search';
                        searchInput.value = this.searchTerm;
                        form.appendChild(searchInput);
                    }

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }
    </script>
@endsection
