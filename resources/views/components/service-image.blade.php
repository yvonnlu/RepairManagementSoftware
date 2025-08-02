@props(['service', 'size' => 'medium', 'showFallback' => true])

@php
    $sizeClasses = match ($size) {
        'small' => 'w-8 h-8',
        'medium' => 'w-12 h-12',
        'large' => 'w-16 h-16',
        'xl' => 'w-20 h-20',
        default => 'w-12 h-12',
    };

    $iconSize = match ($size) {
        'small' => 'w-4 h-4',
        'medium' => 'w-6 h-6',
        'large' => 'w-8 h-8',
        'xl' => 'w-10 h-10',
        default => 'w-6 h-6',
    };
@endphp

<div
    class="flex-shrink-0 {{ $sizeClasses }} bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
    @if ($service->image_url)
        <img src="{{ $service->image_url }}" alt="{{ $service->issue_category_name }}"
            class="{{ $sizeClasses }} object-cover rounded-lg"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div style="display: none;" class="w-full h-full flex items-center justify-center">
            @if ($showFallback)
                <i data-lucide="{{ $service->default_icon }}" class="{{ $iconSize }} text-blue-600"></i>
            @endif
        </div>
    @else
        @if ($showFallback)
            <i data-lucide="{{ $service->default_icon }}" class="{{ $iconSize }} text-blue-600"></i>
        @endif
    @endif
</div>
