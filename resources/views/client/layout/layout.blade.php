{{-- resources/views/client/layout/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fixicon Client Area')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @stack('head')
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex flex-col">
        @include('website.blocks.header')
        <div class="flex flex-1 flex-col">
            <div class="w-full flex justify-center bg-white border-b mb-8 sticky top-16 z-30">
                <a href="{{ route('client.profile') }}"
                    class="px-6 py-3 text-sm font-semibold border-b-2 transition-all {{ request()->routeIs('client.profile') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-700 hover:text-blue-600' }}">
                    Client Information
                </a>
                <a href="{{ route('client.orders') }}"
                    class="px-6 py-3 text-sm font-semibold border-b-2 transition-all {{ request()->routeIs('client.orders') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-700 hover:text-blue-600' }}">
                    Order History
                </a>
            </div>
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
@stack('scripts')
</body>

</html>
