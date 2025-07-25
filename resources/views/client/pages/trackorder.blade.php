{{-- @extends('client.layout.app') --}}

@section('title', 'Track Orders')

@section('content')
@php
use Illuminate\Support\Collection;

$orders = collect([
(object)[
'id' => 1,
'order_number' => 'ORD123456',
'device_brand' => 'Apple',
'device_model' => 'iPhone 13 Pro',
'device_color' => 'Graphite',
'device_imei' => '356789123456789',
'issue_description' => 'Screen cracked',
'status' => 'repairing',
'status_label' => 'Repairing',
'status_color' => 'bg-yellow-100 text-yellow-800',
'priority_label' => 'Normal',
'priority_color' => 'text-gray-600',
'created_at' => now()->subDays(3),
'estimated_completion' => now()->addDays(2)->toDateString(),
'estimated_time' => '2-3 days',
'total_price' => 149.99,
'technician' => (object)[
'name' => 'John Smith'
],
'services' => collect([
(object)['name' => 'Screen Replacement'],
(object)['name' => 'Battery Check']
]),
'notes' => 'Handle with care',
'rating' => null,

// Mock methods as closures
'getCompletedStepsCount' => fn() => 2,
'getTotalStepsCount' => fn() => 5,
],
(object)[
'id' => 2,
'order_number' => 'ORD123457',
'device_brand' => 'Samsung',
'device_model' => 'Galaxy S22',
'device_color' => null,
'device_imei' => null,
'issue_description' => 'No power',
'status' => 'delivered',
'status_label' => 'Delivered',
'status_color' => 'bg-green-100 text-green-800',
'priority_label' => 'High',
'priority_color' => 'text-red-600',
'created_at' => now()->subDays(7),
'estimated_completion' => now()->subDays(2)->toDateString(),
'estimated_time' => '5 days',
'total_price' => 89.50,
'technician' => null,
'services' => collect([
(object)['name' => 'Power IC Replacement']
]),
'notes' => null,
'rating' => 5,

// Mock methods as closures
'getCompletedStepsCount' => fn() => 5,
'getTotalStepsCount' => fn() => 5,
],
]);
@endphp


