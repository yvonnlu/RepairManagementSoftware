@php
$menuItems = [
['id' => 'profile', 'label' => 'Profile', 'icon' => 'user', 'route' => 'profile.index'],
['id' => 'book-service', 'label' => 'Book Service', 'icon' => 'package', 'route' => 'services.book'],
['id' => 'payment', 'label' => 'Payment', 'icon' => 'credit-card', 'route' => 'payments.index'],
['id' => 'track-order', 'label' => 'Track Orders', 'icon' => 'clock', 'route' => 'orders.track'],
];
$currentRoute = 'profile.index'; // Tạm gán route mock để test active menu
@endphp

<!-- Mobile Overlay -->
<div
    id="sidebar-overlay"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden"
    onclick="closeSidebar()"></div>

<!-- Sidebar -->
<div
    id="sidebar"
    class="w-64 bg-white shadow-lg h-screen fixed left-0 top-0 z-50 border-r border-gray-200 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">RepairPro</h1>
                    <p class="text-sm text-gray-600">Admin Panel</p>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button
                onclick="closeSidebar()"
                class="lg:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 flex-1 overflow-y-auto">
        @foreach($menuItems as $item)
        @php
        $isActive = $currentRoute === $item['route'] ||
        str_starts_with($currentRoute, str_replace('.index', '', $item['route']));
        @endphp

        <a href=""
            class="w-full flex items-center px-6 py-3 text-left transition-all duration-200 {{ $isActive 
                   ? 'bg-blue-50 text-blue-700 border-r-3 border-blue-600 font-medium' 
                   : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

            {{-- @include('components.icons.' . $item['icon'], [
                    'class' => 'w-5 h-5 mr-3 ' . ($isActive ? 'text-blue-600' : 'text-gray-400')
                ]) --}}

            {{ $item['label'] }}
        </a>
        @endforeach
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200 bg-white">
        <div class="text-center">
            <p class="text-xs text-gray-500">RepairPro v2.0</p>
            <p class="text-xs text-gray-400">Professional Repair Management</p>
        </div>
    </div>
</div>

<script>
    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        if (overlay) overlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });
</script>




