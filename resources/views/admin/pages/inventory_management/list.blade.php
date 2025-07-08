@extends('admin.layout.app')

@section('title', 'Inventory Management')

@section('content')
@php
$stats = $stats ?? [
'total_parts' => 8,
'total_value' => 4200.00,
'potential_revenue' => 6500.00,
'low_stock_count' => 2,
];

$lowStockParts = $lowStockParts ?? collect([
(object)['id' => 1, 'name' => 'Compressor Fan', 'stock_quantity' => 1, 'min_stock_level' => 5],
(object)['id' => 2, 'name' => 'Thermostat Sensor', 'stock_quantity' => 0, 'min_stock_level' => 3]
]);

$categories = $categories ?? ['Electrical', 'Mechanical', 'Cooling', 'Heating'];

$parts = $parts ?? collect([
(object)[
'id' => 1,
'name' => 'Cooling Fan',
'sku' => 'CF-001',
'compatible_devices_array' => ['Model A', 'Model B', 'Model C'],
'category' => 'Cooling',
'stock_quantity' => 2,
'min_stock_level' => 5,
'stock_status' => 'Low Stock',
'stock_status_color' => 'bg-red-100 text-red-800',
'cost' => 25.00,
'selling_price' => 40.00,
'profit_margin' => 60,
'supplier' => 'AC Supplier Ltd',
'supplier_part_number' => 'SP-AC-001',
'location' => 'Warehouse A',
'condition' => 'new',
'warranty' => 180,
'notes' => 'Needs to be stored in dry place'
],
(object)[
'id' => 2,
'name' => 'Heater Coil',
'sku' => 'HC-009',
'compatible_devices_array' => ['Model X'],
'category' => 'Heating',
'stock_quantity' => 12,
'min_stock_level' => 4,
'stock_status' => 'In Stock',
'stock_status_color' => 'bg-green-100 text-green-800',
'cost' => 35.00,
'selling_price' => 60.00,
'profit_margin' => 71,
'supplier' => 'HeatTech',
'supplier_part_number' => null,
'location' => 'Warehouse B',
'condition' => 'refurbished',
'warranty' => 90,
'notes' => null
]
]);
@endphp

<div class="space-y-6" x-data="inventoryManagement()">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Inventory Management</h1>
            <p class="text-gray-600 mt-1">Manage parts, track stock levels, and monitor inventory value</p>
        </div>
        <div class="flex items-center space-x-3">
            <button @click="importParts()"
                class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                <span>Import</span>
            </button>
            <a href=""
                class="bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>Export</span>
            </a>
            <a href=""
                class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Part</span>
            </a>
        </div>
    </div>

    <!-- Inventory Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Parts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_parts'] }}</p>
                </div>
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Inventory Value</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_value'], 2) }}</p>
                </div>
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Potential Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['potential_revenue'], 2) }}</p>
                </div>
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Low Stock Items</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['low_stock_count'] }}</p>
                </div>
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if($lowStockParts->count() > 0)
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-red-800">Low Stock Alert</h3>
            </div>
            <button @click="bulkReorder()"
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
                <span>Reorder All</span>
            </button>
        </div>
        <p class="text-red-700 mt-2">{{ $lowStockParts->count() }} items are running low on stock and need to be reordered.</p>
    </div>
    @endif

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
                        placeholder="Search parts by name, SKU, or supplier..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                        value="{{ request('search') }}"
                        x-model="searchTerm"
                        @input.debounce.300ms="search()" />
                </form>
            </div>
            <div class="flex items-center space-x-2">
                <form method="GET" action="" class="flex items-center space-x-2">
                    <input type="hidden" name="search" :value="searchTerm">
                    <select name="category"
                        onchange="this.form.submit()"
                        class="px-4 py-2 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                    <select name="condition"
                        onchange="this.form.submit()"
                        class="px-4 py-2 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') === 'new' ? 'selected' : '' }}>New</option>
                        <option value="refurbished" {{ request('condition') === 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                        <option value="used" {{ request('condition') === 'used' ? 'selected' : '' }}>Used</option>
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

    <!-- Parts Table -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Part Details
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stock Level
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cost
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Selling Price
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Supplier
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Location
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($parts as $part)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $part->name }}</div>
                                <div class="text-sm text-gray-500">SKU: {{ $part->sku }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ implode(', ', array_slice($part->compatible_devices_array, 0, 2)) }}
                                    @if(count($part->compatible_devices_array) > 2)
                                    +{{ count($part->compatible_devices_array) - 2 }} more
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                {{ $part->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $part->stock_quantity }} units</div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $part->stock_status_color }}">
                                    {{ $part->stock_status }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">Min: {{ $part->min_stock_level }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($part->cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${{ number_format($part->selling_price, 2) }}</div>
                            <div class="text-xs text-green-600">{{ $part->profit_margin }}% margin</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $part->supplier }}</div>
                            @if($part->supplier_part_number)
                            <div class="text-xs text-gray-500">{{ $part->supplier_part_number }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1 text-sm text-gray-900">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $part->location }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button @click="viewPartDetails({{ $part->id }})"
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
                                    title="Edit Part">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @if($part->stock_quantity <= $part->min_stock_level)
                                    <button @click="reorderPart({{ $part->id }})"
                                        class="text-orange-600 hover:text-orange-800"
                                        title="Reorder">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                        </svg>
                                    </button>
                                    @endif
                                    <button @click="deletePart({{ $part->id }}, '{{ $part->name }}')"
                                        class="text-red-600 hover:text-red-800"
                                        title="Delete Part">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No parts found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{-- @if($parts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $parts->appends(request()->query())->links() }}
    </div>
    @endif --}}
    {{-- Hiển thị UI pagination giả nếu cần --}}
    <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500 text-center">
        Trang 1 / 1
    </div>

