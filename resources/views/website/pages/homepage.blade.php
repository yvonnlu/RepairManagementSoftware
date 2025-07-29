@extends('website.layout.app')

@section('content')

<body class="min-h-screen bg-white">

    <main>
        <!-- Hero Section -->
        <section id="home"
            class="pt-24 pb-20 bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900 text-white overflow-hidden">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Content -->
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <div
                                class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                                <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                                <span class="text-sm font-medium">Trusted by 50,000+ customers</span>
                            </div>

                            <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                                Professional
                                <span
                                    class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                                    Electronics Repair</span>
                                <br />Services
                            </h1>

                            <p class="text-xl text-blue-100 leading-relaxed">
                                Fast, reliable, and affordable repair services for all your electronic devices.
                                Expert technicians, genuine parts, and 90-day warranty guaranteed.
                            </p>
                        </div>

                        <!-- Features List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-400 flex-shrink-0"></i>
                                <span>Same-day repair</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-400 flex-shrink-0"></i>
                                <span>90-day warranty</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-400 flex-shrink-0"></i>
                                <span>Genuine parts</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-400 flex-shrink-0"></i>
                                <span>Free pickup & delivery</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="scrollToSection('contact')"
                                class="bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-8 py-4 rounded-lg font-bold hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center group">
                                Book Repair Now
                                <i data-lucide="arrow-right"
                                    class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                            <button onclick="scrollToSection('services')"
                                class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition-all duration-300 flex items-center justify-center">
                                <i data-lucide="play" class="w-5 h-5 mr-2"></i>
                                View Services
                            </button>
                        </div>
                    </div>

                    <!-- Hero Image/Graphics -->
                    <div class="relative">
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 transform hover:scale-105 transition-transform duration-300">
                            <!-- Service Preview Cards -->
                            <div class="space-y-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">90-Day Warranty</h3>
                                        <p class="text-sm text-blue-200">Quality guarantee</p>
                                    </div>
                                </div>

                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                        <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Fixed in 30 Minutes</h3>
                                        <p class="text-sm text-blue-200">Fast and efficient</p>
                                    </div>
                                </div>

                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <i data-lucide="star" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">4.9/5 Rating</h3>
                                        <p class="text-sm text-blue-200">Customer satisfaction</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-20 animate-pulse">
                        </div>
                        <div
                            class="absolute -bottom-8 -left-8 w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full opacity-20 animate-pulse delay-1000">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Impressive Numbers</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">We're proud of the achievements we've made
                        throughout our customer service journey</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    <div
                        class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="users" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">50,000+</div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Happy Customers</div>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="wrench" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">100,000+</div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Devices Repaired</div>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="star" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">4.9/5</div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Average Rating</div>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">30 min</div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Average Repair Time</div>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="award" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">7 years</div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Experience</div>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="thumbs-up" class="w-8 h-8 text-white"></i>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">99%</div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Success Rate</div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Services Overview Section -->
        <section id="services" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Professional Electronics Repair Services
                    </h2>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                        We specialize in comprehensive electronics repair services using cutting-edge diagnostic technology,
                        genuine replacement parts, and expert craftsmanship. From everyday devices to specialized equipment,
                        our certified technicians deliver reliable solutions with industry-leading warranties.
                    </p>
                </div>

                <!-- Service Highlights -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                    <!-- Mobile Device Repair -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start space-x-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="smartphone" class="w-8 h-8 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        Mobile Device Repair
                                    </h3>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-500">25,000+ repaired</div>
                                        <div class="text-sm font-bold text-green-600">4.9/5</div>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Expert repair for smartphones and tablets with genuine parts, fast turnaround times, and comprehensive warranty coverage for all repairs.
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Screen replacement</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Battery replacement</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Water damage repair</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Camera & speaker fixes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Computer & Laptop Repair -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start space-x-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="laptop" class="w-8 h-8 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        Computer & Laptop Repair
                                    </h3>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-500">15,000+ repaired</div>
                                        <div class="text-sm font-bold text-green-600">4.8/5</div>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Professional computer repair services for all brands and operating systems, from basic troubleshooting to complex motherboard repairs.
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Hardware diagnostics</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Software troubleshooting</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Performance optimization</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Data recovery</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gaming & Desktop Systems -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start space-x-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="monitor" class="w-8 h-8 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        Gaming & Desktop Systems
                                    </h3>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-500">8,000+ repaired</div>
                                        <div class="text-sm font-bold text-green-600">4.9/5</div>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Specialized repair and upgrade services for gaming PCs and workstations, ensuring optimal performance for demanding applications.
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Graphics card repair</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>System upgrades</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Custom builds</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Cooling solutions</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wearable Technology -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start space-x-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="watch" class="w-8 h-8 text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        Wearable Technology
                                    </h3>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-500">3,000+ repaired</div>
                                        <div class="text-sm font-bold text-green-600">4.7/5</div>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Expert repair services for smartwatches and other wearable devices, restoring functionality and water resistance.
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Screen replacement</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Battery service</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Water resistance restoration</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                        <span>Button repairs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="text-center">
                    <a href="{{ route('service.index') }}"
   class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 mx-auto">
    <span>View All Services</span>
    <i data-lucide="arrow-right" class="w-5 h-5"></i>
