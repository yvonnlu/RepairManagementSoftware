@extends('admin.layout.app')

@section('title', 'Technician Management')

@section('content')
    <div class="space-y-6">

        @php
            $stats = $stats ?? [
                'total' => 6,
                'available' => 3,
                'busy' => 2,
                'avg_rating' => 4.6,
            ];
            $technicians =
                $technicians ??
                collect([
                    (object) [
                        'id' => 1,
                        'name' => 'John Doe',
                        'employee_id' => 'EMP123',
                        'email' => 'john@example.com',
                        'phone' => '0123456789',
                        'role_label' => 'Technician',
                        'status' => 'available',
                        'status_label' => 'Available',
                        'status_color' => 'bg-green-100 text-green-800',
                        'rating' => 4.5,
                        'total_repairs' => 128,
                        'specialties_array' => ['AC Repair', 'Wiring', 'Inspection'],
                        'certifications_array' => ['Level A', 'ISO 9001'],
                        'skill_level' => 8,
                        'success_rate' => 95,
                        'avg_repair_time' => 150,
                        'current_workload' => 2,
                        'max_workload' => 5,
                        'workload_color' => 'bg-blue-600',
                        'hourly_rate' => 20,
                        'hire_date' => '2022-06-01',
                        'last_active' => '2025-07-05 20:30',
                    ],
                    (object) [
                        'id' => 2,
                        'name' => 'Linh Nguyen',
                        'employee_id' => 'EMP124',
                        'email' => 'linh@example.com',
                        'phone' => '0988888888',
                        'role_label' => 'Senior Technician',
                        'status' => 'busy',
                        'status_label' => 'Busy',
                        'status_color' => 'bg-yellow-100 text-yellow-800',
                        'rating' => 4.8,
                        'total_repairs' => 215,
                        'specialties_array' => ['Fridge Repair', 'Maintenance'],
                        'certifications_array' => ['Certified Pro', 'Level B'],
                        'skill_level' => 9,
                        'success_rate' => 92,
                        'avg_repair_time' => 180,
                        'current_workload' => 4,
                        'max_workload' => 4,
                        'workload_color' => 'bg-yellow-500',
                        'hourly_rate' => 25,
                        'hire_date' => '2021-04-15',
                        'last_active' => '2025-07-05 21:00',
                    ],
                    (object) [
                        'id' => 3,
                        'name' => 'Nam Pham',
                        'employee_id' => 'EMP125',
                        'email' => 'nam@example.com',
                        'phone' => '0909123456',
                        'role_label' => 'Junior Technician',
                        'status' => 'offline',
                        'status_label' => 'Offline',
                        'status_color' => 'bg-gray-200 text-gray-600',
                        'rating' => 3.9,
                        'total_repairs' => 50,
                        'specialties_array' => ['Washer Repair'],
                        'certifications_array' => [],
                        'skill_level' => 6,
                        'success_rate' => 88,
                        'avg_repair_time' => 220,
                        'current_workload' => 0,
                        'max_workload' => 3,
                        'workload_color' => 'bg-gray-400',
                        'hourly_rate' => 15,
                        'hire_date' => '2023-02-10',
                        'last_active' => '2025-07-04 15:20',
                    ],
                ]);
        @endphp

        <div class="space-y-6" x-data="technicianManagement()">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Technician Management</h1>
                    <p class="text-gray-600 mt-1">Manage technicians, track performance, and assign workloads</p>
                </div>
                <a href=""
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Technician</span>
                </a>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Technicians</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Available</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['available'] }}</p>
                        </div>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Busy</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['busy'] }}</p>
                        </div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Avg Rating</p>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['avg_rating'], 1) }}</p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="relative max-w-md">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <form method="GET" action="">
                        <input type="text" name="search"
                            placeholder="Search technicians by name, email, or specialty..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                            value="{{ request('search') }}" x-model="searchTerm" @input.debounce.300ms="search()" />
                    </form>
                </div>
            </div>

            <!-- Technicians Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($technicians as $technician)
                    @php
                        $workloadPercentage =
                            $technician->max_workload > 0
                                ? round(($technician->current_workload / $technician->max_workload) * 100)
                                : 0;
                    @endphp
                    <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $technician->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $technician->role_label }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $technician->status_color }}">
                                    {{ $technician->status_label }}
                                </span>
                            </div>

                            <!-- Contact Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span>{{ $technician->phone }}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>{{ $technician->email }}</span>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="flex items-center space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= floor($technician->rating) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">({{ $technician->rating }})</span>
                                <span class="text-sm text-gray-400">• {{ $technician->total_repairs }} repairs</span>
                            </div>

                            <!-- Specialties -->
                            <div class="mb-4">
                                <div class="flex items-center space-x-2 mb-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Specialties:</span>
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach (array_slice($technician->specialties_array, 0, 3) as $specialty)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ $specialty }}
                                        </span>
                                    @endforeach
                                    @if (count($technician->specialties_array) > 3)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            +{{ count($technician->specialties_array) - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Performance Metrics -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <p class="text-lg font-bold text-gray-900">{{ $technician->success_rate }}%</p>
                                    <p class="text-xs text-gray-500">Success Rate</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <p class="text-lg font-bold text-gray-900">
                                        {{ round($technician->avg_repair_time / 60) }}h</p>
                                    <p class="text-xs text-gray-500">Avg Time</p>
                                </div>
                            </div>

                            <!-- Workload -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Current Workload:</span>
                                    <span
                                        class="text-sm text-gray-600">{{ $technician->current_workload }}/{{ $technician->max_workload }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $technician->workload_color }}"
                                        style="width: {{ $workloadPercentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $workloadPercentage }}% capacity</div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="flex items-center space-x-2">
                                    <button @click="viewTechnicianDetails({{ $technician->id }})"
                                        class="text-blue-600 hover:text-blue-800 transition-colors" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="deleteTechnician({{ $technician->id }}, '{{ $technician->name }}')"
                                        class="text-red-600 hover:text-red-800 transition-colors"
                                        title="Delete Technician">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <button @click="assignWork({{ $technician->id }})"
                                    :disabled="'{{ $technician->status }}'
                                    !== 'available'"
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    Assign Work
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No technicians found</h3>
                        <p class="text-gray-500 mb-4">Get started by adding your first technician.</p>
                        <a href=""
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Add Technician
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            {{-- @if ($technicians->hasPages())
        <div class="flex justify-center">
            {{ $technicians->appends(request()->query())->links() }}
        </div>
    @endif --}}

            {{-- Hiển thị UI pagination giả nếu cần --}}
            <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500 text-center">
                Page 1 / 1
            </div>


            <!-- Technician Details Modal -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;"
                @click.self="showModal = false">
                <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Technician Details</h2>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                            ×
                        </button>
                    </div>

                    <div x-show="selectedTechnician" class="space-y-6">
                        <template x-if="selectedTechnician">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Personal Info -->
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="font-semibold text-gray-900 mb-3">Personal Information</h3>
                                        <div class="space-y-2">
                                            <div><strong>Name:</strong> <span x-text="selectedTechnician.name"></span>
                                            </div>
                                            <div><strong>Employee ID:</strong> <span
                                                    x-text="selectedTechnician.employee_id"></span></div>
                                            <div><strong>Role:</strong> <span
                                                    x-text="selectedTechnician.role_label"></span></div>
                                            <div><strong>Email:</strong> <span x-text="selectedTechnician.email"></span>
                                            </div>
                                            <div><strong>Phone:</strong> <span x-text="selectedTechnician.phone"></span>
                                            </div>
                                            <div><strong>Hire Date:</strong> <span
                                                    x-text="selectedTechnician.hire_date"></span></div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="font-semibold text-gray-900 mb-3">Skills & Certifications</h3>
                                        <div class="space-y-3">
                                            <div>
                                                <strong>Specialties:</strong>
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    <template x-for="specialty in selectedTechnician.specialties_array"
                                                        :key="specialty">
                                                        <span
                                                            class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                                                            x-text="specialty"></span>
                                                    </template>
                                                </div>
                                            </div>
                                            <div>
                                                <strong>Certifications:</strong>
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    <template x-for="cert in selectedTechnician.certifications_array"
                                                        :key="cert">
                                                        <span
                                                            class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full"
                                                            x-text="cert"></span>
                                                    </template>
                                                </div>
                                            </div>
                                            <div><strong>Skill Level:</strong> <span
                                                    x-text="selectedTechnician.skill_level"></span>/10</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Performance & Schedule -->
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="font-semibold text-gray-900 mb-3">Performance Metrics</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="text-center p-3 bg-white rounded">
                                                <p class="text-2xl font-bold text-blue-600"
                                                    x-text="selectedTechnician.rating"></p>
                                                <p class="text-sm text-gray-500">Rating</p>
                                            </div>
                                            <div class="text-center p-3 bg-white rounded">
                                                <p class="text-2xl font-bold text-green-600"
                                                    x-text="selectedTechnician.total_repairs"></p>
                                                <p class="text-sm text-gray-500">Total Repairs</p>
                                            </div>
                                            <div class="text-center p-3 bg-white rounded">
                                                <p class="text-2xl font-bold text-purple-600"
                                                    x-text="selectedTechnician.success_rate + '%'"></p>
                                                <p class="text-sm text-gray-500">Success Rate</p>
                                            </div>
                                            <div class="text-center p-3 bg-white rounded">
                                                <p class="text-2xl font-bold text-orange-600"
                                                    x-text="Math.round(selectedTechnician.avg_repair_time / 60) + 'h'"></p>
                                                <p class="text-sm text-gray-500">Avg Time</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="font-semibold text-gray-900 mb-3">Current Status</h3>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span>Status:</span>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full"
                                                    :class="selectedTechnician.status_color"
                                                    x-text="selectedTechnician.status_label"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Workload:</span>
                                                <span
                                                    x-text="selectedTechnician.current_workload + '/' + selectedTechnician.max_workload"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Hourly Rate:</span>
                                                <span x-text="'$' + selectedTechnician.hourly_rate + '/hr'"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Last Active:</span>
                                                <span x-text="selectedTechnician.last_active"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="flex items-center justify-end space-x-2 pt-6 border-t">
                            <select x-model="newStatus"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="available">Available</option>
                                <option value="busy">Busy</option>
                                <option value="break">On Break</option>
                                <option value="offline">Offline</option>
                                <option value="vacation">On Vacation</option>
                            </select>
                            <button @click="updateTechnicianStatus()"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;"
                @click.self="showDeleteModal = false">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Deletion</h3>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete technician <strong x-text="technicianToDelete.name"></strong>?
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
            function technicianManagement() {
                return {
                    showModal: false,
                    showDeleteModal: false,
                    selectedTechnician: null,
                    technicianToDelete: null,
                    newStatus: '',
                    searchTerm: '{{ request('search') }}',

                    async viewTechnicianDetails(technicianId) {
                        try {
                            const response = await fetch(`/${technicianId}`, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });

                            if (response.ok) {
                                this.selectedTechnician = await response.json();
                                this.newStatus = this.selectedTechnician.status;
                                this.showModal = true;
                            }
                        } catch (error) {
                            console.error('Error fetching technician details:', error);
                        }
                    },

                    async updateTechnicianStatus() {
                        if (!this.selectedTechnician || !this.newStatus) return;

                        try {
                            const response = await fetch(`/${this.selectedTechnician.id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    status: this.newStatus
                                })
                            });

                            if (response.ok) {
                                this.showModal = false;
                                window.location.reload();
                            }
                        } catch (error) {
                            console.error('Error updating technician status:', error);
                        }
                    },

                    assignWork(technicianId) {
                        // Redirect to work assignment page or show assignment modal
                        window.location.href = `?technician=${technicianId}`;
                    },

                    deleteTechnician(technicianId, technicianName) {
                        this.technicianToDelete = {
                            id: technicianId,
                            name: technicianName
                        };
                        this.showDeleteModal = true;
                    },

                    async confirmDelete() {
                        try {
                            const response = await fetch(`/${this.technicianToDelete.id}`, {
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
                            console.error('Error deleting technician:', error);
                        }
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
    </div>
@endsection
