@extends('admin.layout.app')

@section('content')
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ isset($quoteRequest) ? 'Edit' : 'Create' }} Quote Request
                </h1>
                <p class="text-gray-600">
                    {{ isset($quoteRequest) ? 'Update quote request details' : 'Add a new quote request' }}</p>
            </div>
            <a href="{{ route('admin.quote-requests.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back
            </a>
        </div>

        <div class="max-w-4xl">
            <form
                action="{{ isset($quoteRequest) ? route('admin.quote-requests.update', $quoteRequest) : route('admin.quote-requests.store') }}"
                method="POST" class="space-y-6">
                @csrf
                @if (isset($quoteRequest))
                    @method('PUT')
                @endif

                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                        Customer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $quoteRequest->name ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $quoteRequest->email ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="number" name="phone" id="phone"
                                value="{{ old('phone', $quoteRequest->phone ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="device_type" class="block text-sm font-medium text-gray-700 mb-1">Device Type
                                *</label>
                            <select name="device_type" id="device_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('device_type') border-red-500 @enderror"
                                required>
                                <option value="">Select device type</option>
                                @foreach ($deviceTypes as $deviceType)
                                    <option value="{{ $deviceType->device_type_name }}"
                                        {{ old('device_type', $quoteRequest->device_type ?? '') === $deviceType->device_type_name ? 'selected' : '' }}>
                                        {{ $deviceType->device_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('device_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Request Details -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        Request Details
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label for="issue" class="block text-sm font-medium text-gray-700 mb-1">Issue
                                Description</label>
                            <textarea name="issue" id="issue" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('issue') border-red-500 @enderror"
                                placeholder="Describe the device issue in detail...">{{ old('issue', $quoteRequest->issue ?? '') }}</textarea>
                            @error('issue')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                            Request Details
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                    required>
                                    <option value="pending"
                                        {{ old('status', $quoteRequest->status ?? 'pending') === 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="quoted"
                                        {{ old('status', $quoteRequest->status ?? '') === 'quoted' ? 'selected' : '' }}>
                                        Quoted</option>
                                    <option value="completed"
                                        {{ old('status', $quoteRequest->status ?? '') === 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="rejected"
                                        {{ old('status', $quoteRequest->status ?? '') === 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="is_existing_customer"
                                    class="block text-sm font-medium text-gray-700 mb-1">Customer Type</label>
                                <select name="is_existing_customer" id="is_existing_customer"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('is_existing_customer') border-red-500 @enderror">
                                    <option value="0"
                                        {{ old('is_existing_customer', $quoteRequest->is_existing_customer ?? false) == '0' ? 'selected' : '' }}>
                                        New Customer</option>
                                    <option value="1"
                                        {{ old('is_existing_customer', $quoteRequest->is_existing_customer ?? false) == '1' ? 'selected' : '' }}>
                                        Existing Customer</option>
                                </select>
                                @error('is_existing_customer')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                                    placeholder="Additional notes or problem description...">{{ old('notes', $quoteRequest->notes ?? '') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('admin.quote-requests.index') }}"
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            {{ isset($quoteRequest) ? 'Update' : 'Create' }} Quote Request
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
