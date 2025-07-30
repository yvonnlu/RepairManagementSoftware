@extends('admin.layout.app')

@section('title', 'Part Details - ' . $part->name)

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.inventory.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $part->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $part->device_type }} - {{ $part->issue_category }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @if ($part->current_stock <= $part->min_stock_level)
                    <button onclick="addStock()"
                        class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Stock</span>
                    </button>
                @endif
                <button onclick="deleteConfirm()"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    <span>Delete</span>
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Stock Status Alert -->
        @if ($part->current_stock <= $part->min_stock_level)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    <span class="text-yellow-800">
                        <strong>Low Stock Warning:</strong> Current stock ({{ $part->current_stock }}) is at or below
                        minimum level ({{ $part->min_stock_level }})
                    </span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>

                        <form id="updatePartForm" method="POST" action="{{ route('admin.inventory.update', $part) }}"
                            class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Part Name</label>
                                    <input type="text" name="name" value="{{ old('name', $part->name) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Device Type</label>
                                    <select name="device_type"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('device_type') border-red-500 @enderror">
                                        <option value="Smartphone"
                                            {{ old('device_type', $part->device_type) == 'Smartphone' ? 'selected' : '' }}>
                                            Smartphone</option>
                                        <option value="Tablet"
                                            {{ old('device_type', $part->device_type) == 'Tablet' ? 'selected' : '' }}>
                                            Tablet</option>
                                        <option value="Laptop"
                                            {{ old('device_type', $part->device_type) == 'Laptop' ? 'selected' : '' }}>
                                            Laptop</option>
                                        <option value="Desktop PC"
                                            {{ old('device_type', $part->device_type) == 'Desktop PC' ? 'selected' : '' }}>
                                            Desktop PC</option>
                                        <option value="Smartwatch"
                                            {{ old('device_type', $part->device_type) == 'Smartwatch' ? 'selected' : '' }}>
                                            Smartwatch</option>
                                    </select>
                                    @error('device_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Issue Category</label>
                                    <input type="text" name="issue_category"
                                        value="{{ old('issue_category', $part->issue_category) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('issue_category') border-red-500 @enderror">
                                    @error('issue_category')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" name="location" value="{{ old('location', $part->location) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $part->description) }}</textarea>
                            </div>

                            <!-- Pricing Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cost Price</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                        <input type="number" name="cost_price" step="0.01" min="0"
                                            value="{{ old('cost_price', $part->cost_price) }}"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cost_price') border-red-500 @enderror">
                                    </div>
                                    @error('cost_price')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Stock Level</label>
                                    <input type="number" name="min_stock_level" min="0"
                                        value="{{ old('min_stock_level', $part->min_stock_level) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_stock_level') border-red-500 @enderror">
                                    @error('min_stock_level')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Update Part Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stock Information -->
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Stock Information</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Current Stock</span>
                                <span class="text-lg font-bold text-gray-900">{{ $part->current_stock }} units</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Minimum Level</span>
                                <span class="text-sm text-gray-900">{{ $part->min_stock_level }} units</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Stock Status</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $part->stock_status_color }}">
                                    {{ $part->stock_status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pricing Information</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Cost Price</span>
                                <span
                                    class="text-lg font-bold text-gray-900">${{ number_format($part->cost_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Last Movement Information -->
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Last Movement</h2>

                        @if ($part->last_movement_date)
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Date:</span>
                                    <span
                                        class="text-gray-900">{{ $part->last_movement_date->format('M j, Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Type:</span>
                                    <span
                                        class="font-medium {{ $part->last_movement_type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $part->last_movement_type == 'in' ? 'Stock In (+' : 'Stock Out (-' }}{{ $part->last_movement_quantity }})
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Reason:</span>
                                    <span class="text-gray-900">{{ $part->last_movement_reason }}</span>
                                </div>
                                @if ($part->last_movement_notes)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Notes:</span>
                                        <span class="text-gray-900">{{ $part->last_movement_notes }}</span>
                                    </div>
                                @endif
                                @if ($part->last_order_id)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Order:</span>
                                        <span class="text-gray-900">#{{ $part->last_order_id }}</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No movements yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div id="addStockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Stock</h3>

            <form method="POST" action="{{ route('admin.inventory.addStock', $part) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity to Add</label>
                        <input type="number" name="quantity" min="1" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <select name="reason"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="purchase">Purchase</option>
                            <option value="adjustment">Inventory Adjustment</option>
                            <option value="return">Return</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="closeAddStockModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Add Stock
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">
                Are you sure you want to delete this part? This action cannot be undone.
            </p>

            <div class="flex justify-end space-x-2">
                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.inventory.destroy', $part) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addStock() {
            document.getElementById('addStockModal').classList.remove('hidden');
        }

        function closeAddStockModal() {
            document.getElementById('addStockModal').classList.add('hidden');
        }

        function deleteConfirm() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'addStockModal') {
                closeAddStockModal();
            }
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
