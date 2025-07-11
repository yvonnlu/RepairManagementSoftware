@extends('client.layout.app')

@section('content')
// routes/web.php
Route::get('/profile', function () {
    $user = (object)[
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123-456-7890',
        'address' => '123 Example Street, HCMC',
        'created_at' => now()->subYears(2),
    ];

    $stats = [
        'total_orders' => 42,
        'completed_orders' => 39,
        'average_rating' => 4.7,
    ];

    $recentOrders = collect([
        (object)[
            'id' => 1,
            'device_model' => 'iPhone 13',
            'services' => collect([(object)['name' => 'Screen Replacement'], (object)['name' => 'Battery Replacement']]),
            'status' => 'completed',
            'created_at' => now()->subDays(2),
            'total_amount' => 199.99
        ],
        // ...
    ]);

    return view('client.profile', compact('user', 'stats', 'recentOrders'));
});


<div class="space-y-6" x-data="profileManager()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Personal Profile</h1>
        <div x-show="!isEditing">
            <button @click="startEditing()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors">
                {{-- @include('components.icons.edit') --}}
                <span>Edit</span>
            </button>
        </div>
        <div x-show="isEditing" class="flex items-center space-x-2">
            <button @click="saveProfile()" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-green-700 transition-colors">
                {{-- @include('components.icons.save') --}}
                <span>Save</span>
            </button>
            <button @click="cancelEditing()" 
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-gray-700 transition-colors">
                {{-- @include('components.icons.x') --}}
                <span>Cancel</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-center space-x-6 mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        {{-- @include('components.icons.user', ['class' => 'w-12 h-12 text-white']) --}}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">Customer since {{ $user->created_at->format('M d, Y') }}</p>
                        <div class="flex items-center space-x-1 mt-2">
                            {{-- @include('components.icons.award', ['class' => 'w-4 h-4 text-yellow-500']) --}}
                            <span class="text-sm text-gray-600">VIP Customer</span>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="saveProfile()">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                {{-- @include('components.icons.phone', ['class' => 'w-5 h-5 text-gray-500']) --}}
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input x-show="isEditing" 
                                           type="tel" 
                                           x-model="profile.phone"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p x-show="!isEditing" class="text-gray-900" x-text="profile.phone"></p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                {{-- @include('components.icons.mail', ['class' => 'w-5 h-5 text-gray-500']) --}}
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input x-show="isEditing" 
                                           type="email" 
                                           x-model="profile.email"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p x-show="!isEditing" class="text-gray-900" x-text="profile.email"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                {{-- @include('components.icons.map-pin', ['class' => 'w-5 h-5 text-gray-500 mt-1']) --}}
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea x-show="isEditing" 
                                              x-model="profile.address"
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                    <p x-show="!isEditing" class="text-gray-900" x-text="profile.address"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                <div class="space-y-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_orders'] }}</p>
                        <p class="text-sm text-gray-600">Total Orders</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-3xl font-bold text-green-600">{{ $stats['completed_orders'] }}</p>
                        <p class="text-sm text-gray-600">Completed</p>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <p class="text-3xl font-bold text-yellow-600">{{ number_format($stats['average_rating'], 1) }}</p>
                        <p class="text-sm text-gray-600">Average Rating</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Special Offers</h3>
                <div class="space-y-3">
                    <div class="p-3 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg">
                        <p class="text-sm font-medium text-purple-800">10% off your next order</p>
                        <p class="text-xs text-purple-600">Valid until Dec 31, 2024</p>
                    </div>
                    <div class="p-3 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-lg">
                        <p class="text-sm font-medium text-blue-800">Free shipping</p>
                        <p class="text-xs text-blue-600">For VIP customers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Order History</h3>
                <a href="" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->device_model }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->services->pluck('name')->implode(', ') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if($order->status === 'completed') Completed
                                @elseif($order->status === 'in_progress') In Progress
                                @elseif($order->status === 'pending') Pending
                                @else {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function profileManager() {
    return {
        isEditing: false,
        profile: {
            phone: '{{ $user->phone ?? '' }}',
            email: '{{ $user->email }}',
            address: '{{ $user->address ?? '' }}'
        },
        originalProfile: {},

        startEditing() {
            this.isEditing = true;
            this.originalProfile = { ...this.profile };
        },

        cancelEditing() {
            this.isEditing = false;
            this.profile = { ...this.originalProfile };
        },

        async saveProfile() {
            try {
                const response = await fetch('', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.profile)
                });

                if (response.ok) {
                    this.isEditing = false;
                    // Show success message
                    alert('Profile updated successfully!');
                } else {
                    throw new Error('Failed to update profile');
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                alert('Error updating profile. Please try again.');
            }
        }
    }
}
</script>
@endsection
