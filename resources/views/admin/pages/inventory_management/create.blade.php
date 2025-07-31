@extends('admin.layout.app')

@section('title', 'Add New Part')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.inventory.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add New Part</h1>
                <p class="text-gray-600 mt-1">Create a new inventory part</p>
            </div>
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

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Part Information</h2>

            <form method="POST" action="{{ route('admin.inventory.store') }}" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Part Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Enter part name">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Device Type <span
                                class="text-red-500">*</span></label>
                        <select name="device_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('device_type') border-red-500 @enderror">
                            <option value="">Select device type</option>
                            <option value="Smartphone" {{ old('device_type') == 'Smartphone' ? 'selected' : '' }}>Smartphone
                            </option>
                            <option value="Tablet" {{ old('device_type') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Laptop" {{ old('device_type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Desktop PC" {{ old('device_type') == 'Desktop PC' ? 'selected' : '' }}>Desktop PC
                            </option>
                            <option value="Smartwatch" {{ old('device_type') == 'Smartwatch' ? 'selected' : '' }}>
                                Smartwatch</option>
                            @foreach ($deviceTypes as $type)
                                @if (!in_array($type, ['Smartphone', 'Tablet', 'Laptop', 'Desktop PC', 'Smartwatch']))
                                    <option value="{{ $type }}"
                                        {{ old('device_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('device_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Issue Category <span
                                class="text-red-500">*</span></label>
                        <select name="issue_category" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('issue_category') border-red-500 @enderror">
                            <option value="">Select device type first</option>
                            <!-- Options will be populated by JavaScript based on device type -->
                        </select>
                        @error('issue_category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Shelf A-1, Drawer B-3">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter part description, specifications, or notes">{{ old('description') }}</textarea>
                </div>

                <!-- Pricing & Stock Information -->
                <div class="border-t pt-6">
                    <h3 class="text-md font-medium text-gray-900 mb-4">Pricing & Stock Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cost Price <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" name="cost_price" step="0.01" min="0"
                                    value="{{ old('cost_price') }}" required
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cost_price') border-red-500 @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('cost_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Initial Stock <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="current_stock" min="0" value="{{ old('current_stock', 0) }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_stock') border-red-500 @enderror"
                                placeholder="0">
                            @error('current_stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock Level <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="min_stock_level" min="0"
                                value="{{ old('min_stock_level', 5) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_stock_level') border-red-500 @enderror"
                                placeholder="5">
                            @error('min_stock_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Alert will be triggered when stock falls below this level
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t pt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.inventory.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Part
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        // Lấy dữ liệu mapping từ controller (từ bảng services)
        const deviceTypeCategories = @json($servicesMapping ?? []);
        const oldIssueCategory = '{{ old('issue_category') }}';

        // Populate issue categories based on device type
        function populateIssueCategories(deviceType) {
            const issueCategorySelect = document.querySelector('select[name="issue_category"]');

            // Clear existing options
            issueCategorySelect.innerHTML = '';

            if (!deviceType) {
                issueCategorySelect.innerHTML = '<option value="">Select device type first</option>';
                return;
            }

            // Add default option
            issueCategorySelect.innerHTML = '<option value="">Select issue category</option>';

            // Add categories for selected device type from services table
            const categories = deviceTypeCategories[deviceType] || [];
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;

                // Restore old value if exists
                if (oldIssueCategory === category) {
                    option.selected = true;
                }

                issueCategorySelect.appendChild(option);
            });

            // Add existing categories from parts table that match this device type
            @if ($issueCategories)
                const existingCategories = @json($issueCategories);
                existingCategories.forEach(category => {
                    // Only add if not already in the predefined list
                    if (!categories.includes(category)) {
                        const option = document.createElement('option');
                        option.value = category;
                        option.textContent = category;

                        if (oldIssueCategory === category) {
                            option.selected = true;
                        }

                        issueCategorySelect.appendChild(option);
                    }
                });
            @endif
        }

        // Handle device type change
        document.addEventListener('DOMContentLoaded', function() {
            const deviceTypeSelect = document.querySelector('select[name="device_type"]');

            // Add change event listener
            deviceTypeSelect.addEventListener('change', function() {
                const deviceType = this.value;
                populateIssueCategories(deviceType);
            });

            // Initialize on page load if device type is already selected
            if (deviceTypeSelect.value) {
                populateIssueCategories(deviceTypeSelect.value);
            }
        });
    </script>
@endsection
