<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixicon Admin Dashboard</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- SweetAlert2 for beautiful confirmations -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    @include('admin.blocks.header')
    @include('admin.blocks.sidebar')

    <!-- Main Content -->
    <div class="min-h-screen">
        <main class="pt-20 lg:pt-20 lg:pl-64 transition-all duration-300">
            <div class="container mx-auto px-4 py-6">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin_asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Admin Common Functions -->
    <script src="{{ asset('admin/js/admin-common.js') }}"></script>

    @yield('scripts')
</body>

</html>
