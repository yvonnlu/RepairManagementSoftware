@extends('admin.layout.app')

@section('title', 'Create Order')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-8 px-4">
        <div class="max-w-3xl mx-auto">
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.order.index') }}"
                    class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors duration-200 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium">Back to Orders</span>
                </a>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Create New Order</h1>
                <p class="text-slate-600">Fill in the details to create a new order for a customer</p>
            </div>

            {{-- Main Content Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-green-600 to-blue-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white">Order Information</h2>
                    <p class="text-green-100 mt-1">Enter order details and customer information</p>
                </div>

                {{-- Notifications --}}
                <x-alert style="card" />

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.order.store') }}" class="p-8 space-y-8">
                    @csrf

                    {{-- Customer Information Section --}}
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-200 pb-2">Customer Information
                        </h3>

                        {{-- Customer Selection Field --}}
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-slate-700 font-semibold">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Select Customer *
                            </label>
                            <div class="relative">
                                <select name="user_id" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-slate-700 font-medium">
                                    <option value="">Choose a customer...</option>
                                    {{-- Recent customers (last 7 days) --}}
                                    @if ($recentCustomers->count() > 0)
                                        <optgroup label="📅 New Customers (Last 7 days)">
                                            @foreach ($recentCustomers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} ({{ $customer->email }}) - Created
                                                    {{ $customer->created_at->diffForHumans() }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                    {{-- Older customers --}}
                                    @if ($olderCustomers->count() > 0)
                                        <optgroup label="👥 Existing Customers (More than 7 days)">
                                            @foreach ($olderCustomers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} ({{ $customer->email }})
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </select>
                                @error('user_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <div class="text-sm text-slate-500 mt-1">
                                    New customers (created within 7 days) are shown first
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Details Section --}}
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-200 pb-2">Order Details</h3>

                        {{-- Service Selection Field --}}
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-slate-700 font-semibold">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Select Services *
                            </label>

                            {{-- Service Type Toggle --}}
                            <div class="mb-4">
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="service_type" value="standard" checked
                                            class="text-blue-600 focus:ring-blue-500" onchange="toggleServiceType()">
                                        <span class="text-sm font-medium">Standard Services</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="service_type" value="custom"
                                            class="text-green-600 focus:ring-green-500" onchange="toggleServiceType()">
                                        <span class="text-sm font-medium">Custom Quote</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Standard Services --}}
                            <div id="standard-services"
                                class="space-y-2 max-h-60 overflow-y-auto border border-slate-300 rounded-xl p-4">
                                @foreach ($services as $service)
                                    <label
                                        class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                            class="rounded border-slate-300 text-green-600 focus:ring-green-500"
                                            data-price="{{ $service->base_price }}"
                                            {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                                        <div class="flex-1">
                                            <div class="font-medium text-slate-700">{{ $service->device_type_name }}</div>
                                            <div class="text-sm text-slate-500">{{ $service->issue_category_name }}</div>
                                            <div class="text-sm font-semibold text-green-600">
                                                ${{ number_format($service->base_price, 2) }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Custom Service Form --}}
                            <div id="custom-service" class="hidden space-y-4 border border-slate-300 rounded-xl p-4">
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <div class="flex items-center gap-2 text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium">Custom Quote Request</span>
                                    </div>
                                    <p class="text-sm text-blue-600 mt-1">Create a custom order for specific customer
                                        requirements</p>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-slate-700">Service Description *</label>
                                    <textarea name="custom_description" rows="3"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="Describe the custom service or repair needed...">{{ old('custom_description') }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Device Type</label>
                                        <select name="custom_device_type"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            <option value="">Select device type...</option>
                                            @foreach ($deviceTypes as $deviceType)
                                                <option value="{{ $deviceType }}"
                                                    {{ old('custom_device_type') == $deviceType ? 'selected' : '' }}>
                                                    {{ $deviceType }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Issue Category</label>
                                        <input type="text" name="custom_issue_category"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            placeholder="e.g., Custom Repair, Special Request..."
                                            value="{{ old('custom_issue_category') }}">
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-slate-700">Notes</label>
                                    <textarea name="custom_note" rows="2"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="Internal notes for this custom service (optional)...">{{ old('custom_note') }}</textarea>
                                    <div class="text-xs text-slate-500">Private notes for admin reference only</div>
                                </div>
                            </div>

                            @error('services')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                            @error('custom_description')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div class="text-sm text-slate-500">Select standard services or create a custom quote</div>
                        </div>

                        {{-- Total Display --}}
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-slate-700 font-semibold">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                Total Amount
                            </label>

                            {{-- Auto-calculated total for standard services --}}
                            <div id="auto-total" class="p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="text-2xl font-bold text-green-700" id="total-display">$0.00</div>
                                <div class="text-sm text-green-600">Auto-calculated based on selected services</div>
                            </div>

                            {{-- Manual total input for custom quotes --}}
                            <div id="manual-total" class="hidden space-y-3">
                                <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                    <label class="block text-sm font-medium text-blue-700 mb-2">Quote Amount *</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-500">$</span>
                                        <input type="number" step="0.01" min="0" name="manual_total"
                                            id="manual-total-input"
                                            class="w-full pl-8 pr-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0.00" value="{{ old('manual_total') }}">
                                    </div>
                                    <div class="text-sm text-blue-600 mt-2">Enter the quoted amount for this custom service
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="total" id="total-input" value="{{ old('total', 0) }}">
                        </div>

                        {{-- Service Step Field --}}
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-slate-700 font-semibold">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Service Step *
                            </label>
                            <div class="relative">
                                <select name="service_step" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-slate-700 font-medium">
                                    <option value="New Order"
                                        {{ old('service_step', 'New Order') == 'New Order' ? 'selected' : '' }}>
                                        📋 New Order
                                    </option>
                                    <option value="Diagnosing"
                                        {{ old('service_step') == 'Diagnosing' ? 'selected' : '' }}>
                                        🔍 Diagnosing
                                    </option>
                                    <option value="Completed" {{ old('service_step') == 'Completed' ? 'selected' : '' }}>
                                        ✅ Completed
                                    </option>
                                    <option value="Cancelled" {{ old('service_step') == 'Cancelled' ? 'selected' : '' }}>
                                        ❌ Cancelled
                                    </option>
                                </select>
                                @error('service_step')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Payment Status Field --}}
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-slate-700 font-semibold">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Payment Status *
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label
                                    class="flex items-center gap-3 p-4 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50">
                                    <input type="radio" name="status" value="pending"
                                        class="text-red-600 focus:ring-red-500"
                                        {{ old('status', 'pending') == 'pending' ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-medium text-slate-700">Unpaid</div>
                                        <div class="text-sm text-slate-500">Payment pending</div>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-4 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50">
                                    <input type="radio" name="status" value="success"
                                        class="text-green-600 focus:ring-green-500"
                                        {{ old('status') == 'success' ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-medium text-slate-700">Paid</div>
                                        <div class="text-sm text-slate-500">Payment completed</div>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-4 justify-end pt-6 border-t border-slate-100">
                        <a href="{{ route('admin.order.index') }}"
                            class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-8 py-3 rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeOrderForm);
        } else {
            initializeOrderForm();
        }

        function toggleServiceType() {
            const standardSelected = document.querySelector('input[name="service_type"][value="standard"]').checked;
            const standardServices = document.getElementById('standard-services');
            const customService = document.getElementById('custom-service');
            const autoTotal = document.getElementById('auto-total');
            const manualTotal = document.getElementById('manual-total');

            if (standardSelected) {
                // Show standard services
                standardServices.classList.remove('hidden');
                customService.classList.add('hidden');
                autoTotal.classList.remove('hidden');
                manualTotal.classList.add('hidden');

                // Clear custom fields
                document.querySelector('textarea[name="custom_description"]').value = '';
                document.querySelector('select[name="custom_device_type"]').value = '';
                document.querySelector('input[name="custom_issue_category"]').value = '';
                document.querySelector('textarea[name="custom_note"]').value = '';
                document.querySelector('input[name="manual_total"]').value = '';

                // Recalculate standard total
                calculateTotal();
            } else {
                // Show custom service
                standardServices.classList.add('hidden');
                customService.classList.remove('hidden');
                autoTotal.classList.add('hidden');
                manualTotal.classList.remove('hidden');

                // Clear standard selections
                document.querySelectorAll('input[name="services[]"]').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Set total to manual input
                updateTotalFromManual();
            }
        }

        function updateTotalFromManual() {
            const manualInput = document.getElementById('manual-total-input');
            const totalInput = document.getElementById('total-input');

            if (manualInput && totalInput) {
                const manualValue = parseFloat(manualInput.value) || 0;
                totalInput.value = manualValue.toFixed(2);
            }
        }

        function initializeOrderForm() {
            console.log('Initializing order form...');

            const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
            const totalDisplay = document.getElementById('total-display');
            const totalInput = document.getElementById('total-input');
            const manualTotalInput = document.getElementById('manual-total-input');

            console.log('Found elements:');
            console.log('- Service checkboxes:', serviceCheckboxes.length);
            console.log('- Total display:', totalDisplay ? 'Found' : 'Not found');
            console.log('- Total input:', totalInput ? 'Found' : 'Not found');

            function calculateTotal() {
                // Only calculate for standard services
                const isStandardMode = document.querySelector('input[name="service_type"][value="standard"]').checked;
                if (!isStandardMode) return;

                let total = 0;
                console.log('Calculating total...');

                serviceCheckboxes.forEach(function(checkbox, index) {
                    const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                    console.log(`Service ${index + 1}: price=${price}, checked=${checkbox.checked}`);

                    if (checkbox.checked) {
                        total += price;
                    }
                });

                console.log('Final total:', total);

                if (totalDisplay) {
                    totalDisplay.textContent = '$' + total.toFixed(2);
                    console.log('Updated display to:', '$' + total.toFixed(2));
                }
                if (totalInput) {
                    totalInput.value = total.toFixed(2);
                    console.log('Updated input to:', total.toFixed(2));
                }
            }

            // Add event listeners to checkboxes
            serviceCheckboxes.forEach(function(checkbox, index) {
                const price = checkbox.getAttribute('data-price');
                console.log(`Setting up checkbox ${index + 1} with price: ${price}`);

                checkbox.addEventListener('change', function() {
                    console.log(`Checkbox ${index + 1} changed to: ${this.checked}`);
                    calculateTotal();
                });
            });

            // Add event listener to manual total input
            if (manualTotalInput) {
                manualTotalInput.addEventListener('input', updateTotalFromManual);
            }

            // Calculate initial total
            console.log('Calculating initial total...');
            calculateTotal();

            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted, validating...');

                    const isStandardMode = document.querySelector('input[name="service_type"][value="standard"]')
                        .checked;

                    if (isStandardMode) {
                        // Validate standard services
                        const selectedServices = document.querySelectorAll('input[name="services[]"]:checked');
                        if (selectedServices.length === 0) {
                            e.preventDefault();
                            alert('Please select at least one service for this order!');
                            return;
                        }
                    } else {
                        // Validate custom service
                        const customDescription = document.querySelector('textarea[name="custom_description"]')
                            .value.trim();
                        const manualTotal = document.querySelector('input[name="manual_total"]').value;

                        if (!customDescription) {
                            e.preventDefault();
                            alert('Please provide a description for the custom service!');
                            return;
                        }

                        if (!manualTotal || parseFloat(manualTotal) <= 0) {
                            e.preventDefault();
                            alert('Please enter a valid quote amount!');
                            return;
                        }
                    }

                    const customerId = document.querySelector('select[name="user_id"]').value;
                    if (!customerId) {
                        e.preventDefault();
                        alert('Please select a customer for this order!');
                        return;
                    }

                    console.log('Form validation passed');
                });
            }
        }
    </script>
@endsection
