@extends('admin.layout.app')

@section('content')
@php
    $timeRange = request('time_range', '7d');
    
    $stats = [
        [
            'title' => 'Total Revenue',
            'value' => '$24,580',
            'change' => '+12.5%',
            'trend' => 'up',
            'icon' => 'dollar-sign',
            'color' => 'text-green-600',
            'bg' => 'bg-green-50',
            'description' => 'vs last period'
        ],
        [
            'title' => 'Active Orders',
            'value' => '47',
            'change' => '+8',
            'trend' => 'up',
            'icon' => 'shopping-cart',
            'color' => 'text-blue-600',
            'bg' => 'bg-blue-50',
            'description' => 'currently in progress'
        ],
        [
            'title' => 'Completed Today',
            'value' => '23',
            'change' => '+15%',
            'trend' => 'up',
            'icon' => 'check-circle',
            'color' => 'text-green-600',
            'bg' => 'bg-green-50',
            'description' => 'vs yesterday'
        ],
        [
            'title' => 'Customer Satisfaction',
            'value' => '4.8',
            'change' => '+0.2',
            'trend' => 'up',
            'icon' => 'star',
            'color' => 'text-yellow-600',
            'bg' => 'bg-yellow-50',
            'description' => 'average rating'
        ],
        [
            'title' => 'Avg Repair Time',
            'value' => '2.4h',
            'change' => '-15min',
            'trend' => 'up',
            'icon' => 'clock',
            'color' => 'text-purple-600',
            'bg' => 'bg-purple-50',
            'description' => 'faster than target'
        ],
        [
            'title' => 'Parts Inventory',
            'value' => '89%',
            'change' => '-5%',
            'trend' => 'down',
            'icon' => 'package',
            'color' => 'text-orange-600',
            'bg' => 'bg-orange-50',
            'description' => 'stock level'
        ]
    ];

    $recentOrders = [
        [
            'id' => 'RO-2024-047',
            'customer' => 'John Smith',
            'device' => 'iPhone 14 Pro',
            'issue' => 'Screen Replacement',
            'status' => 'In Progress',
            'technician' => 'David Wilson',
            'priority' => 'High',
            'time' => '2 hours ago',
            'estimatedCompletion' => '4:30 PM'
        ],
        [
            'id' => 'RO-2024-046',
            'customer' => 'Sarah Johnson',
            'device' => 'Samsung Galaxy S23',
            'issue' => 'Battery Replacement',
            'status' => 'Quality Check',
            'technician' => 'Michael Chen',
            'priority' => 'Normal',
            'time' => '1 hour ago',
            'estimatedCompletion' => '3:00 PM'
        ],
        [
            'id' => 'RO-2024-045',
            'customer' => 'TechCorp Solutions',
            'device' => 'MacBook Pro 2023',
            'issue' => 'Keyboard Repair',
            'status' => 'Completed',
            'technician' => 'Emily Rodriguez',
            'priority' => 'Normal',
            'time' => '30 minutes ago',
            'estimatedCompletion' => 'Completed'
        ],
        [
            'id' => 'RO-2024-044',
            'customer' => 'Mike Davis',
            'device' => 'iPad Air',
            'issue' => 'Water Damage',
            'status' => 'Awaiting Parts',
            'technician' => 'David Wilson',
            'priority' => 'Urgent',
            'time' => '15 minutes ago',
            'estimatedCompletion' => 'TBD'
        ]
    ];

    $technicianPerformance = [
        [
            'name' => 'David Wilson',
            'repairs' => 23,
            'rating' => 4.9,
            'efficiency' => 98,
            'status' => 'busy'
        ],
        [
            'name' => 'Michael Chen',
            'repairs' => 18,
            'rating' => 4.7,
            'efficiency' => 95,
            'status' => 'available'
        ],
        [
            'name' => 'Emily Rodriguez',
            'repairs' => 15,
            'rating' => 4.8,
            'efficiency' => 97,
            'status' => 'available'
        ],
        [
            'name' => 'Alex Thompson',
            'repairs' => 12,
            'rating' => 4.6,
            'efficiency' => 92,
            'status' => 'break'
        ]
    ];

    $lowStockItems = [
        [
            'name' => 'iPhone 14 Screen',
            'current' => 3,
            'minimum' => 5,
            'urgency' => 'high'
        ],
        [
            'name' => 'Samsung S23 Battery',
            'current' => 2,
            'minimum' => 3,
            'urgency' => 'medium'
        ],
        [
            'name' => 'MacBook Keyboard',
            'current' => 1,
            'minimum' => 2,
            'urgency' => 'high'
        ],
        [
            'name' => 'iPad Charging Port',
            'current' => 4,
            'minimum' => 5,
            'urgency' => 'low'
        ]
    ];

    function getStatusColor($status) {
        switch (strtolower($status)) {
            case 'completed':
                return 'bg-green-100 text-green-800';
            case 'in progress':
                return 'bg-blue-100 text-blue-800';
            case 'quality check':
                return 'bg-purple-100 text-purple-800';
            case 'awaiting parts':
                return 'bg-yellow-100 text-yellow-800';
            case 'cancelled':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    function getPriorityColor($priority) {
        switch (strtolower($priority)) {
            case 'urgent':
                return 'text-red-600';
            case 'high':
                return 'text-orange-600';
            case 'normal':
                return 'text-green-600';
            case 'low':
                return 'text-gray-600';
            default:
                return 'text-gray-600';
        }
    }

    function getUrgencyColor($urgency) {
        switch ($urgency) {
            case 'high':
                return 'bg-red-100 text-red-800';
            case 'medium':
                return 'bg-yellow-100 text-yellow-800';
            case 'low':
                return 'bg-green-100 text-green-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    function getTechStatusColor($status) {
        switch ($status) {
            case 'busy':
                return 'bg-red-500';
            case 'available':
                return 'bg-green-500';
            default:
                return 'bg-yellow-500';
        }
    }
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back! Here's what's happening at your repair shop.</p>
        </div>
        <div class="flex items-center space-x-3">
            <form method="GET" action="{{ route('dashboard') }}" class="inline">
                <select name="time_range" onchange="this.form.submit()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="24h" {{ $timeRange === '24h' ? 'selected' : '' }}>Last 24 Hours</option>
                    <option value="7d" {{ $timeRange === '7d' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30d" {{ $timeRange === '30d' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90d" {{ $timeRange === '90d' ? 'selected' : '' }}>Last 90 Days</option>
                </select>
            </form>
            <a href="" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>Generate Report</span>
            </a>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        @foreach($stats as $stat)
            <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-lg {{ $stat['bg'] }} flex items-center justify-center">
                        {{-- @include('components.icons.' . $stat['icon'], ['class' => 'w-6 h-6 ' . $stat['color']]) --}}
                    </div>
                    <div class="flex items-center space-x-1 text-sm {{ $stat['trend'] === 'up' ? 'text-green-600' : 'text-red-600' }}">
                        @if($stat['trend'] === 'up')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        @endif
                        <span>{{ $stat['change'] }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stat['value'] }}</p>
                    <p class="text-sm text-gray-600">{{ $stat['title'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stat['description'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                    <a href="" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device & Issue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ETA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $order['id'] }}</div>
                                        <div class="text-xs font-medium {{ getPriorityColor($order['priority']) }}">
                                            {{ $order['priority'] }} Priority
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order['customer'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $order['time'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order['device'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $order['issue'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ getStatusColor($order['status']) }}">
                                        {{ $order['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order['technician'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order['estimatedCompletion'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Technician Performance -->
        <div class="bg-white rounded-xl shadow-sm border">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Technician Performance</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($technicianPerformance as $tech)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 rounded-full {{ getTechStatusColor($tech['status']) }}"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $tech['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $tech['repairs'] }} repairs this week</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-xs text-gray-600">{{ $tech['rating'] }}</span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $tech['efficiency'] }}% efficiency</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Low Stock Alert -->
        <div class="bg-white rounded-xl shadow-sm border">
            <div class="p-6 border-b">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-900">Low Stock Alert</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($lowStockItems as $item)
                        <div class="flex items-center justify-between p-3 border rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $item['current'] }} in stock (min: {{ $item['minimum'] }})
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ getUrgencyColor($item['urgency']) }}">
                                {{ $item['urgency'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <a href="" 
                   class="w-full mt-4 bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 transition-colors block text-center">
                    Reorder Parts
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-3">
                    <a href="" 
                       class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors group block text-center">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-blue-600">New Order</p>
                    </a>
                    <a href="" 
                       class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors group block text-center">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-green-600">Add Customer</p>
                    </a>
                    <a href="" 
                       class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors group block text-center">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-purple-600">Schedule</p>
                    </a>
                    <a href="" 
                       class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition-colors group block text-center">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-orange-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-orange-600">Inventory</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart Placeholder -->
    <div class="bg-white rounded-xl shadow-sm border">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Revenue Overview</h2>
                <div class="flex items-center space-x-2">
                    <a href="?chart_view=daily" class="text-sm text-gray-600 hover:text-gray-800 {{ request('chart_view') === 'daily' ? 'font-medium text-blue-600' : '' }}">Daily</a>
                    <a href="?chart_view=weekly" class="text-sm {{ request('chart_view', 'weekly') === 'weekly' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-800' }}">Weekly</a>
                    <a href="?chart_view=monthly" class="text-sm text-gray-600 hover:text-gray-800 {{ request('chart_view') === 'monthly' ? 'font-medium text-blue-600' : '' }}">Monthly</a>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="h-64 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <p class="text-gray-500">Revenue chart will be displayed here</p>
                    <p class="text-sm text-gray-400">Integration with charting library needed</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
