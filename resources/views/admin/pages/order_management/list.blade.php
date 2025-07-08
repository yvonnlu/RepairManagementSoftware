@extends('admin.layout.app')

@section('title', 'Order Management')

@section('content')
@php
use Illuminate\Support\Collection;

$orders = $orders ?? collect([
(object)[
'id' => 1,
'order_number' => '1001',
'created_at' => now()->subDays(2),
'customer' => (object)[
'name' => 'Nguyen Van A',
'phone' => '0912345678'
],
'device_brand' => 'Apple',
'device_model' => 'iPhone 13',
'device_type' => 'smartphone',
'device_color' => 'Black',
'device_imei' => '123456789012345',
'issue_description' => 'Battery draining fast',
'services' => 'Battery Replacement',
'technician' => (object)[
'name' => 'Tech John'
],
'technician_name' => 'Tech John',
'status' => 'repairing',
'status_label' => 'Repairing',
'status_color' => 'bg-yellow-100 text-yellow-800',
'priority' => 'high',
'priority_label' => 'High',
'priority_color' => 'text-red-600',
'estimated_time' => '2 days',
'estimated_completion' => now()->addDays(2)->format('M d, Y'),
'total_price' => 120.00,
'notes' => 'Customer requested fast service'
],
(object)[
'id' => 2,
'order_number' => '1002',
'created_at' => now()->subDay(),
'customer' => (object)[
'name' => 'Tran Thi B',
'phone' => '0987654321'
],
'device_brand' => 'Samsung',
'device_model' => 'Galaxy Tab S7',
'device_type' => 'tablet',
'device_color' => 'Silver',
'device_imei' => '987654321098765',
'issue_description' => 'Screen cracked',
'services' => 'Screen Replacement',
'technician' => (object)[
'name' => 'Tech Mary'
],
'technician_name' => 'Tech Mary',
'status' => 'pending',
'status_label' => 'Pending',
'status_color' => 'bg-gray-100 text-gray-800',
'priority' => 'medium',
'priority_label' => 'Medium',
'priority_color' => 'text-yellow-500',
'estimated_time' => '3 days',
'estimated_completion' => now()->addDays(3)->format('M d, Y'),
'total_price' => 180.00,
'notes' => 'Awaiting customer approval'
],
(object)[
'id' => 3,
'order_number' => '1003',
'created_at' => now(),
'customer' => (object)[
'name' => 'Le Van C',
'phone' => '0909090909'
],
'device_brand' => 'Dell',
'device_model' => 'XPS 13',
'device_type' => 'laptop',
'device_color' => 'Gray',
'device_imei' => '112233445566778',
'issue_description' => 'Won’t boot up',
'services' => 'Diagnostic Service',
'technician' => null, // Unassigned
'technician_name' => null,
'status' => 'diagnosing',
'status_label' => 'Diagnosing',
'status_color' => 'bg-blue-100 text-blue-800',
'priority' => 'low',
'priority_label' => 'Low',
'priority_color' => 'text-gray-500',
'estimated_time' => '5 days',
'estimated_completion' => now()->addDays(5)->format('M d, Y'),
'total_price' => 75.00,
'notes' => 'Needs deep diagnostics'
],
]);

@endphp
<div class="space-y-6" x-data="orderManagement()">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Order Management</h1>
        <div class="flex items-center space-x-2">
            <a href=""
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Create Order
            </a>
        </div>
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
                        placeholder="Search by name, phone, order ID..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                        value="{{ request('search') }}"
                        x-model="searchTerm"
                        @input.debounce.300ms="search()" />
                </form>
            </div>
            <div class="flex items-center space-x-2">
                <form method="GET" action="" class="flex items-center space-x-2">
                    <input type="hidden" name="search" :value="searchTerm">
                    <select name="status"
                        onchange="this.form.submit()"
                        class="px-4 py-2 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diagnosing" {{ request('status') === 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                        <option value="repairing" {{ request('status') === 'repairing' ? 'selected' : '' }}>Repairing</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <select name="priority"
                        onchange="this.form.submit()"
                        class="px-4 py-2 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                    <button type="button"
                        @click="showFilters = !showFilters"
                        class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span>More Filters</span>
                    </button>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Device
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Priority
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Technician
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Value
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->device_brand }} {{ $order->device_model }}</div>
                            <div class="text-sm text-gray-500">{{ $order->device_type }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $order->status_color }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 {{ $order->priority_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium {{ $order->priority_color }}">
                                    {{ $order->priority_label }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->technician->name ?? 'Unassigned' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${{ number_format($order->total_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="viewOrderDetails({{ $order->id }})"
                                    class="text-blue-600 hover:text-blue-800"
                                    title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <a href=""
                                    class="text-green-600 hover:text-green-800"
                                    title="Edit Order">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
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
        {{-- @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif --}}
    <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500 text-center">
        Page 1 / 1
    </div>
</div>

<!-- Order Details Modal -->
<div x-show="showModal"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="display: none;"
    @click.self="showModal = false">
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Order Details <span x-text="selectedOrder ? '#' + selectedOrder.order_number : ''"></span></h2>
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
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium" x-text="selectedOrder.customer_name"></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span x-text="selectedOrder.customer_phone"></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
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
                                <div><strong>Type:</strong> <span x-text="selectedOrder.device_brand + ' ' + selectedOrder.device_model"></span></div>
                                <div><strong>Color:</strong> <span x-text="selectedOrder.device_color"></span></div>
                                <div><strong>IMEI:</strong> <span x-text="selectedOrder.device_imei"></span></div>
                                <div><strong>Issue:</strong> <span x-text="selectedOrder.issue_description"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Service Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="space-y-2">
                                <div><strong>Services:</strong> <span x-text="selectedOrder.services"></span></div>
                                <div><strong>Technician:</strong> <span x-text="selectedOrder.technician_name || 'Unassigned'"></span></div>
                                <div><strong>Estimated Time:</strong> <span x-text="selectedOrder.estimated_time"></span></div>
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
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Created: <span x-text="selectedOrder.created_at"></span></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Estimated Completion: <span x-text="selectedOrder.estimated_completion"></span></span>
                                </div>
                                <div><strong>Total Cost:</strong> $<span x-text="selectedOrder.total_price"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Notes -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Notes</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700" x-text="selectedOrder ? selectedOrder.notes : ''"></p>
                </div>
            </div>

            <!-- Status Update -->
            <div class="mt-6 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Update Status:</span>
                    <select x-model="newStatus"
                        class="px-3 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="pending">Pending</option>
                        <option value="diagnosing">Diagnosing</option>
                        <option value="repairing">Repairing</option>
                        <option value="completed">Completed</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
                <button @click="updateOrderStatus()"
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
            showFilters: false,
            selectedOrder: null,
            newStatus: '',
            searchTerm: '{{ request("search") }}',

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