@props(['maxWidth' => 'max-w-6xl', 'style' => 'default'])

@if ($style === 'card')
    <!-- Card Style Notifications (for Order Create) -->
    @if (session('success'))
        <div
            class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 alert-message">
            <svg class="text-emerald-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            </svg>
            <span class="text-emerald-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mx-8 mt-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 alert-message">
            <svg class="text-red-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="text-red-700 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mx-8 mt-6 p-4 bg-red-50 border border-red-200 rounded-xl alert-message">
            <div class="flex items-center gap-3 mb-2">
                <svg class="text-red-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-red-700 font-medium">Please fix the following errors:</span>
            </div>
            <ul class="space-y-1 ml-8">
                @foreach ($errors->all() as $error)
                    <li class="text-red-600 text-sm">• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@else
    <!-- Default Style Notifications -->
    @if (session('success'))
        <div class="{{ $maxWidth }} mx-auto mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 alert-message"
                role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                    </svg>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="{{ $maxWidth }} mx-auto mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 alert-message"
                role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif
@endif

<!-- Auto-hide script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.alert-message');
        notifications.forEach(function(notification) {
            setTimeout(function() {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(function() {
                    notification.remove();
                }, 500);
            }, 5000);
        });
    });
</script>
