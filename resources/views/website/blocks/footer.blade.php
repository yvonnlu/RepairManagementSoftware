<footer class="bg-black text-white">
    <!-- Main Footer -->
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="settings" class="w-7 h-7 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">Fixicon</h3>
                        <p class="text-sm text-gray-400">Professional Repair</p>
                    </div>
                </div>

                <p class="text-gray-400 leading-relaxed">
                    Leading electronics repair service with professional technician team
                    and genuine parts.
                </p>

                <!-- Certifications -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="award" class="w-5 h-5 text-yellow-400"></i>
                        <span class="text-sm text-gray-300">ISO 9001:2015 Certified</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i data-lucide="shield" class="w-5 h-5 text-green-400"></i>
                        <span class="text-sm text-gray-300">Quality Insurance</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i data-lucide="zap" class="w-5 h-5 text-blue-400"></i>
                        <span class="text-sm text-gray-300">Modern Technology</span>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/iFixit/" target="_blank"
                        class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="https://www.youtube.com/user/iFixitYourself" target="_blank"
                        class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition-colors">
                        <i data-lucide="youtube" class="w-5 h-5"></i>
                    </a>
                    <a href="https://www.tiktok.com/@ifixit.com" target="_blank"
                        class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-pink-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.525 4.168c1.131-.896 2.563-1.428 4.162-1.428.063 0 .125.001.187.003v3.759c-.972-.093-1.881-.414-2.677-.917v4.415c0 3.314-2.686 6-6 6s-6-2.686-6-6 2.686-6 6-6c.315 0 .625.024.928.07v3.895c-.3-.055-.608-.085-.928-.085-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2V4.168zM18.787 5.5v-.671c-.972 0-1.868-.302-2.6-.815.732.513 1.628.815 2.6.815z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Our Services</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('service.index') }}"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            All Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.index') }}?device_type_name=Smartphone"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Smartphone Repair
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.index') }}?device_type_name=Laptop"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Laptop Repair
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.index') }}?device_type_name=Tablet"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Tablet Repair
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.index') }}?device_type_name=Desktop PC"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Desktop PC Repair
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.index') }}?device_type_name=Smartwatch"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Smartwatch Repair
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Quick Links</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home.index') }}"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.index') }}"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home.index') }}#contact"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Get Quote
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home.index') }}#contact"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Contact Us
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('cart.index') }}"
                                class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                                Shopping Cart
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.orders') }}"
                                class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                                Track Orders
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Customer Support -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Customer Support</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home.index') }}#features"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            90-Day Warranty
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home.index') }}#features"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Repair Process
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home.index') }}#testimonials"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Customer Reviews
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('client.profile') }}"
                                class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                                My Account
                            </a>
                        </li>
                    @endauth
                    <li>
                        <a href="{{ route('home.index') }}#contact"
                            class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            Technical Support
                        </a>
                    </li>
                    <li>
                        <span class="text-gray-400 text-sm">
                            24/7 Hotline: +1-555-123-4567
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="border-t border-gray-800 mt-12 pt-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center space-x-3">
                    <i data-lucide="phone" class="w-5 h-5 text-blue-400"></i>
                    <div>
                        <p class="text-sm text-gray-400">24/7 Hotline</p>
                        <p class="text-white font-medium">+1-555-123-4567</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <i data-lucide="mail" class="w-5 h-5 text-green-400"></i>
                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-white font-medium">support@techfixpro.com</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <i data-lucide="map-pin" class="w-5 h-5 text-purple-400"></i>
                    <div>
                        <p class="text-sm text-gray-400">Address</p>
                        <p class="text-white font-medium">123 Tech Street, Digital City, CA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="bg-gray-900 border-t border-gray-800">
        <div class="container mx-auto px-6 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Fixicon. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ route('home.index') }}#features"
                        class="hover:text-blue-400 transition-colors">Warranty Policy</a>
                    <a href="{{ route('home.index') }}#features" class="hover:text-blue-400 transition-colors">Terms
                        of Service</a>
                    <a href="{{ route('sitemap') }}" class="hover:text-blue-400 transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
