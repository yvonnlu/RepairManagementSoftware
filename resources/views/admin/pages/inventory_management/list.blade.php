@extends('admin.layout.app')

@section('title', 'Inventory Management')

@section('content')

    <div class="space-y-6" x-data="inventoryManagement()">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Inventory Management</h1>
                <p class="text-gray-600 mt-1">Manage parts, track stock levels, and monitor inventory value</p>
            </div>
            <div class="flex items-center space-x-3">


                <a href="{{ route('admin.inventory.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Part</span>
                </a>
            </div>
        </div>

        <!-- Success Notification -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 00-1.414 1.414L8.586 8.586l-2.934 2.934a1 1 0 101.414 1.414L10 9.828l2.934 2.934a1 1 0 001.414-1.414L11.414 8.586l2.934-2.934z" />
                    </svg>
                </span>
            </div>
        @endif


        <!-- Search and Filter -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="relative flex-1 md:max-w-md">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <form method="GET" action="">
                        <input type="text" name="search"
                            placeholder="Search parts by name, device type, or issue category..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                            value="{{ request('search') }}" x-model="searchTerm" @keyup.enter="search()" @blur="search()" />
                    </form>
                </div>
                <div class="flex items-center space-x-2">
                    <form method="GET" action="{{ route('admin.inventory.index') }}" class="flex items-center space-x-2">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="category" onchange="this.form.submit()"
                            class="px-4 py-2 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ request('category') === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
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
                            <tr class="hover:bg-gray-50 {{ $part->deleted_at ? 'opacity-60 bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $part->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $part->device_type }}</div>
                                        <div class="text-xs text-gray-400">
                                            {{ $part->issue_category }}
                                            @if ($part->deleted_at)
                                                <br><span class="text-red-600 font-medium">Deleted:
                                                    {{ $part->deleted_at->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                            {{ $part->device_type }}
                                        </span>
                                        @if ($part->deleted_at)
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                Deleted
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                Active
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $part->current_stock }} units
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $part->stock_status_color }}">
                                            {{ $part->stock_status }}
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Min: {{ $part->min_stock_level }}
                                            @if ($part->total_in > 0 || $part->total_out > 0)
                                                <br>In: {{ $part->total_in }} | Out: {{ $part->total_out }}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($part->cost_price) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($part->cost_price * 2.5) }}
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Auto-managed</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-1 text-sm text-gray-900">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $part->location ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.inventory.detail', $part) }}"
                                            class="text-blue-600 hover:text-blue-800" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if (!$part->deleted_at && $part->current_stock <= $part->min_stock_level)
                                            <button @click="reorderPart({{ $part->id }})"
                                                class="text-orange-600 hover:text-orange-800" title="Reorder">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif

                                        @if ($part->deleted_at)
                                            <!-- Restore button for deleted parts -->
                                            <form method="POST"
                                                action="{{ route('admin.inventory.restore', $part->id) }}" class="inline"
                                                id="restore-part-form-{{ $part->id }}">
                                                @csrf
                                                <button type="button"
                                                    onclick="confirmRestore('{{ $part->name }}', function() { document.getElementById('restore-part-form-{{ $part->id }}').submit(); })"
                                                    class="text-green-600 hover:text-green-800" title="Restore">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Delete button for active parts -->
                                            <button
                                                onclick="confirmDelete('{{ $part->name }}', function() { 
                                                fetch('/admin/inventory/{{ $part->id }}', {
                                                    method: 'DELETE',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                        'Accept': 'application/json',
                                                        'X-Requested-With': 'XMLHttpRequest'
                                                    }
                                                }).then(response => {
                                                    if (response.ok) {
                                                        window.location.reload();
                                                    }
                                                }).catch(error => console.error('Error:', error));
                                            })"
                                                class="text-red-600 hover:text-red-800" title="Delete Part">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
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
            {{-- @if ($parts->hasPages())
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
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;"
            @click.self="showModal = false">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

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
                                        <div><strong>Condition:</strong> <span x-text="selectedPart.condition"></span>
                                        </div>
                                        <div><strong>Location:</strong> <span x-text="selectedPart.location"></span></div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Pricing & Stock</h3>
                                    <div class="space-y-2">
                                        <div><strong>Cost:</strong> $<span x-text="selectedPart.cost"></span></div>
                                        <div><strong>Selling Price:</strong> $<span
                                                x-text="selectedPart.selling_price"></span></div>
                                        <div><strong>Current Stock:</strong> <span
                                                x-text="selectedPart.stock_quantity"></span> units</div>
                                        <div><strong>Minimum Level:</strong> <span
                                                x-text="selectedPart.min_stock_level"></span> units</div>
                                        <div><strong>Warranty:</strong> <span x-text="selectedPart.warranty"></span> days
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Supplier Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="space-y-2">
                                        <div><strong>Supplier:</strong> <span x-text="selectedPart.supplier"></span></div>
                                        <div x-show="selectedPart.supplier_part_number">
                                            <strong>Supplier Part #:</strong> <span
                                                x-text="selectedPart.supplier_part_number"></span>
                                        </div>
                                    </div>
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
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Reorder
                                </button>
                            </div>
                        </div>
                    </template>
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
                searchTerm: '{{ request('search') }}',

                search() {
                    // Tạo form tự động submit để giữ nguyên pagination và filters
                    const form = document.createElement('form');
                    form.method = 'GET';
                    form.action = window.location.pathname;

                    // Thêm search term
                    if (this.searchTerm) {
                        const searchInput = document.createElement('input');
                        searchInput.type = 'hidden';
                        searchInput.name = 'search';
                        searchInput.value = this.searchTerm;
                        form.appendChild(searchInput);
                    }

                    // Giữ lại category filter nếu có
                    const categorySelect = document.querySelector('select[name="category"]');
                    if (categorySelect && categorySelect.value) {
                        const categoryInput = document.createElement('input');
                        categoryInput.type = 'hidden';
                        categoryInput.name = 'category';
                        categoryInput.value = categorySelect.value;
                        form.appendChild(categoryInput);
                    }

                    document.body.appendChild(form);
                    form.submit();
                },

                async viewPartDetails(partId) {
                    try {
                        const response = await fetch(`/admin/inventory/detail/${partId}`, {
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
                        const response = await fetch(`/admin/inventory/${partId}/add-stock`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                quantity: 10,
                                notes: 'Auto reorder - low stock alert'
                            })
                        });

                        if (response.ok) {
                            const result = await response.json();
                            alert(result.message || 'Reorder initiated successfully');
                            window.location.reload();
                        }
                    } catch (error) {
                        console.error('Error initiating reorder:', error);
                    }
                },

                async bulkReorder() {
                    try {
                        // In a real implementation, you would have a bulk reorder endpoint
                        alert('Bulk reorder functionality will be implemented');
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
                        const response = await fetch(`/admin/inventory/${this.partToDelete.id}`, {
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
                }
            }
        }
    </script>
@endsection
