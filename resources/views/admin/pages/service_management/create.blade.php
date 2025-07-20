@extends('admin.layout.app')

@section('title', 'Create Service')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-8 px-4">
        <div class="max-w-3xl mx-auto">
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.service.index') }}"
                    class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors duration-200 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium">Back to Services</span>
                </a>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Create New Service</h1>
                <p class="text-slate-600">Fill in the details to create a new service</p>
            </div>

            {{-- Main Content Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white">Service Configuration</h2>
                    <p class="text-blue-100 mt-1">Define pricing, features, and service details</p>
                </div>

                {{-- Notifications --}}
                @if (session('success'))
                    <div class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
                        <svg class="text-emerald-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span class="text-emerald-700 font-medium">Service created successfully!</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mx-8 mt-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="text-red-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-red-700 font-medium">Please fix the following errors:</span>
                        </div>
                        <ul class="space-y-1 ml-8">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-sm">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.service.store') }}" class="p-8 space-y-8">
                    @csrf
                    {{-- Device Type Field --}}
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-slate-700 font-sem
                        bold">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Device Type
                        </label>
                        <div class="relative">
                            <input type="text" name="device_type_name" value="{{ old('device_type_name') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 font-medium"
                                placeholder="Enter device type name">
                            @error('device_type_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    {{-- Issue Category Field --}}
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-slate-700 font-semibold">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                            </svg>
                            Issue Category
                        </label>
                        <div class="relative">

                            <input type="text" name="issue_category_name" value="{{ old('issue_category_name') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 font-medium"
                                placeholder="Enter issue name">
                            @error('issue_category_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Base Price Field --}}
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-slate-700 font-semibold">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 16v-4" />
                            </svg>
                            Base Price
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" name="base_price" value="{{ old('base_price') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 font-medium"
                                placeholder="Enter base price">
                            @error('base_price')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description Field --}}
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-slate-700 font-semibold">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 8h8M8 12h8M8 16h4" />
                            </svg>
                            Description
                        </label>
                        <textarea id="description" name="description"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 min-h-[120px] resize-none"
                            placeholder="Enter service description..." rows="4">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                            <div class="flex justify-between text-sm text-slate-500 mt-1">
                                <span>Provide detailed information about this service</span>
                                <span><span id="char-count">{{ strlen(old('description', '')) }}</span>/1000</span>
                            </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end pt-6 border-t border-slate-100">
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Create Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('description');
            const charCount = document.getElementById('char-count');
    
            function updateCharCount() {
                charCount.textContent = textarea.value.length;
            }
    
            // Cập nhật ngay khi load trang (ví dụ khi validation fail)
            updateCharCount();
    
            // Cập nhật mỗi lần gõ
            textarea.addEventListener('input', updateCharCount);
        });
    </script>
    
@endsection
