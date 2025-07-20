@extends('website.layouts.app')

@section('content')
    <div class="pt-24 pb-20 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-6">
            <!-- Header Section -->
            <div class="mb-12">
                <div class="flex items-center space-x-4 mb-6">
                    <a href="{{ route('home.index') }}"
                        class="flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        <span>Back to Home</span>
                    </a>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        All Repair Services
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Professional electronics repair services with expert technicians, genuine parts, and comprehensive
                        warranties
                    </p>
                </div>

                <!-- Search and Filter Section -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex flex-col lg:flex-row gap-4 items-center">
                        <!-- Search -->
                        <div class="relative flex-1 max-w-md">
                            <i data-lucide="search"
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                            <input type="text" placeholder="Search services..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <!-- Category Filter -->
                        {{-- <div class="flex items-center space-x-2">
                            <i data-lucide="filter" class="w-5 h-5 text-gray-500"></i>
                            <select
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="all">All Categories</option>
                                @foreach ($serviceCategories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="flex flex-wrap justify-center gap-4 mb-12">
                            <a href="{{ route('home.index') }}"
                                class="category-filter px-6 py-3 rounded-full font-medium transition-all duration-300 {{ empty($selectedType) ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-600' }}">
                                All
                            </a>
                            @foreach ($deviceTypes as $device)
                            @php $slug = Str::slug($device->device_type_name); @endphp
                            <a href="{{ route('home.index', ['device_type' => $slug]) }}"
                                class="category-filter px-6 py-3 rounded-full font-medium transition-all duration-300 {{ $selectedType == $slug ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-600' }}">
                                {{ $device->device_type_name }}
                            </a>
                            @endforeach
                        </div>
    
                    </div>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="space-y-12">
                @foreach ($services as $service)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Category Header -->
                        <div class="bg-gradient-to-r {{ $category['color'] }} p-6 text-white">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i data-lucide="{{ $category['icon'] }}" class="w-8 h-8 text-white"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl md:text-3xl font-bold">{{ $category['name'] }}</h2>
                                    <p class="text-lg opacity-90">{{ $category['description'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Services List -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach ($category['services'] as $service)
                                    <div
                                        class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-all duration-300 group relative">
                                        @if (isset($service['popular']) && $service['popular'])
                                            <div
                                                class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                Popular
                                            </div>
                                        @endif

                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex-1">
                                                <h3
                                                    class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                                    {{ $service['name'] }}
                                                </h3>
                                                <p class="text-gray-600 mb-3 leading-relaxed">
                                                    {{ $service['description'] }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Service Details -->
                                        <div class="space-y-3 mb-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex items-center space-x-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i data-lucide="star"
                                                                class="w-4 h-4 {{ $i <= $service['rating'] ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                                        @endfor
                                                        <span
                                                            class="text-sm text-gray-600 ml-1">({{ $service['rating'] }})</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                                        <span>{{ $service['time'] }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                        <i data-lucide="shield" class="w-4 h-4"></i>
                                                        <span>{{ $service['warranty'] }} warranty</span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-2xl font-bold text-blue-600">${{ $service['price'] }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">Starting from</div>
                                                </div>
                                            </div>

                                            <!-- Includes -->
                                            @if (isset($service['includes']))
                                                <div>
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Service Includes:
                                                    </h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                                        @foreach ($service['includes'] as $include)
                                                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                                <i data-lucide="check-circle"
                                                                    class="w-4 h-4 text-green-500 flex-shrink-0"></i>
                                                                <span>{{ $include }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="{{ route('contact') }}"
                                                class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                                <span>Book Now</span>
                                            </a>
                                            <button
                                                class="flex-1 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                                                Get Quote
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Emergency Service Banner -->
            <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-2xl p-8 text-white text-center mt-12">
                <h3 class="text-2xl font-bold mb-2">Emergency Repair Service</h3>
                <p class="text-lg mb-4">Device broken urgently? We provide 24/7 emergency repair service</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                        <span class="font-semibold">Emergency Hotline: +1-555-URGENT-1</span>
                    </div>
                    <a href="tel:+1555URGENT1"
                        class="bg-white text-red-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Call Now
                    </a>
                </div>
            </div>

            <!-- Service Guarantees -->
            <div class="bg-white rounded-2xl p-8 mt-12 shadow-lg">
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-8">Our Service Guarantees</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="shield" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">90-Day Warranty</h4>
                        <p class="text-gray-600 text-sm">Comprehensive warranty on all repairs</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="wrench" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Genuine Parts</h4>
                        <p class="text-gray-600 text-sm">Only authentic, high-quality components</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Fast Service</h4>
                        <p class="text-gray-600 text-sm">Same-day repair for most services</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="star" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Expert Team</h4>
                        <p class="text-gray-600 text-sm">Certified technicians with years of experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
