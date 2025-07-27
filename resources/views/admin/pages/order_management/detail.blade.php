@extends('admin.layout.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-8 bg-white rounded-lg shadow p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Order Details #{{ $order->id }}</h1>
            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('admin.order.updateServiceStep', $order->id) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <select name="service_step" onchange="this.form.submit()"
                        class="border-2 border-blue-300 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-800 font-semibold rounded-lg px-4 py-2 shadow-md hover:shadow-lg transition-all duration-200 focus:ring-4 focus:ring-blue-200 focus:border-blue-500">
                        <option value="New Order" 
                            {{ ($order->service_step ?? 'New Order') == 'New Order' ? 'selected' : '' }}>📋 New Order
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
                <a href="{{ route('admin.order.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Back to
                    Orders</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Customer Information -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
                @if ($order->user)
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <span
                                    class="text-white font-medium">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ $order->user->name }}</h3>
                                <p class="text-gray-600">{{ $order->user->email }}</p>
                            </div>
                        </div>
                        @if ($order->user->phone_number)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <span>{{ $order->user->phone_number }}</span>
                            </div>
                        @endif
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                            <span>Role: {{ ucfirst($order->user->role) }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Customer information not available</p>
                @endif
            </div>

            <!-- Order Information -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Order Information</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Updated:</span>
                        <span class="font-medium">{{ $order->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Service Step:</span>
                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium
                        @if (($order->service_step ?? 'New Order') == 'New Order') bg-blue-100 text-blue-800
                        @elseif($order->service_step == 'Diagnosing') bg-yellow-100 text-yellow-800
                        @elseif($order->service_step == 'Completed') bg-green-100 text-green-800
                        @elseif($order->service_step == 'Cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                            {{ $order->service_step ?? 'New Order' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Status:</span>
                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium
                        @if ($order->status) bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                            {{ $order->status ? 'Paid' : 'Unpaid' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="font-bold text-lg text-green-600">
                            {{ $order->total ? '$' . number_format($order->total, 2) : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        @if ($order->orderPaymentMethod)
            <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium">{{ $order->orderPaymentMethod->payment_method ?? '-' }}</span>
                    </div>
                    @if ($order->orderPaymentMethod->transaction_id)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Transaction ID:</span>
                            <span class="font-medium">{{ $order->orderPaymentMethod->transaction_id }}</span>
                        </div>
                    @endif
                    @if ($order->orderPaymentMethod->payment_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Date:</span>
                            <span
                                class="font-medium">{{ \Carbon\Carbon::parse($order->orderPaymentMethod->payment_date)->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    @if ($order->orderPaymentMethod->amount)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Amount:</span>
                            <span class="font-medium">${{ number_format($order->orderPaymentMethod->amount, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Order Items -->
        @if ($order->orderItems && $order->orderItems->count() > 0)
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->item_name ?? 'Item #' . $item->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->quantity ?? 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->price ? '$' . number_format($item->price, 2) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->total ? '$' . number_format($item->total, 2) : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Additional Order Details -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Timeline/Notes -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Order Notes</h2>
                @if ($order->notes)
                    <p class="text-gray-700">{{ $order->notes }}</p>
                @else
                    <p class="text-gray-500 italic">No notes available</p>
                @endif
            </div>

            <!-- Service Details -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Service Details</h2>
                <div class="space-y-2">
                    @if ($order->device_type)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Device Type:</span>
                            <span class="font-medium">{{ $order->device_type }}</span>
                        </div>
                    @endif
                    @if ($order->device_model)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Device Model:</span>
                            <span class="font-medium">{{ $order->device_model }}</span>
                        </div>
                    @endif
                    @if ($order->issue_description)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Issue:</span>
                            <span class="font-medium">{{ $order->issue_description }}</span>
                        </div>
                    @endif
                    @if ($order->estimated_completion)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estimated Completion:</span>
                            <span
                                class="font-medium">{{ \Carbon\Carbon::parse($order->estimated_completion)->format('d/m/Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>
@endsection
