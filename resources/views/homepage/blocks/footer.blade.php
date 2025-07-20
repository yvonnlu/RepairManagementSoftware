<footer class="bg-black text-white">
    <!-- Main Footer -->
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="settings" class="w-7 h-7 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">TechFix Pro</h3>
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
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition-colors">
                        <i data-lucide="youtube" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-400 transition-colors">
                        <i data-lucide="zap" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
            
            <!-- Services -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Services</h4>
                <ul class="space-y-3">
                    @php
                        $services = [
                            'Smartphone Repair',
                            'Laptop Repair', 
                            'Tablet Repair',
                            'Desktop PC Repair',
                            'Smartwatch Repair',
                            'Parts Replacement'
                        ];
                    @endphp
                    @foreach($services as $service)
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            {{ $service }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Quick Links</h4>
                <ul class="space-y-3">
                    @php
                        $quickLinks = [
                            'About Us',
                            'Services',
                            'Quote',
                            'News',
                            'Contact',
                            'Careers'
                        ];
                    @endphp
                    @foreach($quickLinks as $link)
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            {{ $link }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Support</h4>
                <ul class="space-y-3">
                    @php
                        $support = [
                            'Warranty Policy',
                            'User Guide',
                            'FAQ',
                            'Technical Support',
                            'Track Order',
                            'Returns'
                        ];
                    @endphp
                    @foreach($support as $item)
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors text-sm">
                            {{ $item }}
                        </a>
                    </li>
                    @endforeach
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
                <p>&copy; {{ date('Y') }} TechFix Pro. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-blue-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-400 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-blue-400 transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
