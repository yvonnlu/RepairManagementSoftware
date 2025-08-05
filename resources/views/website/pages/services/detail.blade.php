@extends('website.layout.app')

@section('content')
    <style>
        .service-detail-card {
            transition: all 0.3s ease;
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

        .service-detail-card:hover .service-image::before {
            opacity: 1;
        }

        .feature-list li {
            position: relative;
            padding-left: 2rem;
        }

        .feature-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 0;
            color: #10b981;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>

    <div class="pt-24 pb-20 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Back to Services Button -->
            <div class="mb-6">
                <a href="{{ route('service.index') }}"
                    class="inline-flex items-center space-x-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    <span>Back to All Services</span>
                </a>
            </div>

            <!-- Breadcrumb -->
            <div class="flex items-center space-x-4 mb-8">
                <a href="{{ route('home.index') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Home
                </a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <a href="{{ route('service.index') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Services
                </a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                <span class="text-gray-600">{{ $service->device_type_name }} {{ $service->issue_category_name }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <!-- Service Image -->
                <div class="service-detail-card">
                    <div
                        class="service-image relative h-96 lg:h-[32rem] bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl overflow-hidden shadow-lg">
                        @if ($service->image_url)
                            <img src="{{ $service->image_url }}"
                                alt="{{ $service->device_type_name }} {{ $service->issue_category_name }} repair service - Professional {{ $service->issue_category_name }} fix"
                                title="{{ $service->device_type_name }} {{ $service->issue_category_name }} Repair"
                                class="w-full h-full object-contain p-8" loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="display: none;"
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                                <i data-lucide="{{ $service->default_icon }}" class="w-32 h-32 text-blue-600"
                                    title="{{ $service->issue_category_name }} repair icon"></i>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="{{ $service->default_icon }}" class="w-32 h-32 text-blue-600"
                                    title="{{ $service->issue_category_name }} repair service"></i>
                            </div>
                        @endif

                        <!-- Service Badges -->
                        <div class="absolute top-6 left-6">
                            <span
                                class="bg-white bg-opacity-90 text-blue-600 px-4 py-2 rounded-full text-sm font-medium shadow-sm backdrop-blur-sm">
                                {{ $service->device_type_name }}
                            </span>
                        </div>
                        <div class="absolute top-6 right-6">
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-lg font-bold shadow-sm">
                                ${{ $service->base_price }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Service Details -->
                <div class="space-y-8">
                    <!-- Header -->
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                            {{ $service->device_type_name }} {{ $service->issue_category_name }}
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            {{ $service->description }}
                        </p>
                    </div>

                    <!-- Service Features -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <i data-lucide="star" class="w-6 h-6 text-yellow-500"></i>
                            <span>Service Features</span>
                        </h3>
                        <ul class="feature-list space-y-3 text-gray-700">
                            <li>Professional diagnosis and repair</li>
                            <li>Genuine parts and components</li>
                            <li>90-day warranty on all repairs</li>
                            <li>Fast turnaround time</li>
                            <li>Expert certified technicians</li>
                            <li>No fix, no fee guarantee</li>
                        </ul>
                    </div>

                    <!-- Best Price Guarantee -->
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 text-white">
                        <div class="flex items-center justify-center space-x-3 mb-3">
                            <div class="bg-white bg-opacity-20 rounded-full p-2">
                                <i data-lucide="trophy" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold">Best Price Guarantee</h3>
                        </div>
                        <p class="text-center text-green-100 mb-4">
                            We offer the <strong>lowest prices</strong> in the market! Find a better deal? We'll beat it by
                            10%
                        </p>
                        <div class="flex items-center justify-center space-x-6 text-sm">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-green-200"></i>
                                <span>Price Match Promise</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-green-200"></i>
                                <span>Best Market Rate</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Actions -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <div class="mb-6">
                            <p class="text-3xl font-bold text-green-600">${{ $service->base_price }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="{{ route('payment.index', ['service_id' => $service->id]) }}"
                                class="bg-blue-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2 text-lg">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                                <span>Order Now</span>
                            </a>
                            <button data-url="{{ route('cart.add-service-to-cart', ['service' => $service->id]) }}"
                                data-service-id="{{ $service->id }}"
                                class="add-service-to-cart relative bg-gray-100 text-gray-700 px-6 py-4 rounded-lg font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center space-x-2 text-lg">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                <span>Add to Cart</span>
                                <span
                                    class="service-qty-badge absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">
                                    {{ isset($cart[$service->id]) ? $cart[$service->id]['qty'] : 0 }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 text-white">
                        <h3 class="text-xl font-bold mb-4 flex items-center space-x-2">
                            <i data-lucide="phone" class="w-6 h-6"></i>
                            <span>Need Help?</span>
                        </h3>
                        <p class="mb-4">Have questions about this service? Our experts are here to help!</p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="tel:+1-555-REPAIR-1"
                                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors flex items-center justify-center space-x-2">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                                <span>Call Now</span>
                            </a>
                            <button id="openQuoteModal"
                                class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-30 transition-colors flex items-center justify-center space-x-2">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Get Quote</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Process -->
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-16">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Repair Process</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-white">1</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Book Service</h4>
                        <p class="text-gray-600 text-sm">Schedule your repair appointment online or by phone</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-white">2</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Diagnosis</h4>
                        <p class="text-gray-600 text-sm">Free comprehensive diagnosis of your device</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-white">3</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Repair</h4>
                        <p class="text-gray-600 text-sm">Expert repair using genuine parts</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-white">4</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Quality Check</h4>
                        <p class="text-gray-600 text-sm">Thorough testing before return to customer</p>
                    </div>
                </div>
            </div>

            <!-- Related Services -->
            @if ($relatedServices && $relatedServices->count() > 0)
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Related Services</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($relatedServices as $relatedService)
                            <div
                                class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                                <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 relative">
                                    @if ($relatedService->image_url)
                                        <img src="{{ $relatedService->image_url }}"
                                            alt="{{ $relatedService->device_type_name }} {{ $relatedService->issue_category_name }}"
                                            class="w-full h-full object-contain p-4">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i data-lucide="{{ $relatedService->default_icon }}"
                                                class="w-16 h-16 text-blue-600"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            ${{ $relatedService->base_price }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">{{ $relatedService->issue_category_name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ Str::limit($relatedService->description, 80) }}</p>
                                    <a href="{{ route('service.detail', $relatedService->slug) }}"
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center space-x-1">
                                        <span>View Details</span>
                                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quote Request Modal (reuse from service listing page) -->
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
                    <p class="text-gray-600 mt-2">Tell us about your {{ $service->device_type_name }}
                        {{ $service->issue_category_name }} issue</p>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form action="{{ route('client.quote-request.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="device_type" value="{{ $service->device_type_name }}">
                        <input type="hidden" name="service_type" value="{{ $service->issue_category_name }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name
                                    *</label>
                                <input type="text" id="modal_name" name="name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your full name">
                            </div>
                            <div>
                                <label for="modal_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                    *</label>
                                <input type="email" id="modal_email" name="email" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="email@example.com">
                            </div>
                        </div>

                        <div>
                            <label for="modal_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number
                                *</label>
                            <input type="tel" id="modal_phone" name="phone" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="1234567890">
                        </div>

                        <div>
                            <label for="modal_issue" class="block text-sm font-medium text-gray-700 mb-2">Describe Your
                                Issue *</label>
                            <textarea id="modal_issue" name="issue" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Describe your {{ $service->device_type_name }} {{ $service->issue_category_name }} issue in detail..."></textarea>
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

            // Add to cart functionality
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
