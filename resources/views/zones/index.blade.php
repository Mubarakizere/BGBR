<x-app-layout>
    <x-slot name="header">
        {{ __('Zones Management') }}
    </x-slot>

    <div class="py-8" x-data="{ openModal: false, editing: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Title Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-text tracking-tight">Zones</h1>
                    <p class="text-sm text-muted mt-1">Manage geographic zones for battalion grouping</p>
                </div>
                <button @click="editing = null; openModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Zone
                </button>
            </div>

            {{-- Zones Table --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead>
                            <tr class="bg-background">
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Zone</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Description</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Battalions</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($zones as $zone)
                            <tr class="hover:bg-primary/[0.02] transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-teal-500/10 flex items-center justify-center text-teal-500 font-bold text-xs">
                                            {{ strtoupper(substr($zone->name, 0, 2)) }}
                                        </div>
                                        <p class="text-sm font-semibold text-text">{{ $zone->name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($zone->description)
                                        <p class="text-sm text-muted max-w-xs truncate">{{ $zone->description }}</p>
                                    @else
                                        <span class="text-xs text-muted italic">No description</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-background border border-border text-text">
                                        <svg class="w-3 h-3 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $zone->battalions_count }} {{ Str::plural('battalion', $zone->battalions_count) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button @click="editing = {{ $zone->toJson() }}; openModal = true" class="p-2 rounded-lg text-muted hover:text-primary hover:bg-primary/10 transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button type="button" 
                                            @click="$dispatch('open-delete-modal', { action: '{{ route('zones.destroy', $zone) }}', message: 'Are you sure you want to delete this zone? Battalions in this zone will be unassigned.' })"
                                            class="p-2 rounded-lg text-muted hover:text-danger hover:bg-danger/10 transition-all" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-teal-500/5 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-text mb-1">No zones yet</p>
                                        <p class="text-xs text-muted">Get started by adding your first zone</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($zones->hasPages())
                    <div class="px-6 py-4 border-t border-border bg-background">
                        {{ $zones->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Add/Edit Modal --}}
        <div x-show="openModal" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>
            <div class="relative bg-surface rounded-2xl shadow-2xl border border-border w-full max-w-lg z-10 overflow-hidden">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between bg-background">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-teal-500/10 flex items-center justify-center text-teal-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-text" x-text="editing ? 'Edit Zone' : 'Add Zone'"></h3>
                    </div>
                    <button @click="openModal = false" class="text-muted hover:text-text transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="editing ? '/zones/' + editing.id : '{{ route('zones.store') }}'" method="POST">
                    @csrf
                    <template x-if="editing"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" :value="editing ? editing.name : ''" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Enter zone name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Description</label>
                            <textarea name="description" rows="3" x-init="$watch('editing', val => { if(val) $el.value = val.description || ''; else $el.value = ''; })"
                                      class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none"
                                      placeholder="Enter zone description (optional)"></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-border bg-background flex items-center justify-end gap-3">
                        <button type="button" @click="openModal = false"
                                class="px-5 py-2.5 rounded-xl border border-border bg-surface text-sm font-semibold text-muted hover:text-text transition-all">Cancel</button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-bold shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 transition-all">
                            <span x-text="editing ? 'Update' : 'Save'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
