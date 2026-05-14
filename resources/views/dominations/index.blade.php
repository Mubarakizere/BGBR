<x-app-layout>
    <x-slot name="header">
        {{ __('Dominations Management') }}
    </x-slot>

    <div class="py-8" x-data="{ openModal: false, editing: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Title Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-text tracking-tight">Dominations</h1>
                    <p class="text-sm text-muted mt-1">Manage regional domination zones</p>
                </div>
                <button @click="editing = null; openModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Domination
                </button>
            </div>

            {{-- Dominations Table --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead>
                            <tr class="bg-background">
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Domination</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Region</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Contribution</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($dominations as $domination)
                            <tr class="hover:bg-primary/[0.02] transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-text">{{ $domination->name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($domination->region)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-background border border-border text-text">
                                            <svg class="w-3 h-3 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $domination->region }}
                                        </span>
                                    @else
                                        <span class="text-xs text-muted italic">Not set</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-32">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-bold text-text">{{ $domination->contributionPercentage }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-border/50 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $domination->contributionPercentage >= 75 ? 'bg-success' : ($domination->contributionPercentage >= 40 ? 'bg-secondary' : 'bg-danger') }}"
                                                 style="width: {{ $domination->contributionPercentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button @click="editing = {{ $domination->toJson() }}; openModal = true" class="p-2 rounded-lg text-muted hover:text-primary hover:bg-primary/10 transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form action="{{ route('dominations.destroy', $domination) }}" method="POST" class="inline" onsubmit="return confirm('Delete this domination?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-muted hover:text-danger hover:bg-danger/10 transition-all" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-primary/5 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-text mb-1">No dominations yet</p>
                                        <p class="text-xs text-muted">Get started by adding your first domination</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-text" x-text="editing ? 'Edit Domination' : 'Add Domination'"></h3>
                    </div>
                    <button @click="openModal = false" class="text-muted hover:text-text transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="editing ? '/dominations/' + editing.id : '{{ route('dominations.store') }}'" method="POST">
                    @csrf
                    <template x-if="editing"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Domination Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" :value="editing ? editing.name : ''" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Enter domination name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Region</label>
                            <input type="text" name="region" :value="editing ? editing.region : ''"
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Enter region (optional)">
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
