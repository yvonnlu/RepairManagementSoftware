<div class="h-full flex flex-col py-8 px-4 space-y-6">
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4">Account Menu</h2>
        <nav class="flex flex-col space-y-2">
            <a href="{{ route('client.profile') }}"
                class="sidebar-link {{ request()->routeIs('client.profile') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} px-4 py-2 rounded-lg font-medium flex items-center">
                <i data-lucide="user" class="w-5 h-5 mr-2"></i> Client Information
            </a>
            <a href="{{ route('client.orders') }}"
                class="sidebar-link {{ request()->routeIs('client.orders') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} px-4 py-2 rounded-lg font-medium flex items-center">
                <i data-lucide="list" class="w-5 h-5 mr-2"></i> Order History
            </a>
        </nav>
    </div>
</div>
<style>
    .sidebar-link.active,
    .sidebar-link.bg-blue-100 {
        font-weight: bold;
    }
</style>
