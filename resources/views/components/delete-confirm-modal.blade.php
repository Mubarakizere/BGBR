{{--
    Reusable Delete Confirmation Modal
    
    Usage: Add this component once per page, then trigger it via Alpine.js events.
    
    In your x-data, add: deleteTarget: null, deleteMessage: ''
    
    On delete button: 
        @click="$dispatch('open-delete-modal', { 
            action: '{{ route('...') }}', 
            message: 'Are you sure you want to delete this item?' 
        })"
    
    The modal will handle the form submission with CSRF and DELETE method.
--}}

<div x-data="{ 
        open: false, 
        action: '', 
        message: '',
        method: 'DELETE'
     }"
     x-on:open-delete-modal.window="
        action = $event.detail.action; 
        message = $event.detail.message || 'Are you sure you want to delete this item?';
        method = $event.detail.method || 'DELETE';
        open = true;
     "
     x-on:keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[60] overflow-y-auto"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 py-6">

        {{-- Backdrop --}}
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-[#0F1847]/50 backdrop-blur-sm transition-opacity"
             @click="open = false"></div>

        {{-- Modal Panel --}}
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative w-full max-w-md bg-surface rounded-2xl shadow-2xl border border-border overflow-hidden z-10">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-border bg-danger/5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-danger/10 flex items-center justify-center text-danger shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-text">Confirm Deletion</h3>
                        <p class="text-xs text-muted mt-0.5">This action cannot be undone</p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-6">
                <p class="text-sm text-text leading-relaxed" x-text="message"></p>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-border bg-background/50 flex items-center justify-end gap-3">
                <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-xl border border-border bg-surface text-sm font-semibold text-muted hover:text-text hover:bg-background transition-all">
                    Cancel
                </button>
                <form :action="action" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="_method" :value="method">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-danger hover:bg-danger/90 text-white text-sm font-bold shadow-md shadow-danger/20 hover:shadow-lg hover:shadow-danger/30 transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
