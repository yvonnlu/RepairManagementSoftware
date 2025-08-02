@extends('website.layout.app')

@section('content')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-4px);
        }

        .service-image {
            position: relative;
            overflow: hidden;
        }

        .service-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-card:hover .service-image::before {
            opacity: 1;
        }
    </style>

    <div class="pt-24 pb-20 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-8">
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
                <div class="bg-white rounded-2xl p-0 shadow-lg flex flex-col justify-center items-center min-h-[80px]">
                    <div class="w-full flex justify-center">
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="{{ route('service.index') }}"
                                class="category-filter px-6 py-3 rounded-full font-medium transition-all duration-300 flex items-center space-x-2 {{ empty($selectedType) ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-600' }}">
                                <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                                <span>All</span>
                            </a>
                            @foreach ($deviceTypes as $device)
                                @php $slug = Str::slug($device->device_type_name); @endphp
                                <a href="{{ route('service.index', ['device_type' => $slug]) }}"
                                    class="category-filter px-6 py-3 rounded-full font-medium transition-all duration-300 flex items-center space-x-2 {{ $selectedType == $slug ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-600' }}">
                                    @switch($device->device_type_name)
                                        @case('Smartphone')
                                            <i data-lucide="smartphone" class="w-4 h-4"></i>
                                        @break

                                        @case('Tablet')
                                            <i data-lucide="tablet" class="w-4 h-4"></i>
                                        @break

                                        @case('Desktop PC')
                                            <i data-lucide="monitor" class="w-4 h-4"></i>
                                        @break

                                        @case('Laptop')
                                            <i data-lucide="laptop" class="w-4 h-4"></i>
                                        @break

                                        @case('Smartwatch')
                                            <i data-lucide="watch" class="w-4 h-4"></i>
                                        @break

                                        @default
                                            <i data-lucide="wrench" class="w-4 h-4"></i>
                                    @endswitch
                                    <span>{{ $device->device_type_name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            @foreach ($servicesByDevice as $deviceType => $serviceList)
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white rounded-2xl mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            @switch($deviceType)
                                @case('Smartphone')
                                    <i data-lucide="smartphone" class="w-6 h-6 text-white"></i>
                                @break

                                @case('Tablet')
                                    <i data-lucide="tablet" class="w-6 h-6 text-white"></i>
                                @break

                                @case('Desktop PC')
                                    <i data-lucide="monitor" class="w-6 h-6 text-white"></i>
                                @break

                                @case('Laptop')
                                    <i data-lucide="laptop" class="w-6 h-6 text-white"></i>
                                @break

                                @case('Smartwatch')
                                    <i data-lucide="watch" class="w-6 h-6 text-white"></i>
                                @break

                                @default
                                    <i data-lucide="wrench" class="w-6 h-6 text-white"></i>
                            @endswitch
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold">{{ $deviceType }}</h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 mb-12">
                    @foreach ($serviceList as $service)
                        <div
                            class="service-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                            <!-- Ultra Large Service Image -->
                            <div
                                class="service-image relative h-80 md:h-96 lg:h-[28rem] bg-gradient-to-br from-blue-100 to-blue-200">
                                @if ($service->image_url)
                                    <img src="{{ $service->image_url }}" 
                                         alt="{{ $service->device_type_name }} {{ $service->issue_category_name }} repair service - Professional {{ $service->issue_category_name }} fix"
                                         title="{{ $service->device_type_name }} {{ $service->issue_category_name }} Repair"
                                         class="w-full h-full object-contain p-4"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none;"
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                                        <i data-lucide="{{ $service->default_icon }}" class="w-20 h-20 text-blue-600" title="{{ $service->issue_category_name }} repair icon"></i>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="{{ $service->default_icon }}" class="w-20 h-20 text-blue-600" title="{{ $service->issue_category_name }} repair service"></i>
                                    </div>
                                @endif

                                <!-- Device Type Badge -->
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="bg-white bg-opacity-90 text-blue-600 px-3 py-1 rounded-full text-sm font-medium shadow-sm backdrop-blur-sm">
                                        {{ $service->device_type_name }}
                                    </span>
                                </div>

                                <!-- Price Badge -->
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                                        ${{ $service->base_price }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $service->issue_category_name }}</h3>
                                <p class="text-gray-600 mb-4 leading-relaxed line-clamp-3">{{ $service->description }}</p>

                                <!-- Service Features -->
                                <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                        <span>Quick Service</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                                        <span>Warranty</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('payment.index', ['service_id' => $service->id]) }}"
                                        class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                                        <span>Order Now</span>
                                    </a>
                                    <button data-url="{{ route('cart.add-service-to-cart', ['service' => $service->id]) }}"
                                        data-service-id="{{ $service->id }}"
                                        class="add-service-to-cart relative bg-gray-100 text-gray-700 px-4 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center space-x-2 sm:flex-initial sm:w-auto">
                                        <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                        <span class="sm:hidden">Add to Cart</span>
                                        <span class="hidden sm:inline">Cart</span>
                                        <span
                                            class="service-qty-badge absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                            {{ isset($cart[$service->id]) ? $cart[$service->id]['qty'] : 0 }}
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <!-- Others Service Card -->
            <div
                class="bg-white rounded-2xl shadow-lg overflow-hidden p-6 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 mb-12">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Other Issues?</h3>
                <p class="text-gray-600 mb-4 leading-relaxed text-center max-w-md">
                    For repair services not listed above, we are unable to provide an exact quote without a thorough
                    inspection of your device. If you have a different issue, please leave your information here and our
                    team will contact you with a personalized quote.
                </p>
                <button id="openQuoteModal"
                    class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors flex items-center justify-center space-x-2 mt-2">
                    <i data-lucide="help-circle" class="w-5 h-5"></i>
                    <span>Get Quote</span>
                </button>
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

    <!-- Quote Request Modal -->
    <div id="quoteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-gray-900">Get Custom Quote</h3>
                        <button id="closeQuoteModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 mt-2">Tell us about your device issue and we'll provide a personalized quote
                    </p>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-6 bg-green-500/20 border border-green-500/30 text-green-100 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
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
                                <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name
                                    *</label>
                                <input type="text" id="modal_name" name="name" required
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                    placeholder="Enter your full name">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="modal_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                    *</label>
                                <input type="email" id="modal_email" name="email" required
                                    value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    placeholder="email@example.com">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="modal_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone
                                Number *</label>
                            <input type="tel" id="modal_phone" name="phone" required value="{{ old('phone') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                placeholder="1234567890">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="modal_device_type" class="block text-sm font-medium text-gray-700 mb-2">Device
                                Type *</label>
                            <select id="modal_device_type" name="device_type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('device_type') border-red-500 @enderror">
                                <option value="">Select device type</option>
                                @if (isset($deviceTypes))
                                    @foreach ($deviceTypes as $deviceType)
                                        <option value="{{ $deviceType->device_type_name }}"
                                            {{ old('device_type') == $deviceType->device_type_name ? 'selected' : '' }}>
                                            {{ $deviceType->device_type_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('device_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="modal_issue" class="block text-sm font-medium text-gray-700 mb-2">Issue
                                Description *</label>
                            <textarea id="modal_issue" name="issue" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('issue') border-red-500 @enderror"
                                placeholder="Describe the device issue in detail...">{{ old('issue') }}</textarea>
                            @error('issue')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="button" id="cancelQuoteModal"
                                class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center space-x-2">
                                <i data-lucide="send" class="w-5 h-5"></i>
                                <span>Send Quote Request</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('my-js')
    <script type="text/javascript">
        $(document).ready(function() {
            // Modal functionality
            $('#openQuoteModal').on('click', function() {
                $('#quoteModal').removeClass('hidden');
            });

            $('#closeQuoteModal, #cancelQuoteModal').on('click', function() {
                $('#quoteModal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#quoteModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // Existing cart functionality
            $('.add-service-to-cart').on('click', function(e) {
                var $button = $(this);
                var url = $button.data('url');

                $.ajax({
                    method: "GET",
                    url: url,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1000
                        });

                        // Update badge near this button
                        $button.find('.service-qty-badge').text(response.service_qty);

                        // Update cart icon badge in header
                        $('.cart-qty-badge').text(response.total_qty);
                    },
                    statusCode: {
                        401: function() {
                            window.location.href = "{{ route('login') }}";
                        }
                    }
                });
            });
        });
    </script>
@endsection
