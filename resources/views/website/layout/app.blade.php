<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>{{ $seo['title'] ?? 'Fixicon - Professional Electronics Repair' }}</title>
    <meta name="description"
        content="{{ $seo['description'] ?? 'Expert electronics repair services for smartphones, tablets, laptops & more. Fast, reliable repairs with warranty.' }}">
    <meta name="keywords"
        content="{{ $seo['keywords'] ?? 'electronics repair, phone repair, laptop repair, professional repair services' }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Fixicon">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    {{-- Open Graph Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Fixicon">
    <meta property="og:title"
        content="{{ $seo['og_title'] ?? ($seo['title'] ?? 'Fixicon - Professional Electronics Repair') }}">
    <meta property="og:description"
        content="{{ $seo['og_description'] ?? ($seo['description'] ?? 'Expert electronics repair services for smartphones, tablets, laptops & more.') }}">
    <meta property="og:image" content="{{ $seo['og_image'] ?? asset('images/og-image.jpg') }}">
    <meta property="og:url" content="{{ $seo['og_url'] ?? url()->current() }}">
    <meta property="og:locale" content="en_US">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@TechFixPro">
    <meta name="twitter:title"
        content="{{ $seo['twitter_title'] ?? ($seo['title'] ?? 'Fixicon - Professional Electronics Repair') }}">
    <meta name="twitter:description"
        content="{{ $seo['twitter_description'] ?? ($seo['description'] ?? 'Expert electronics repair services with warranty.') }}">
    <meta name="twitter:image" content="{{ $seo['twitter_image'] ?? asset('images/og-image.jpg') }}">

    {{-- Structured Data --}}
    @if (isset($seo['structured_data']) && $seo['structured_data'])
        <script type="application/ld+json">
        {!! $seo['structured_data'] !!}
    </script>
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdn.tailwindcss.com">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>


    <style>
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-white">
    @include('website.blocks.header')


    @yield('content')
    @include('website.blocks.footer')

    <!-- jQuery CDN for all pages -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Smooth scrolling function
        function scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const isOpen = menu.classList.contains('hidden');

            if (isOpen) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }

        // Service modal functions
        function openServiceModal(serviceData) {
            const modal = document.getElementById('service-modal');
            const modalContent = document.getElementById('modal-content');

            // Populate modal with service data
            modalContent.innerHTML = generateModalContent(serviceData);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeServiceModal() {
            const modal = document.getElementById('service-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'unset';
        }

        function generateModalContent(service) {
            const stars = Array.from({
                    length: 5
                }, (_, i) =>
                `<i data-lucide="star" class="w-5 h-5 ${i < Math.floor(service.rating) ? 'text-yellow-400 fill-current' : 'text-gray-300'}"></i>`
            ).join('');

            const includes = service.includes ? service.includes.map(item =>
                `<div class="flex items-center space-x-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0"></i>
                    <span class="text-gray-700">${item}</span>
                </div>`
            ).join('') : '';

            return `
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-t-2xl">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <h2 class="text-2xl font-bold">${service.name}</h2>
                                ${service.popular ? '<span class="bg-orange-500 text-white text-xs font-medium px-2 py-1 rounded-full">Popular</span>' : ''}
                            </div>
                            <div class="flex items-center space-x-1 mb-3">
                                ${stars}
                                <span class="text-blue-100 ml-2">(${service.rating})</span>
                            </div>
                            <p class="text-blue-100">${service.description || ''}</p>
                        </div>
                        <button onclick="closeServiceModal()" class="ml-4 p-2 hover:bg-white/20 rounded-lg transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 p-4 rounded-xl">
                            <div class="text-green-600 text-sm font-medium mb-1">Service Price</div>
                            <div class="text-2xl font-bold text-green-700">$${service.price}</div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-xl">
                            <div class="text-blue-600 text-sm font-medium mb-1">Duration</div>
                            <div class="text-2xl font-bold text-blue-700 flex items-center">
                                <i data-lucide="clock" class="w-5 h-5 mr-2"></i>
                                ${service.time}
                            </div>
                        </div>
                    </div>
                    ${service.warranty ? `
                                <div class="bg-purple-50 p-4 rounded-xl">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <i data-lucide="shield" class="w-5 h-5 text-purple-600"></i>
                                        <span class="text-purple-600 font-medium">Warranty</span>
                                    </div>
                                    <p class="text-purple-700 font-semibold">${service.warranty}</p>
                                </div>
                                ` : ''}
                    ${includes ? `
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Service Includes:</h3>
                                    <div class="space-y-2">${includes}</div>
                                </div>
                                ` : ''}
                </div>
                <div class="p-6 bg-gray-50 rounded-b-2xl">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="scrollToSection('contact'); closeServiceModal();" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                            <span>Call for Consultation</span>
                        </button>
                    </div>
                </div>
            `;
        }

        // Filter services
        function filterServices(category) {
            const allCategories = document.querySelectorAll('.service-category');
            const filterButtons = document.querySelectorAll('.filter-btn');

            // Update active button
            filterButtons.forEach(btn => {
                if (btn.dataset.category === category) {
                    btn.classList.add('bg-blue-600', 'text-white', 'shadow-lg', 'transform', 'scale-105');
                    btn.classList.remove('bg-gray-100', 'text-gray-600');
                } else {
                    btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg', 'transform', 'scale-105');
                    btn.classList.add('bg-gray-100', 'text-gray-600');
                }
            });

            // Show/hide categories
            allCategories.forEach(cat => {
                if (category === 'all' || cat.dataset.category === category) {
                    cat.style.display = 'block';
                } else {
                    cat.style.display = 'none';
                }
            });
        }

        // Contact form submission
        function submitContactForm(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            // Here you would normally send the data to your Laravel backend
            alert('Thank you for contacting us! We will respond within 15 minutes.');
            event.target.reset();
        }

        // Initialize Lucide icons when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Header scroll effect
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                if (window.scrollY > 10) {
                    header.classList.add('shadow-lg');
                    header.classList.remove('shadow-sm');
                } else {
                    header.classList.remove('shadow-lg');
                    header.classList.add('shadow-sm');
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeServiceModal();
                }
            });

            // Close modal when clicking outside
            document.getElementById('service-modal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeServiceModal();
                }
            });
        });
    </script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin_asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('my-js')
</body>

</html>
