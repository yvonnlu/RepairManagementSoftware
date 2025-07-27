@extends('admin.layout.app')

@section('content')
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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Service Step</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Payment Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($customer->orders as $order)
                            <tr>
                                <td class="px-4 py-2">{{ $order->id }}</td>
                                <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">{{ $order->service_step ?? 'New Order' }}</td>
                                <td class="px-4 py-2">{{ $order->orderPaymentMethod->payment_method ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $order->status ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $order->total ? '$' . number_format($order->total, 2) : '-' }}
                                </td>
                                <td class="px-4 py-2">{{ $order->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('admin.customer.index') }}"
            class="inline-block mt-4 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Back to List</a>
    </div>
@endsection
