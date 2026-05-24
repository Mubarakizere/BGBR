@props(['type' => 'success', 'message' => ''])

@php
    $classes = [
        'success' => 'bg-success/10 border-success/30 text-success',
        'error' => 'bg-danger/10 border-danger/30 text-danger',
        'warning' => 'bg-yellow-500/10 border-yellow-500/30 text-yellow-600',
        'info' => 'bg-blue-500/10 border-blue-500/30 text-blue-600',
    ];
    
    $icons = [
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    ];

    $title = ucfirst($type);
    $activeClass = $classes[$type] ?? $classes['success'];
    $activeIcon = $icons[$type] ?? $icons['success'];
@endphp

@if ($message)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-8"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-8"
         class="fixed top-6 right-6 z-50 max-w-sm w-full shadow-lg rounded-xl pointer-events-auto"
         role="alert">
         
        <div class="backdrop-blur-md border p-4 rounded-xl flex items-start gap-3 relative overflow-hidden {{ $activeClass }}">
            <!-- Progress Bar -->
            <div class="absolute bottom-0 left-0 h-1 bg-current opacity-20"
                 x-init="$el.style.transition = 'width 5000ms linear'; setTimeout(() => $el.style.width = '0%', 50); $el.style.width = '100%'">
            </div>

            <svg class="w-6 h-6 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $activeIcon !!}
            </svg>
            
            <div class="flex-1 pr-4">
                <p class="font-bold text-sm mb-0.5">{{ $title }}</p>
                <p class="text-sm opacity-90 leading-snug">{{ $message }}</p>
            </div>

            <button @click="show = false" class="shrink-0 p-1 rounded-lg hover:bg-black/5 transition-colors focus:outline-none">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif
