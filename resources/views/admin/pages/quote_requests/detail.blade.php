@extends('admin.layout.app')

@section('content')
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quote Request Details</h1>
                <p class="text-gray-600">Edit and manage quote request</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" form="quote-form"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Save Changes
                </button>
                <a href="{{ route('admin.quote-requests.index') }}"
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form id="quote-form" action="{{ route('admin.quote-requests.update', $quoteRequest) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            Customer Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" name="name" value="{{ old('name', $quoteRequest->name) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $quoteRequest->email) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $quoteRequest->phone) }}"
                                    placeholder="Not provided"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Device Type</label>
                                <input type="text" name="device_type"
                                    value="{{ old('device_type', $quoteRequest->device_type) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('device_type') border-red-500 @enderror">
                                @error('device_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Issue Description</label>
                                <textarea name="issue" rows="3" placeholder="No issue description provided"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('issue') border-red-500 @enderror">{{ old('issue', $quoteRequest->issue) }}</textarea>
                                @error('issue')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Customer Type</label>
                                <select name="is_existing_customer"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('is_existing_customer') border-red-500 @enderror">
                                    <option value="0"
                                        {{ old('is_existing_customer', $quoteRequest->is_existing_customer) == 0 ? 'selected' : '' }}>
                                        New Customer</option>
                                    <option value="1"
                                        {{ old('is_existing_customer', $quoteRequest->is_existing_customer) == 1 ? 'selected' : '' }}>
                                        Existing Customer</option>
                                </select>
                                @error('is_existing_customer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea name="notes" rows="3" placeholder="No additional notes provided"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes', $quoteRequest->notes) }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Request Date</label>
                                    <p class="text-gray-900">{{ $quoteRequest->created_at->format('F d, Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $quoteRequest->created_at->format('H:i') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                    <p class="text-gray-900">{{ $quoteRequest->updated_at->format('F d, Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $quoteRequest->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                                <select name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                    <option value="pending"
                                        {{ old('status', $quoteRequest->status) === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="quoted"
                                        {{ old('status', $quoteRequest->status) === 'quoted' ? 'selected' : '' }}>Quoted
                                    </option>
                                    <option value="completed"
                                        {{ old('status', $quoteRequest->status) === 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="rejected"
                                        {{ old('status', $quoteRequest->status) === 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    {{-- <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="mailto:{{ $quoteRequest->email }}" 
                           class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            Send Email
                        </a>
                        @if ($quoteRequest->phone)
                            <a href="tel:{{ $quoteRequest->phone }}" 
                               class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                                Call Customer
                            </a>
                        @endif
                        <button type="button" 
                                onclick="confirmDelete('this quote request', function() { document.getElementById('delete-form').submit(); })"
                                class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Delete Request
                        </button>
                    </div>
                </div> --}}
                </div>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form id="delete-form" action="{{ route('admin.quote-requests.destroy', $quoteRequest) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
