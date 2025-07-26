<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-sm shadow-sm">


    <!-- Main Navigation -->
    <nav class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="settings" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">TechFix Pro</h1>
                        <p class="text-xs text-gray-500">Professional Repair</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <button onclick="scrollToSection('home')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Home
                    </button>
                    <button onclick="scrollToSection('services')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Services
                    </button>
                    <button onclick="scrollToSection('features')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Features
                    </button>
                    <button onclick="scrollToSection('testimonials')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Reviews
                    </button>
                    <button onclick="scrollToSection('contact')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Contact
                    </button>
                    <a href="{{ route('cart.index') }}"
                        class="relative text-gray-700 hover:text-blue-600 transition-colors">
                        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        <span
                            class="cart-qty-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'qty')) : 0 }}
                        </span>
                    </a>
                    <button onclick="scrollToSection('contact')"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Book Now
                    </button>
                    <!-- User Auth Section -->
                    @if (Auth::check())
                        <div class="relative group">
                            <button id="avatarBtn" class="flex items-center space-x-2 focus:outline-none">
                                <span
                                    class="inline-block w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                    <i data-lucide="user" class="w-6 h-6"></i>
                                </span>
                                <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>
                            </button>
                            <!-- Dropdown -->
                            <div id="profileDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                                <a href="{{ route('client.profile') }}"
                                    class="block px-4 py-3 text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const btn = document.getElementById('avatarBtn');
                                const dropdown = document.getElementById('profileDropdown');
                                if (btn && dropdown) {
                                    btn.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                        dropdown.classList.toggle('hidden');
                                    });
                                    // Đảm bảo dropdown không bị ẩn khi click bên trong dropdown
                                    dropdown.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                    });
                                    document.addEventListener('click', function() {
                                        dropdown.classList.add('hidden');
                                    });
                                }
                            });
                        </script>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-blue-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                            Login
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()"
                    class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="container mx-auto px-4 py-4 space-y-4">
                <button onclick="scrollToSection('home')"
                    class="block w-full text-left text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">
                    Home
                </button>
                <button onclick="scrollToSection('services')"
                    class="block w-full text-left text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">
                    Services
                </button>
                <button onclick="scrollToSection('features')"
                    class="block w-full text-left text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">
                    Features
                </button>
                <button onclick="scrollToSection('testimonials')"
                    class="block w-full text-left text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">
                    Reviews
                </button>
                <button onclick="scrollToSection('contact')"
                    class="block w-full text-left text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">
                    Contact
                </button>
                <a href="{{ route('cart.index') }}"
                    class="relative inline-block text-gray-700 hover:text-blue-600 transition-colors">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        <span>Cart</span>
                        <span
                            class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </div>
                </a>
                <button onclick="scrollToSection('contact')"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors mt-4">
                    Book Now
                </button>
            </div>
        </div>
    </nav>


</header>