<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Track Orders</h1>
        <div class="text-sm text-gray-500">
            Total: {{ $orders->count() }} orders
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <form method="GET" action="">
            <div class="relative max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    type="text"
                    name="search"
                    placeholder="Search orders..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                    value="{{ request('search') }}" />
            </div>
        </form>
    </div>

    <!-- Orders List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">#{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-600">{{ $order->device_brand }} {{ $order->device_model }} - {{ $order->services->pluck('name')->join(', ') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                        <p class="text-sm text-gray-500 mt-1">
                            Created: {{ $order->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600">Device</p>
                        <p class="font-medium">{{ $order->device_brand }} {{ $order->device_model }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Technician</p>
                        <p class="font-medium">{{ $order->technician->name ?? 'Not assigned' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Cost</p>
                        <p class="font-medium text-green-600">${{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress</span>
                        <span class="text-sm text-gray-500">
                            {{ ($order->getCompletedStepsCount)() }}/{{ ($order->getTotalStepsCount)() }} steps
                        </span>



                    </div>
                    <div class="flex items-center space-x-2">
                        @php
                        $steps = [
                        ['status' => 'pending', 'label' => 'Received', 'completed' => in_array($order->status, ['diagnosing', 'repairing', 'completed', 'delivered'])],
                        ['status' => 'diagnosing', 'label' => 'Diagnosing', 'completed' => in_array($order->status, ['repairing', 'completed', 'delivered'])],
                        ['status' => 'repairing', 'label' => 'Repairing', 'completed' => in_array($order->status, ['completed', 'delivered'])],
                        ['status' => 'completed', 'label' => 'Completed', 'completed' => in_array($order->status, ['delivered'])],
                        ['status' => 'delivered', 'label' => 'Delivered', 'completed' => $order->status === 'delivered']
                        ];
                        @endphp

                        @foreach($steps as $index => $step)
                        <div class="flex flex-col items-center">
                            @if($step['completed'] || $order->status === $step['status'])
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @else
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12,6 12,12 16,14"></polyline>
                            </svg>
                            @endif
                            <span class="text-xs mt-1 {{ ($step['completed'] || $order->status === $step['status']) ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                        @if($index < count($steps) - 1)
                            <div class="flex-1 h-0.5 {{ $step['completed'] ? 'bg-green-600' : 'bg-gray-200' }}">
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button
                        onclick="viewOrderDetails('{{ $order->id }}')"
                        class="text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Details</span>
                    </button>
                    <button class="text-green-600 hover:text-green-800 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Message</span>
                    </button>
                </div>
                @if($order->status === 'delivered' && !$order->rating)
                <button
                    onclick="rateOrder('{{ $order->id }}')"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                    <span>Rate Service</span>
                </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-sm border p-8 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
        <p class="text-gray-600 mb-4">You haven't placed any repair orders yet.</p>
        <a href="" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Book a Service
        </a>
    </div>
    @endforelse
</div>

{{--{{ $orders->links() }} --}}
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Order Details <span id="orderNumber"></span></h2>
            <button onclick="closeModal('orderDetailsModal')" class="text-gray-400 hover:text-gray-600 text-2xl">
                ×
            </button>
        </div>

        <div id="orderDetailsContent">
            <!-- Content will be loaded via AJAX -->
        </div>
    </div>
</div>

<!-- Rating Modal -->
<div id="ratingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Rate Service</h2>
            <button onclick="closeModal('ratingModal')" class="text-gray-400 hover:text-gray-600 text-2xl">
                ×
            </button>
        </div>

        <form id="ratingForm" onsubmit="submitRating(event)">
            <div class="space-y-4">
                <div class="text-center">
                    <p class="text-gray-600 mb-2">Rate order <span id="ratingOrderNumber"></span></p>
                    <div class="flex items-center justify-center space-x-1" id="starRating">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-8 h-8 text-gray-300 cursor-pointer star" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                            @endfor
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Your feedback
                    </label>
                    <textarea
                        name="feedback"
                        rows="4"
                        placeholder="Share your experience with our service..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
                <input type="hidden" name="order_id" id="ratingOrderId">
                <input type="hidden" name="rating" id="selectedRating" value="5">
                <div class="flex items-center justify-end space-x-2">
                    <button
                        type="button"
                        onclick="closeModal('ratingModal')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Submit Rating
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let currentRating = 5;

    function viewOrderDetails(orderId) {
        document.getElementById('orderDetailsModal').classList.remove('hidden');

        fetch(`/orders/${orderId}/details`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('orderNumber').textContent = `#${data.order_number}`;
                document.getElementById('orderDetailsContent').innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Device Information</h3>
                            <div class="space-y-2">
                                <div><strong>Type:</strong> ${data.device_brand} ${data.device_model}</div>
                                <div><strong>Color:</strong> ${data.device_color || 'Not specified'}</div>
                                <div><strong>IMEI:</strong> ${data.device_imei || 'Not provided'}</div>
                                <div><strong>Issue:</strong> ${data.issue_description}</div>
                                <div><strong>Technician:</strong> ${data.technician_name || 'Not assigned'}</div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Payment Information</h3>
                            <div class="space-y-2">
                                <div><strong>Total Cost:</strong> $${data.total_price}</div>
                                <div><strong>Status:</strong> 
                                    <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full ${data.status_color}">
                                        ${data.status_label}
                                    </span>
                                </div>
                                <div><strong>Priority:</strong> 
                                    <span class="ml-2 ${data.priority_color}">${data.priority_label}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Timeline</h3>
                            <div class="space-y-2">
                                <div><strong>Created:</strong> ${data.created_at}</div>
                                <div><strong>Estimated Completion:</strong> ${data.estimated_completion}</div>
                                <div><strong>Services:</strong> ${data.services}</div>
                                <div><strong>Estimated Time:</strong> ${data.estimated_time || 'Not specified'}</div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Additional Notes</h3>
                            <p class="text-gray-700">${data.notes || 'No additional notes'}</p>
                        </div>
                    </div>
                </div>
            `;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load order details');
            });
    }

    function rateOrder(orderId) {
        document.getElementById('ratingModal').classList.remove('hidden');
        document.getElementById('ratingOrderId').value = orderId;
        document.getElementById('ratingOrderNumber').textContent = `#${orderId}`;
        updateStarDisplay(5);
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function updateStarDisplay(rating) {
        currentRating = rating;
        document.getElementById('selectedRating').value = rating;

        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    function submitRating(event) {
        event.preventDefault();

        const formData = new FormData(event.target);

        fetch('/orders/rate', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thank you for your rating!');
                    closeModal('ratingModal');
                    location.reload();
                } else {
                    alert('Failed to submit rating');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit rating');
            });
    }

    // Initialize star rating
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                updateStarDisplay(rating);
            });
        });
    });
</script>
@endsection