</div>

<!-- Part Details Modal -->
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
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Part Details</h2>
            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                ×
            </button>
        </div>

        <div x-show="selectedPart" class="space-y-6">
            <template x-if="selectedPart">
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Basic Information</h3>
                            <div class="space-y-2">
                                <div><strong>Name:</strong> <span x-text="selectedPart.name"></span></div>
                                <div><strong>SKU:</strong> <span x-text="selectedPart.sku"></span></div>
                                <div><strong>Category:</strong> <span x-text="selectedPart.category"></span></div>
                                <div><strong>Condition:</strong> <span x-text="selectedPart.condition"></span></div>
                                <div><strong>Location:</strong> <span x-text="selectedPart.location"></span></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Pricing & Stock</h3>
                            <div class="space-y-2">
                                <div><strong>Cost:</strong> $<span x-text="selectedPart.cost"></span></div>
                                <div><strong>Selling Price:</strong> $<span x-text="selectedPart.selling_price"></span></div>
                                <div><strong>Current Stock:</strong> <span x-text="selectedPart.stock_quantity"></span> units</div>
                                <div><strong>Minimum Level:</strong> <span x-text="selectedPart.min_stock_level"></span> units</div>
                                <div><strong>Warranty:</strong> <span x-text="selectedPart.warranty"></span> days</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Supplier Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="space-y-2">
                                <div><strong>Supplier:</strong> <span x-text="selectedPart.supplier"></span></div>
                                <div x-show="selectedPart.supplier_part_number">
                                    <strong>Supplier Part #:</strong> <span x-text="selectedPart.supplier_part_number"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Compatible Devices</h3>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="device in selectedPart.compatible_devices_array" :key="device">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded-full" x-text="device"></span>
                            </template>
                        </div>
                    </div>

                    <div x-show="selectedPart.notes">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Notes</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700" x-text="selectedPart.notes"></p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-4">
                        <a :href="`/${selectedPart.id}`"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Part
                        </a>
                        <button x-show="selectedPart.stock_quantity <= selectedPart.min_stock_level"
                            @click="reorderPart(selectedPart.id)"
                            class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                            Reorder
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div x-show="showDeleteModal"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="display: none;"
    @click.self="showDeleteModal = false">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Deletion</h3>
        <p class="text-gray-600 mb-6">
            Are you sure you want to delete part <strong x-text="partToDelete.name"></strong>?
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
    function inventoryManagement() {
        return {
            showModal: false,
            showDeleteModal: false,
            showFilters: false,
            selectedPart: null,
            partToDelete: null,
            searchTerm: '{{ request("search") }}',

            async viewPartDetails(partId) {
                try {
                    const response = await fetch(`/${partId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.ok) {
                        this.selectedPart = await response.json();
                        this.showModal = true;
                    }
                } catch (error) {
                    console.error('Error fetching part details:', error);
                }
            },

            async reorderPart(partId) {
                try {
                    const response = await fetch(`/${partId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.ok) {
                        const result = await response.json();
                        alert(result.message || 'Reorder initiated successfully');
                    }
                } catch (error) {
                    console.error('Error initiating reorder:', error);
                }
            },

            async bulkReorder() {
                try {
                    const response = await fetch(``, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.ok) {
                        const result = await response.json();
                        alert(result.message || 'Bulk reorder initiated successfully');
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error initiating bulk reorder:', error);
                }
            },

            deletePart(partId, partName) {
                this.partToDelete = {
                    id: partId,
                    name: partName
                };
                this.showDeleteModal = true;
            },

            async confirmDelete() {
                try {
                    const response = await fetch(`/${this.partToDelete.id}`, {
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
                    console.error('Error deleting part:', error);
                }
            },

            importParts() {
                // Trigger file input or redirect to import page
                window.location.href = '';
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