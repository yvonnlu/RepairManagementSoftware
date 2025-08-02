@extends('client.layout.layout')

@section('sidebar')
    @include('client.blocks.sidebar')
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Order History
                        </h1>
                        <p class="text-gray-600 mt-2">Track your repair service orders and their progress</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-indigo-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    📅 Order Date
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    📱 Device
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    🔧 Issue
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    ⚙️ Service Step
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    💳 Payment Status
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    💰 Price
                                </th>
                            </tr>
                                </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($orderList as $order)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 transform hover:scale-[1.01]">
                                    <td class="px-6 py-4">
                                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ $order['stt'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900">{{ $order['updated_at']->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $order['device_type_name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-red-500 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $order['issue_category_name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $step = $order['service_step'];
                                            $badgeClass = 'px-3 py-2 inline-flex text-xs leading-5 font-bold rounded-lg shadow-sm ';
                                            if ($step === 'pending' || $step === 'Pending' || $step === 'Not Started') {
                                                $badgeClass .= 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                            } elseif ($step === 'in_progress' || $step === 'In Progress' || $step === 'diagnosing') {
                                                $badgeClass .= 'bg-blue-100 text-blue-800 border border-blue-200';
                                            } elseif ($step === 'repairing') {
                                                $badgeClass .= 'bg-purple-100 text-purple-800 border border-purple-200';
                                            } elseif ($step === 'testing') {
                                                $badgeClass .= 'bg-indigo-100 text-indigo-800 border border-indigo-200';
                                            } elseif ($step === 'completed' || $step === 'Completed' || $step === 'ready_for_pickup') {
                                                $badgeClass .= 'bg-green-100 text-green-800 border border-green-200';
                                            } elseif ($step === 'cancelled' || $step === 'Cancelled') {
                                                $badgeClass .= 'bg-red-100 text-red-800 border border-red-200';
                                            } else {
                                                $badgeClass .= 'bg-gray-100 text-gray-800 border border-gray-200';
                                            }
                                        @endphp
                                        <span class="{{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $step)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $status = $order['payment_status'];
                                            $statusBadgeClass = 'px-3 py-2 inline-flex text-xs leading-5 font-bold rounded-lg shadow-sm ';
                                            if ($status === 'pending' || $status === 'Pending') {
                                                $statusBadgeClass .= 'bg-orange-100 text-orange-800 border border-orange-200';
                                            } elseif ($status === 'paid' || $status === 'Paid') {
                                                $statusBadgeClass .= 'bg-emerald-100 text-emerald-800 border border-emerald-200';
                                            } elseif ($status === 'failed' || $status === 'Failed') {
                                                $statusBadgeClass .= 'bg-red-100 text-red-800 border border-red-200';
                                            } elseif ($status === 'refunded' || $status === 'Refunded') {
                                                $statusBadgeClass .= 'bg-pink-100 text-pink-800 border border-pink-200';
                                            } else {
                                                $statusBadgeClass .= 'bg-gray-100 text-gray-800 border border-gray-200';
                                            }
                                        @endphp
                                        <span class="{{ $statusBadgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-lg font-bold text-gray-900">
                                                ${{ number_format($order['total'], 2) }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
