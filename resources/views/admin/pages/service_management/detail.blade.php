@extends('admin.layout.app')

@section('title', 'Service Detail')

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
                @if (session('success'))
                    <div class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
                        <svg class="text-emerald-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        <span class="text-emerald-700 font-medium">Service updated successfully!</span>
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
                <form method="POST" action="{{ route('admin.service.update', ['service' => $service->id]) }}"
                    class="p-8 space-y-8">
                    @csrf


                    {{-- Device Type Field --}}
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-slate-700 font-semibold">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Device Type
                        </label>
                        <div class="relative">
                            <input type="text" name="device_type_name" value="{{ $service->device_type_name }}"
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

                            <input type="text" name="issue_category_name" value="{{ $service->issue_category_name }}"
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
                            <input type="number" step="0.01" name="base_price" value="{{ $service->base_price }}"
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
                            placeholder="Enter service description..." rows="4">{{ $service->description }}</textarea>
                        @error('description')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="flex justify-between text-sm text-slate-500 mt-1">
                            <span>Provide detailed information about this service</span>
                            <span><span id="char-count">{{ strlen($service->description) }}</span>/1000</span>
                        </div>
                    </div>

                    {{-- Image Management Section --}}
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-slate-700 font-semibold">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21,15 16,10 5,21"></polyline>
                            </svg>
                            Service Image
                        </label>

                        {{-- Current Image Display --}}
                        <div class="border border-slate-200 rounded-xl p-4 bg-slate-50">
                            <div id="current-image-container" class="text-center">
                                @if ($service->hasImage())
                                    <div class="space-y-3">
                                        <img id="current-image" src="{{ $service->image_url }}"
                                            alt="{{ $service->issue_category_name }}"
                                            class="mx-auto max-w-xs h-40 object-cover rounded-lg shadow-md">
                                        <div class="text-sm text-slate-600">
                                            <strong>Current image:</strong> {{ $service->image_name }}
                                        </div>
                                        <div class="flex justify-center gap-2">
                                            <button type="button" id="delete-image-btn"
                                                onclick="confirmDelete('this image', function() { deleteServiceImage(); })"
                                                class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Move to Trash
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div id="no-image-state" class="space-y-3">
                                        <div
                                            class="w-32 h-32 mx-auto bg-slate-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <rect x="3" y="3" width="18" height="18" rx="2"
                                                    ry="2"></rect>
                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                <polyline points="21,15 16,10 5,21"></polyline>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500">No image uploaded</p>
                                        <button type="button" id="view-deleted-btn" onclick="toggleDeletedImages()"
                                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition-colors mx-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            View Trash
                                        </button>
                                    </div>
                                @endif
                            </div>

                            {{-- Upload Section --}}
                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <div class="space-y-3">
                                    <label for="image-upload" class="block text-sm font-medium text-slate-700">
                                        Upload New Image
                                    </label>
                                    <div class="flex items-center space-x-3">
                                        <input type="file" id="image-upload" accept="image/*"
                                            class="flex-1 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <button type="button" id="upload-btn"
                                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            Upload
                                        </button>
                                    </div>
                                    <p class="text-xs text-slate-500">Supported formats: JPEG, PNG, GIF. Max size: 2MB</p>
                                </div>

                                {{-- Upload Progress --}}
                                <div id="upload-progress" class="hidden mt-3">
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div id="upload-progress-bar"
                                            class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                            style="width: 0%"></div>
                                    </div>
                                    <p class="text-sm text-slate-600 mt-1">Uploading...</p>
                                </div>
                            </div>
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
                            Update Service
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Deleted Images Section --}}
        <div id="deleted-images-section" class="hidden mt-8">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-pink-600 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Deleted Images</h3>
                            <p class="text-red-100 text-sm">Recently removed images that can be restored</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div id="deleted-images-container">
                        {{-- Deleted images will be loaded here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character count for description
            const textarea = document.getElementById('description');
            const charCount = document.getElementById('char-count');

            function updateCharCount() {
                charCount.textContent = textarea.value.length;
            }

            updateCharCount();
            textarea.addEventListener('input', updateCharCount);

            // Image Management JavaScript
            const imageUpload = document.getElementById('image-upload');
            const uploadBtn = document.getElementById('upload-btn');
            const uploadProgress = document.getElementById('upload-progress');
            const uploadProgressBar = document.getElementById('upload-progress-bar');
            const currentImageContainer = document.getElementById('current-image-container');

            // Enable upload button when file is selected
            imageUpload.addEventListener('change', function() {
                uploadBtn.disabled = !this.files.length;
            });

            // Handle image upload
            uploadBtn.addEventListener('click', function() {
                const file = imageUpload.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Show progress
                uploadProgress.classList.remove('hidden');
                uploadBtn.disabled = true;

                fetch('{{ route('admin.service-images.upload', $service) }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload page to show updated image
                            location.reload();
                        } else {
                            showNotification(data.message || 'Upload failed', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        showNotification('Upload failed. Please try again.', 'error');
                    })
                    .finally(() => {
                        uploadProgress.classList.add('hidden');
                        uploadBtn.disabled = false;
                    });
            });

            // Show notification
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                    type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                    type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                    'bg-blue-100 border border-blue-400 text-blue-700'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />' :
                              type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' :
                              '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                        </svg>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });

        // Delete service image function (using confirmDelete from admin-common.js)
        function deleteServiceImage() {
            fetch('{{ route('admin.service-images.delete', $service) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated state
                        location.reload();
                    } else {
                        alert(data.message || 'Delete failed');
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    alert('Delete failed. Please try again.');
                });
        }

        // Toggle deleted images section
        function toggleDeletedImages() {
            const deletedSection = document.getElementById('deleted-images-section');
            const viewBtn = document.getElementById('view-deleted-btn');

            if (deletedSection.classList.contains('hidden')) {
                loadDeletedImages();
                deletedSection.classList.remove('hidden');
                viewBtn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Hide Trash
                `;
            } else {
                deletedSection.classList.add('hidden');
                viewBtn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    View Trash
                `;
            }
        }

        // Load deleted images
        function loadDeletedImages() {
            fetch('{{ route('admin.service-images.show', $service) }}')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('deleted-images-container');

                    if (data.deleted_images && data.deleted_images.length > 0) {
                        let html = '<div class="grid gap-4">';

                        data.deleted_images.forEach(image => {
                            html += `
                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21,15 16,10 5,21"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700">${image.original_name}</p>
                                        <p class="text-sm text-slate-500">Deleted: ${image.deleted_at}</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        onclick="confirmRestore('${image.original_name}', function() { restoreImage('${image.filename}'); })"
                                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Restore
                                </button>
                            </div>
                        `;
                        });

                        html += '</div>';
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <p class="text-slate-500">No deleted images found</p>
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    console.error('Error loading deleted images:', error);
                    document.getElementById('deleted-images-container').innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-red-500">Error loading deleted images</p>
                    </div>
                `;
                });
        }

        // Restore image function (uses confirmRestore from admin-common.js)
        function restoreImage(filename) {
            fetch('{{ route('admin.service-images.restore', $service) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        filename: filename
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show restored image
                        location.reload();
                    } else {
                        alert(data.message || 'Restore failed');
                    }
                })
                .catch(error => {
                    console.error('Restore error:', error);
                    alert('Restore failed. Please try again.');
                });
        }
    </script>

@endsection
