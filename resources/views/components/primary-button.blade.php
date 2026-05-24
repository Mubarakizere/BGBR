<button 
    x-data="{ loading: false }"
    x-init="$el.closest('form')?.addEventListener('submit', (e) => { 
        if(!e.defaultPrevented && $el.closest('form').checkValidity()) { 
            loading = true; 
        } 
    })"
    x-bind:disabled="loading"
    {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex items-center justify-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary/90 focus:bg-primary/90 active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm disabled:opacity-70 disabled:cursor-not-allowed overflow-hidden']) }}
>
    <svg x-show="loading" x-cloak class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <span :class="{ 'opacity-0': loading && !'{{ $slot }}'.trim(), 'opacity-80': loading }">{{ $slot }}</span>
</button>
