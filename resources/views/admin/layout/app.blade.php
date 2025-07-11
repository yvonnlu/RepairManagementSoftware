<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Shop Dashboard</title>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
</body>

</html>