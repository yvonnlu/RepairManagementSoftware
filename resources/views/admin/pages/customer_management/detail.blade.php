@extends('admin.layout.app')

@section('content')
    <x-alert max-width="max-w-3xl" />

    <div class="max-w-3xl mx-auto mt-8 bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold mb-6">User Detail</h1>
        <div class="mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-medium text-xl">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">{{ $customer->name }}</h2>
                    <p class="text-gray-500">Role: <span class="font-semibold">{{ ucfirst($customer->role) }}</span></p>
                    <p class="text-gray-500">Email: {{ $customer->email }}</p>
                    @if ($customer->phone ?? false)
                        <p class="text-gray-500">Phone: {{ $customer->phone }}</p>
                    @endif
                    <p class="text-gray-500">Created at: {{ $customer->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-bold mb-2">Orders ({{ $customer->orders->count() }})</h3>
            @forelse ($customer->orders as $order)
                <div class="mb-8 bg-gray-50 p-6 rounded-lg border">
                    <!-- Order Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Order #{{ $order->id }}</h4>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>

                            <!-- Service Step Dropdown -->
                            <form method="POST" action="{{ route('admin.order.updateServiceStep', $order->id) }}"
                                class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="service_step" onchange="this.form.submit()"
                                    class="text-xs border border-blue-300 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-800 font-semibold rounded-full px-3 py-1 shadow-sm hover:shadow-md transition-all duration-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                                    <option value="New Order"
                                        {{ ($order->service_step ?? 'New Order') == 'New Order' ? 'selected' : '' }}>📋 New
                                        Order
                                    </option>
                                    <option value="Diagnosing"
                                        {{ ($order->service_step ?? '') == 'Diagnosing' ? 'selected' : '' }}>
                                        🔍 Diagnosing</option>
                                    <option value="Completed"
                                        {{ ($order->service_step ?? '') == 'Completed' ? 'selected' : '' }}>
                                        ✅ Completed</option>
                                    <option value="Cancelled"
                                        {{ ($order->service_step ?? '') == 'Cancelled' ? 'selected' : '' }}>
                                        ❌ Cancelled</option>
                                </select>
                            </form>

                            <!-- Payment Status Dropdown -->
                            <form method="POST" action="{{ route('admin.order.updatePaymentStatus', $order->id) }}"
                                class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs border border-green-300 bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 font-semibold rounded-full px-3 py-1 shadow-sm hover:shadow-md transition-all duration-200 focus:ring-2 focus:ring-green-200 focus:border-green-500">
                                    <option value="pending"
                                        {{ ($order->status ?? 'pending') == 'pending' ? 'selected' : '' }}>💳 Unpaid
                                    </option>
                                    <option value="success" {{ ($order->status ?? '') == 'success' ? 'selected' : '' }}>✅
                                        Paid</option>
                                </select>
                            </form>

                            <span class="font-bold text-green-600">
                                {{ $order->total ? '$' . number_format($order->total, 2) : '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    @if ($order->orderItems && $order->orderItems->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item ID</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Device Type</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Issue Category</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Notes</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Qty</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <!-- Order Item ID -->
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $item->id }}
                                            </td>

                                            <!-- Device Type -->
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                @if ($item->custom_device_type)
                                                    {{ $item->custom_device_type }}
                                                @elseif($item->service && $item->service->device_type_name)
                                                    {{ $item->service->device_type_name }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!-- Issue Category -->
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                @if ($item->custom_issue_category)
                                                    {{ $item->custom_issue_category }}
                                                @elseif($item->service && $item->service->issue_category_name)
                                                    {{ $item->service->issue_category_name }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!-- Description -->
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                @if ($item->custom_description)
                                                    {{ $item->custom_description }}
                                                @elseif($item->service && $item->service->description)
                                                    {{ $item->service->description }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!-- Notes -->
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                @if ($item->service)
                                                    {{ $order->note ?? '-' }}
                                                @else
                                                    {{ $item->custom_note ?? '-' }}
                                                @endif
                                            </td>

                                            <!-- Quantity -->
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->qty ?? ($item->quantity ?? 1) }}
                                            </td>

                                            <!-- Price -->
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->price ? '$' . number_format($item->price, 2) : '-' }}
                                            </td>

                                            <!-- Total -->
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->total ? '$' . number_format($item->total, 2) : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Order Summary -->
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-medium ml-1">{{ $order->orderPaymentMethod->payment_method ?? '-' }}</span>
                        </div>
                        @if ($order->orderPaymentMethod && $order->orderPaymentMethod->transaction_id)
                            <div>
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-medium ml-1">{{ $order->orderPaymentMethod->transaction_id }}</span>
                            </div>
                        @endif
                        @if ($order->note && !$order->orderItems->where('service_id', '!=', null)->count())
                            <div class="col-span-2">
                                <span class="text-gray-600">Order Notes:</span>
                                <span class="font-medium ml-1">{{ $order->note }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <p>No orders found for this customer.</p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('admin.customer.index') }}"
            class="inline-block mt-4 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Back to List</a>
    </div>
@endsection
