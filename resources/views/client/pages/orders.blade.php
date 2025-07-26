@extends('client.layout.layout')

@section('sidebar')
    @include('client.blocks.sidebar')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto mt-24">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order History</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($orderList as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order['stt'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order['updated_at']->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order['device_type_name'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order['issue_category_name'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order['order_step'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($order['total'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
