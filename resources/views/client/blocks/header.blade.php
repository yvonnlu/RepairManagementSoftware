{{-- <!-- <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
<header
    class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-20 lg:left-64 transition-all duration-300">
    <div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Customer Portal')</h1>
        <p class="text-gray-600">@yield('page-description', 'Manage your repair services and orders')</p>
    </div>

    <div class="flex items-center space-x-4"> -->
<!-- Notifications -->
<!-- <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-5 5v-5zM10.07 2.82l3.12 3.12M7.05 5.84l3.12 3.12M4.03 8.86l3.12 3.12M1.01 11.88l3.12 3.12"></path>
            </svg>
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
        </button> -->

<!-- User Menu -->
<!-- <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 transition-colors">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name ?? 'John Doe', 0, 1) }}</span>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium">{{ auth()->user()->name ?? 'John Doe' }}</p>
                    <p class="text-xs text-gray-500">Customer</p>
                </div>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile Settings
                </a>
                <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    My Orders
                </a>
                <div class="border-t border-gray-100"></div>
                <form method="POST" action="">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</header> -->

@php
$notifications = [
[
'id' => 1,
'title' => 'Repair completed!',
'message' => 'Your iPhone 13 has been successfully repaired.',
'time' => 'Just now',
'unread' => true
],
[
'id' => 2,
'title' => 'Exclusive Offer 🎁',
'message' => 'Get 10% off your next repair. Valid until July 31.',
'time' => '10 min ago',
'unread' => true
],
[
'id' => 3,
'title' => 'Order #RM-2024-053 confirmed',
'message' => 'We have received your repair request.',
'time' => '2 hours ago',
'unread' => false
],
[
'id' => 4,
'title' => 'Technician assigned',
'message' => 'Alex Nguyen will handle your MacBook repair.',
'time' => 'Yesterday',
'unread' => false
],
[
'id' => 5,
'title' => 'Rate your experience',
'message' => 'How was your last repair service?',
'time' => '2 days ago',
'unread' => false
]
];

$unreadCount = collect($notifications)->where('unread', true)->count();
@endphp


<header
    class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-20 lg:left-64 transition-all duration-300"
    x-data="{
        showNotifications: false,
        showProfile: false,
        darkMode: localStorage.getItem('darkMode') === 'true' || false,
        searchQuery: '',
        
        toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('translate-x-0')) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.style.display = 'none';
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                if (overlay) overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        },
        
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        
        markAllRead() {
            fetch('#', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(() => {
                window.location.reload();
            });
        },
        
        markAsRead(notificationId) {
            fetch(`#`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            });
        }
    }"
    x-init="
        if (darkMode) {
            document.documentElement.classList.add('dark');
        }
    "
    @click.away="showNotifications = false; showProfile = false">
    <div class="flex items-center justify-between px-4 py-4 lg:px-6">
        <!-- Mobile Menu Button -->
        <div class="flex items-center lg:hidden">
            <button
                @click="toggleSidebar()"
                class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                title="Toggle Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Search Section -->
        <div class="flex items-center space-x-4 flex-1 lg:flex-none">
            <div class="relative w-full lg:w-auto">
                <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <form action="" method="GET">
                    <input
                        type="text"
                        name="q"
                        x-model="searchQuery"
                        placeholder="Search orders, customers, parts..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full lg:w-96 bg-gray-50 focus:bg-white transition-colors"
                        value="{{ request('q') }}" />
                </form>
            </div>
        </div>

        <div class="flex items-center space-x-2 lg:space-x-4">
            <!-- Dark Mode Toggle -->
            <button
                @click="toggleDarkMode()"
                class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>

            <!-- Help - Hidden on mobile -->
            <a href=""
                class="hidden lg:block p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                title="Help & Support">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </a>

            <!-- Notifications -->
            <div class="relative">
                <button
                    @click="showNotifications = !showNotifications"
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                    title="Notifications">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-medium">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </button>

                <!-- Notifications Dropdown -->
                <div
                    x-show="showNotifications"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                    style="display: none;">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                            @if($unreadCount > 0)
                            <button
                                @click="markAllRead()"
                                class="text-sm text-blue-600 hover:text-blue-800">
                                Mark all read
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($notifications as $notification)
                        <div
                            class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer {{ $notification['unread'] ? 'bg-blue-50' : '' }}"
                            @click="markAsRead({{ $notification['id'] }})">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 rounded-full mt-2 {{ $notification['unread'] ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification['message'] }}</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ $notification['time'] }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-gray-500">
                            <p class="text-sm">No notifications</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-gray-200">
                        <a href=""
                            class="block w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button
                    @click="showProfile = !showProfile"
                    class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="text-left hidden lg:block">
                        <span class="text-sm font-medium text-gray-700 block">
                            {{ auth()->user()->name ?? 'John Doe' }}
                        </span>
                        <span class="text-xs text-gray-500">
                            Customer
                        </span>
                    </div>
                </button>

                <!-- Profile Dropdown Menu -->
                <div
                    x-show="showProfile"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                    style="display: none;">
                    <div class="p-2">
                        <a href=""
                            class="w-full flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('client.profile') }}"
                            class="w-full flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Settings</span>
                        </a>
                        <hr class="my-2">
                        <form action="" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center space-x-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> --}}