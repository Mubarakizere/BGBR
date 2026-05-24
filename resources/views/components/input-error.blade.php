@props(['messages'])

@if ($messages)
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms {{ $attributes->merge(['class' => 'mt-1.5 text-sm text-danger flex items-start gap-1']) }}>
        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <ul class="space-y-1">
            @foreach ((array) $messages as $message)
                <li class="font-medium">{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
