@extends('website.layout.app')

@section('content')
<div class="pt-24 pb-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 mt-20">
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
                            class="category-filter px-6 py-3 rounded-full font-medium transition-all duration-300 {{ empty($selectedType) ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-600' }}">
                            All
                        </a>
                        @foreach ($deviceTypes as $device)
                        @php $slug = Str::slug($device->device_type_name); @endphp
                        <a href="{{ route('service.index', ['device_type' => $slug]) }}"
                            class="category-filter px-6 py-3 rounded-full font-medium transition-all duration-300 {{ $selectedType == $slug ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-600' }}">
                            {{ $device->device_type_name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <!-- Services Grid -->
        @foreach($servicesByDevice as $deviceType => $serviceList)
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white rounded-2xl mb-8">
            <h2 class="text-2xl md:text-3xl font-bold">{{ $deviceType }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            @foreach($serviceList as $service)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-6 flex flex-col">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $service->issue_category_name }}</h3>
                <p class="text-gray-600 mb-3 leading-relaxed flex-1">{{ $service->description }}</p>
                <div class="flex items-center space-x-2 text-sm text-gray-600 mb-2">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span>2-3 days</span>
                </div>
                <div class="text-2xl font-bold text-blue-600 mb-2">${{ $service->base_price }}</div>

                <div class="flex gap-3 mt-4">
                    {{-- <a href="{{ route('payment.index') }}"  --}}
                    <a href="{{ route('payment.index', ['service_id' => $service->id]) }}"
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                        <span>Order Now</span>
                    </a>
                    <button data-url="{{ route('cart.add-service-to-cart', ['service' => $service->id]) }}" data-service-id="{{ $service->id }}" class="add-service-to-cart relative flex-1 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                        Add to Cart
                        <span class="service-qty-badge absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ isset($cart[$service->id]) ? $cart[$service->id]['qty'] : 0 }}
                        </span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
        <!-- Others Service Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-6 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 mb-12">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Other Issues?</h3>
            <p class="text-gray-600 mb-4 leading-relaxed text-center max-w-md">
                For repair services not listed above, we are unable to provide an exact quote without a thorough inspection of your device. If you have a different issue, please leave your information here and our team will contact you with a personalized quote.
            </p>
            <a href="" class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors flex items-center justify-center space-x-2 mt-2">
                <i data-lucide="help-circle" class="w-5 h-5"></i>
                <span>Get Quote</span>
            </a>
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
</div>
@endsection


@section('my-js')
<script type="text/javascript">
    $(document).ready(function() {
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