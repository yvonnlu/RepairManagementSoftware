@extends('admin.layout.app')

@section('title', 'Service Detail')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
  <div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
      <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors duration-200 mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-medium">Back to Services</span>
      </a>
      <h1 class="text-3xl font-bold text-slate-900 mb-2">Service Detail</h1>
      <p class="text-slate-600">Manage and update service information</p>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
      {{-- Card Header --}}
      <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
        <h2 class="text-xl font-semibold text-white">Service Configuration</h2>
        <p class="text-blue-100 mt-1">Update pricing and service details</p>
      </div>

      {{-- Notifications --}}
      @if(session('success'))
      <div class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
        <svg class="text-emerald-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
        </svg>
        <span class="text-emerald-700 font-medium">Service updated successfully!</span>
      </div>
      @endif
      @if($errors->any())
      <div class="mx-8 mt-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center gap-3 mb-2">
          <svg class="text-red-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <span class="text-red-700 font-medium">Please fix the following errors:</span>
        </div>
        <ul class="space-y-1 ml-8">
          @foreach($errors->all() as $error)
          <li class="text-red-600 text-sm">• {{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      {{-- Form --}}
      <form method="POST" action="" class="p-8 space-y-8">
        @csrf
        {{-- Device Type Field --}}
        <div class="space-y-3">
          <label class="flex items-center gap-2 text-slate-700 font-semibold">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Device Type
          </label>
          <div class="relative">
            <input type="text" value="{{ $data->device_type_name}}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium cursor-not-allowed">
            <div class="absolute right-3 top-1/2 -translate-y-1/2 px-2 py-1 bg-slate-200 text-slate-600 text-xs rounded-md">
              Read-only
            </div>
            <input type="hidden" name="device_type_id" value="{{ $data->device_type_id ?? '' }}">
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
            <input type="text" value="{{ $data->issue_category_name ?? '' }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium cursor-not-allowed" disabled>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 px-2 py-1 bg-slate-200 text-slate-600 text-xs rounded-md">
              Read-only
            </div>
            <input type="hidden" name="issue_category_id" value="{{ $data->issue_category_id ?? '' }}">
          </div>
        </div>

        {{-- Base Price Field --}}
        <div class="space-y-3">
          <label class="flex items-center gap-2 text-slate-700 font-semibold">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 16v-4" />
            </svg>
            Base Price
          </label>
          <div class="relative">
            <input type="number" step="0.01" name="base_price" value="{{ $data->base_price ?? '' }}"
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 font-medium"
              placeholder="Enter base price">
          </div>
        </div>

        {{-- Description Field --}}
        <div class="space-y-3">
          <label class="flex items-center gap-2 text-slate-700 font-semibold">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <rect x="4" y="4" width="16" height="16" rx="2" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8h8M8 12h8M8 16h4" />
            </svg>
            Description
          </label>
          <textarea name="description"
            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 min-h-[120px] resize-none"
            placeholder="Enter service description..." rows="4">{{ $data->description ?? '' }}</textarea>
          <div class="flex justify-between text-sm text-slate-500">
            <span>Provide detailed information about this service</span>
            <span>{{ strlen($data->description ?? '') }}/500</span>
          </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end pt-6 border-t border-slate-100">
          <button
            type="submit"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Update Service
          </button>
        </div>
      </form>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
      <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="text-blue-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
          </div>
          <h3 class="font-semibold text-slate-900">Device Information</h3>
        </div>
        <p class="text-slate-600 text-sm">This service is configured for {{ $data->device_type_name ?? '...' }} devices with specialized repair requirements.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="text-purple-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
            </svg>
          </div>
          <h3 class="font-semibold text-slate-900">Service Category</h3>
        </div>
        <p class="text-slate-600 text-sm">Categorized under {{ $data->issue_category_name ?? '...' }} with specific tools and expertise requirements.</p>
      </div>
    </div>
  </div>
</div>
@endsection