@extends('admin.layout.app')

@section('title', 'Order Management')

@section('content')

    <div class="space-y-6" x-data="orderManagement()">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Order Management</h1>
            <div class="flex items-center space-x-2">
                <a href="" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Create Order
                </a>
            </div>
        </div>

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
                        <input type="text" name="search" placeholder="Search by name, phone, order ID..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                            value="{{ request('search') }}" x-model="searchTerm" @input.debounce.300ms="search()" />
                    </form>
                </div>
                <div class="flex items-center space-x-2">
                    <form method="GET" action="" class="flex items-center space-x-2">
                        <input type="hidden" name="search" :value="searchTerm">
                        <select name="status" onchange="this.form.submit()"
                            class="px-4 py-2 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Service Steps</option>
                            <option value="new_order" {{ request('status') === 'new_order' ? 'selected' : '' }}>New Order
                            </option>
                            <option value="diagnosing" {{ request('status') === 'diagnosing' ? 'selected' : '' }}>Diagnosing
                            </option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service
                                Step</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->user->email ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($order->total ?? 0, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->orderPaymentMethod->method ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @php
                                        $stepClasses = [
                                            'New Order' => 'bg-blue-100 text-blue-800',
                                            'Diagnosing' => 'bg-yellow-100 text-yellow-800',
                                            'Completed' => 'bg-green-100 text-green-800',
                                            'Cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $step = $order->service_step ?? 'New Order';
                                        $class = $stepClasses[$step] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $class }}">
                                        {{ $step }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center space-x-2">
                                        {{-- <a href="{{ route('admin.orders.edit', $order->id) }}" --}}
                                        <a href="{{ route('admin.order.detail', $order->id) }}"
                                            class="text-blue-600 hover:text-blue-800" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        {{-- <a href="{{ route('admin.orders.show', $order->id) }}" --}}
                                        {{-- <a href="" class="text-green-600 hover:text-green-800" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a> --}}
                                        {{-- <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" --}}
                                        <button @click="deleteCustomer()" class="text-red-600 hover:text-red-800"
                                            title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    No orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500 text-center">
                    Showing {{ $orders->count() }} of {{ $orders->total() }} orders
                </div>
            @endif
        </div>

        <!-- Order Details Modal -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;"
            @click.self="showModal = false">
            <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Order Details <span
                            x-text="selectedOrder ? '#' + selectedOrder.order_number : ''"></span></h2>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                        ×
                    </button>
                </div>

                <div x-show="selectedOrder" class="space-y-6">
                    <template x-if="selectedOrder">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Info -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            <span class="font-medium" x-text="selectedOrder.customer_name"></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            <span x-text="selectedOrder.customer_phone"></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span x-text="selectedOrder.customer_email"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Device Info -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Device Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <div><strong>Type:</strong> <span
                                                x-text="selectedOrder.device_brand + ' ' + selectedOrder.device_model"></span>
                                        </div>
                                        <div><strong>Color:</strong> <span x-text="selectedOrder.device_color"></span>
                                        </div>
                                        <div><strong>IMEI:</strong> <span x-text="selectedOrder.device_imei"></span></div>
                                        <div><strong>Issue:</strong> <span x-text="selectedOrder.issue_description"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Info -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Service Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <div><strong>Services:</strong> <span x-text="selectedOrder.services"></span></div>
                                        <div><strong>Technician:</strong> <span
                                                x-text="selectedOrder.technician_name || 'Unassigned'"></span></div>
                                        <div><strong>Estimated Time:</strong> <span
                                                x-text="selectedOrder.estimated_time"></span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Status -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Order Status</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full"
                                                :class="selectedOrder.status_color"
                                                x-text="selectedOrder.status_label"></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>Created: <span x-text="selectedOrder.created_at"></span></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Estimated Completion: <span
                                                    x-text="selectedOrder.estimated_completion"></span></span>
                                        </div>
                                        <div><strong>Total Cost:</strong> $<span x-text="selectedOrder.total_price"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order Step</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created At</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->user->email ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($order->total ?? 0, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($order->status)
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Đã
                                                thanh toán</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Chưa
                                                thanh toán</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->order_step ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No orders found
                                    </td>
                                </tr>
                            @endforelse
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Save Changes
                            </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function orderManagement() {
            return {
                showModal: false,
                selectedOrder: null,
                newStatus: '',
                searchTerm: '{{ request('search') }}',

                async viewOrderDetails(orderId) {
                    try {
                        const response = await fetch(`/${orderId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            this.selectedOrder = await response.json();
                            this.newStatus = this.selectedOrder.status;
                            this.showModal = true;
                        }
                    } catch (error) {
                        console.error('Error fetching order details:', error);
                    }
                },

                async updateOrderStatus() {
                    if (!this.selectedOrder || !this.newStatus) return;

                    try {
                        const response = await fetch(`/${this.selectedOrder.id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                status: this.newStatus
                            })
                        });

                        if (response.ok) {
                            this.showModal = false;
                            window.location.reload();
                        }
                    } catch (error) {
                        console.error('Error updating order status:', error);
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

                    // Giữ lại status filter nếu có
                    const statusSelect = document.querySelector('select[name="status"]');
                    if (statusSelect && statusSelect.value) {
                        const statusInput = document.createElement('input');
                        statusInput.type = 'hidden';
                        statusInput.name = 'status';
                        statusInput.value = statusSelect.value;
                        form.appendChild(statusInput);
                    }

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }
    </script>
@endsection