</a>

                    <p class="text-gray-600 mt-4">
                        Explore our complete range of repair services and get instant quotes
                    </p>
                </div>
            </div>
        </section>
        <!-- Features Section -->
        <section id="features" class="py-10 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose TechFix Pro?</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">We combine expert craftsmanship with
                        cutting-edge technology to deliver the best repair experience</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="shield" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            90-Day Warranty</h3>
                        <p class="text-gray-600 leading-relaxed">All repair services come with comprehensive 90-day
                            warranty</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Same-Day Repair</h3>
                        <p class="text-gray-600 leading-relaxed">Most repairs completed within hours, not days</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="star" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Expert Technicians</h3>
                        <p class="text-gray-600 leading-relaxed">Certified team with years of industry experience</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="thumbs-up" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Genuine Parts</h3>
                        <p class="text-gray-600 leading-relaxed">Only use genuine and highest quality replacement parts
                        </p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="award" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Quality Certified</h3>
                        <p class="text-gray-600 leading-relaxed">Certified by reputable organizations in the technology
                            industry</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="zap" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Modern Technology</h3>
                        <p class="text-gray-600 leading-relaxed">Using the most advanced repair equipment and
                            technology</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="users" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            24/7 Support</h3>
                        <p class="text-gray-600 leading-relaxed">Customer support team always ready to serve at any
                            time</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 text-center group hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-shadow duration-300">
                            <i data-lucide="settings" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            Free Pickup & Delivery</h3>
                        <p class="text-gray-600 leading-relaxed">Completely free device pickup and delivery service</p>
                    </div>
                </div>

                <!-- Process Section -->
                <div class="mt-20">
                    <div class="text-center mb-12">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Repair Process</h3>
                        <p class="text-lg text-gray-600">Professional and transparent repair process</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl">
                                01</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Inspection</h4>
                            <p class="text-gray-600">Detailed device inspection and diagnosis</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl">
                                02</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Quote</h4>
                            <p class="text-gray-600">Accurate and transparent cost estimate</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl">
                                03</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Repair</h4>
                            <p class="text-gray-600">Perform repair with genuine parts</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl">
                                04</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Delivery</h4>
                            <p class="text-gray-600">Quality check and device delivery to customer</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Don't just take our word for it - hear from
                        customers who have used our services</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-gray-50 rounded-xl p-6 relative hover:shadow-lg transition-shadow duration-300 group">
                        <!-- Quote Icon -->
                        <div class="absolute top-4 right-4">
                            <i data-lucide="quote"
                                class="w-8 h-8 text-blue-200 group-hover:text-blue-300 transition-colors"></i>
                        </div>
                        <!-- Rating -->
                        <div class="flex items-center space-x-1 mb-4">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        </div>
                        <!-- Comment -->
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Amazing service! My phone was fixed in 30 minutes and looks brand new. Staff is very
                            professional and pricing is reasonable."
                        </p>
                        <!-- Customer Info -->
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                SJ
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Sarah Johnson</div>
                                <div class="text-sm text-blue-600 font-medium">iPhone Screen Replacement</div>
                                <div class="text-xs text-gray-500">Downtown, CA</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-6 relative hover:shadow-lg transition-shadow duration-300 group">
                        <div class="absolute top-4 right-4">
                            <i data-lucide="quote"
                                class="w-8 h-8 text-blue-200 group-hover:text-blue-300 transition-colors"></i>
                        </div>
                        <div class="flex items-center space-x-1 mb-4">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "My laptop battery was replaced very quickly. After repair, the machine runs much smoother.
                            I am very satisfied with the service."
                        </p>
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                MC
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Mike Chen</div>
                                <div class="text-sm text-blue-600 font-medium">Laptop Battery Replacement</div>
                                <div class="text-xs text-gray-500">Tech District, CA</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-6 relative hover:shadow-lg transition-shadow duration-300 group">
                        <div class="absolute top-4 right-4">
                            <i data-lucide="quote"
                                class="w-8 h-8 text-blue-200 group-hover:text-blue-300 transition-colors"></i>
                        </div>
                        <div class="flex items-center space-x-1 mb-4">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Repair quality exceeded expectations. iPad looks like new, touch is very responsive. 90-day
                            warranty gives peace of mind."
                        </p>
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                ED
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Emily Davis</div>
                                <div class="text-sm text-blue-600 font-medium">iPad Screen Repair</div>
                                <div class="text-xs text-gray-500">Silicon Valley, CA</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-6 relative hover:shadow-lg transition-shadow duration-300 group">
                        <div class="absolute top-4 right-4">
                            <i data-lucide="quote"
                                class="w-8 h-8 text-blue-200 group-hover:text-blue-300 transition-colors"></i>
                        </div>
                        <div class="flex items-center space-x-1 mb-4">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Technical team is very professional, detailed consultation on suitable configuration.
                            Computer runs very fast and stable after upgrade."
                        </p>
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                DW
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">David Wilson</div>
                                <div class="text-sm text-blue-600 font-medium">PC Upgrade</div>
                                <div class="text-xs text-gray-500">Digital City, CA</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-6 relative hover:shadow-lg transition-shadow duration-300 group">
                        <div class="absolute top-4 right-4">
                            <i data-lucide="quote"
                                class="w-8 h-8 text-blue-200 group-hover:text-blue-300 transition-colors"></i>
                        </div>
                        <div class="flex items-center space-x-1 mb-4">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Apple Watch with broken screen was repaired beautifully. Price is cheaper than official
                            service center but quality is not inferior."
                        </p>
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                LA
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Lisa Anderson</div>
                                <div class="text-sm text-blue-600 font-medium">Apple Watch Repair</div>
                                <div class="text-xs text-gray-500">Beverly Hills, CA</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-6 relative hover:shadow-lg transition-shadow duration-300 group">
                        <div class="absolute top-4 right-4">
                            <i data-lucide="quote"
                                class="w-8 h-8 text-blue-200 group-hover:text-blue-300 transition-colors"></i>
                        </div>
                        <div class="flex items-center space-x-1 mb-4">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Phone dropped in water was successfully rescued. Important data was completely preserved.
                            Thank you TechFix Pro team so much!"
                        </p>
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                JR
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">James Rodriguez</div>
                                <div class="text-sm text-blue-600 font-medium">Water Damage Repair</div>
                                <div class="text-xs text-gray-500">Santa Monica, CA</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-16 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-blue-600 mb-2">4.9/5</div>
                            <div class="text-sm text-gray-600">Average Rating</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600 mb-2">10,000+</div>
                            <div class="text-sm text-gray-600">Positive Reviews</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600 mb-2">99%</div>
                            <div class="text-sm text-gray-600">Customer Satisfaction</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-orange-600 mb-2">95%</div>
                            <div class="text-sm text-gray-600">Return Customers</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 text-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Contact Us for Repair Today</h2>
                    <p class="text-xl text-blue-100 max-w-3xl mx-auto">Ready to repair your device? Contact us now for
                        free quote and fast service.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-2xl font-bold mb-6 flex items-center">
                                <i data-lucide="message-square" class="w-6 h-6 mr-3 text-blue-400"></i>
                                Contact Information
                            </h3>

                            <div class="space-y-6">
                                <div
                                    class="flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-xl hover:bg-white/15 transition-colors">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="phone" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white mb-1">24/7 Hotline</h4>
                                        <p class="text-blue-100 font-medium mb-1">+1-555-123-4567</p>
                                        <p class="text-sm text-blue-200">Call now for free consultation</p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-xl hover:bg-white/15 transition-colors">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="mail" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white mb-1">Support Email</h4>
                                        <p class="text-blue-100 font-medium mb-1">support@techfixpro.vn</p>
                                        <p class="text-sm text-blue-200">Send email for detailed support</p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-xl hover:bg-white/15 transition-colors">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="map-pin" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white mb-1">Store Address</h4>
                                        <p class="text-blue-100 font-medium mb-1">123 Tech Street, Digital City, CA</p>
                                        <p class="text-sm text-blue-200">Visit our store directly for repairs</p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-start space-x-4 p-4 bg-white/10 backdrop-blur-sm rounded-xl hover:bg-white/15 transition-colors">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white mb-1">Business Hours</h4>
                                        <p class="text-blue-100 font-medium mb-1">Mon-Sat: 8:00-20:00, Sun: 9:00-18:00
                                        </p>
                                        <p class="text-sm text-blue-200">Serving 7 days a week</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                            <h4 class="text-xl font-bold mb-4 flex items-center">
                                <i data-lucide="calendar" class="w-5 h-5 mr-2 text-green-400"></i>
                                Quick Booking
                            </h4>
                            <div class="space-y-3">
                                <button
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                    <i data-lucide="phone" class="w-5 h-5 mr-2"></i>
                                    Call Now: +1-555-123-4567
                                </button>
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors">
                                    Book via WhatsApp
                                </button>
                            </div>
                            <p class="text-sm text-blue-200 mt-3 text-center">
                                Response within 15 minutes • Free consultation
                            </p>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8">
                        <h3 class="text-2xl font-bold mb-6 flex items-center">
                            <i data-lucide="send" class="w-6 h-6 mr-3 text-green-400"></i>
                            Send Quote Request
                        </h3>

                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="mb-6 bg-green-500/20 border border-green-500/30 text-green-100 px-4 py-3 rounded-lg">
                                <div class="flex items-center">
                                    <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-100 px-4 py-3 rounded-lg">
                                <div class="flex items-center">
                                    <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('client.quote-request.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-blue-100 mb-2">Full Name *</label>
                                    <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-blue-200 backdrop-blur-sm @error('name') border-red-500 @enderror"
                                        placeholder="Enter your full name">
                                    @error('name')
                                        <span class="text-red-300 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-blue-100 mb-2">Email *</label>
                                    <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-blue-200 backdrop-blur-sm @error('email') border-red-500 @enderror"
                                        placeholder="email@example.com">
                                    @error('email')
                                        <span class="text-red-300 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-blue-100 mb-2">Phone Number</label>
                                <input type="number" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-blue-200 backdrop-blur-sm @error('phone') border-red-500 @enderror"
                                    placeholder="1234567890">
                                @error('phone')
                                    <span class="text-red-300 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="device_type" class="block text-sm font-medium text-blue-100 mb-2">Device Type *</label>
                                <select id="device_type" name="device_type" required
                                    class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white backdrop-blur-sm @error('device_type') border-red-500 @enderror">
                                    <option value="" class="bg-gray-800">Select device type</option>
                                    @foreach($deviceTypes as $deviceType)
                                        <option value="{{ $deviceType->device_type_name }}" class="bg-gray-800" {{ old('device_type') == $deviceType->device_type_name ? 'selected' : '' }}>
                                            {{ $deviceType->device_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_type')
                                    <span class="text-red-300 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="issue" class="block text-sm font-medium text-blue-100 mb-2">Issue Description</label>
                                <textarea id="issue" name="issue" rows="4"
                                    class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-blue-200 backdrop-blur-sm @error('issue') border-red-500 @enderror"
                                    placeholder="Describe the device issue in detail...">{{ old('issue') }}</textarea>
                                @error('issue')
                                    <span class="text-red-300 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center space-x-2 transform hover:scale-105">
                                <i data-lucide="send" class="w-5 h-5"></i>
                                <span>Send Quote Request</span>
                            </button>
                        </form>

                        <p class="text-center text-sm text-blue-200 mt-4">
                            We will contact you within <span class="font-semibold text-green-400">15 minutes</span> for
                            detailed consultation
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        let isMenuOpen = false;

        mobileMenuBtn.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen;
            if (isMenuOpen) {
                mobileMenu.classList.remove('hidden');
                mobileMenuBtn.innerHTML = '<i data-lucide="x" class="w-6 h-6"></i>';
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.innerHTML = '<i data-lucide="menu" class="w-6 h-6"></i>';
            }
            lucide.createIcons();
        });

        // Smooth scrolling
        function scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth'
                });
                // Close mobile menu if open
                if (isMenuOpen) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.innerHTML = '<i data-lucide="menu" class="w-6 h-6"></i>';
                    isMenuOpen = false;
                    lucide.createIcons();
                }
            }
        }

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 10) {
                header.classList.add('shadow-lg');
                header.classList.remove('bg-white/95');
                header.classList.add('bg-white');
            } else {
                header.classList.remove('shadow-lg');
                header.classList.remove('bg-white');
                header.classList.add('bg-white/95');
            }
        });

        // Service filtering
        function filterServices(category) {
            const categoryFilters = document.querySelectorAll('.category-filter');
            const serviceCategories = document.querySelectorAll('.service-category');

            // Update filter buttons
            categoryFilters.forEach(filter => {
                filter.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-lg', 'transform',
                    'scale-105');
                filter.classList.add('bg-gray-100', 'text-gray-600');
            });

            event.target.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-lg', 'transform', 'scale-105');
            event.target.classList.remove('bg-gray-100', 'text-gray-600');

            // Show/hide service categories
            serviceCategories.forEach(serviceCategory => {
                if (category === 'all') {
                    serviceCategory.style.display = 'block';
                } else {
                    if (serviceCategory.classList.contains(category)) {
                        serviceCategory.style.display = 'block';
                    } else {
                        serviceCategory.style.display = 'none';
                    }
                }
            });
        }

        // Service modal
        function openServiceModal(serviceId) {
            const modal = document.getElementById('service-modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeServiceModal() {
            const modal = document.getElementById('service-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bookService() {
            alert('Thank you for booking! We will contact you within 15 minutes.');
            closeServiceModal();
        }

        // Close modal when clicking outside
        document.getElementById('service-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeServiceModal();
            }
        });

        // Initialize icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            
            // Scroll to form if there are flash messages
            @if(session('success') || session('error') || $errors->any())
                document.getElementById('contact').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            @endif
            
            // Filter services by device type
            const categoryFilters = document.querySelectorAll('.category-filter');
            const serviceCategories = document.querySelectorAll('.service-category');

            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function(event) {
                    const category = this.getAttribute('data-filter');
                    // Xử lý active button
                    categoryFilters.forEach(btn => btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg', 'scale-105'));
                    this.classList.add('bg-blue-600', 'text-white', 'shadow-lg', 'scale-105');

                    // Lọc service
                    serviceCategories.forEach(serviceCategory => {
                        if (category === 'all' || serviceCategory.classList.contains(slugify(category))) {
                            serviceCategory.style.display = 'block';
                        } else {
                            serviceCategory.style.display = 'none';
                        }
                    });
                });
            });

            // Hàm chuyển text thành slug (giống Str::slug của Laravel)
            function slugify(text) {
                return text.toString().toLowerCase()
                    .normalize('NFD').replace(/\u0300-\u036f/g, '') // Remove accents
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/\-\-+/g, '-') // Replace multiple - with single -
                    .replace(/^-+/, '') // Trim - from start of text
                    .replace(/-+$/, ''); // Trim - from end of text
            }
        });
    </script>
</body>
@endsection