<header
    class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-20 lg:left-64 transition-all duration-300"
    x-data="{
        showProfile: false,
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
        }
    }" @click.away="showProfile = false">
    <div class="flex items-center justify-between px-4 py-4 lg:px-6">
        <!-- Mobile Menu Button -->
        <div class="flex items-center lg:hidden">
            <button @click="toggleSidebar()"
                class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                title="Toggle Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Search Section -->
        <div class="flex items-center space-x-4 flex-1 lg:flex-none">
            {{-- <div class="relative w-full lg:w-auto">
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
            </div> --}}
        </div>

        <div class="flex items-center space-x-2 lg:space-x-4">
            <!-- Home Button -->
            <a href="{{ route('home.index') }}"
                class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                title="Go to Homepage">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="hidden lg:inline">Home</span>
            </a>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button @click="showProfile = !showProfile"
                    class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="text-left hidden lg:block">
                        <span class="text-sm font-medium text-gray-700 block">
                            {{ auth()->user()->name ?? 'Admin User' }}
                        </span>
                        <span class="text-xs text-gray-500">
                            Administrator
                        </span>
                    </div>
                </button>

                <!-- Profile Dropdown Menu -->
                <div x-show="showProfile" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                    style="display: none;">
                    <div class="p-2">
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center space-x-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
