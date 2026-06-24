<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-text leading-tight">
            {{ __('Edit Activity') }}
        </h2>
    </x-slot>

    <div class="py-8 px-6">
        <div class="max-w-3xl mx-auto" x-data="{ audience: '{{ old('target_audience', $activity->target_audience ?? 'national') }}' }">

            {{-- Back Link --}}
            <a href="{{ route('activities.show', $activity) }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-primary font-semibold mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Activity
            </a>

            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-primary to-primary/80 px-8 py-6">
                    <h3 class="text-xl font-black text-white">Edit Activity</h3>
                    <p class="text-white/70 text-sm mt-1">Update the details of "{{ $activity->title }}"</p>
                </div>

                <form method="POST" action="{{ route('activities.update', $activity) }}" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-text mb-2">Activity Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $activity->title) }}" required
                               class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        @error('title') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Date & Location Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-bold text-text mb-2">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" value="{{ old('date', $activity->date?->format('Y-m-d')) }}" required
                                   class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            @error('date') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-bold text-text mb-2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $activity->location) }}"
                                   class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            @error('location') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Fee & Status Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="participation_fee" class="block text-sm font-bold text-text mb-2">Participation Fee (RWF) <span class="text-danger">*</span></label>
                            <input type="number" name="participation_fee" id="participation_fee" value="{{ old('participation_fee', $activity->participation_fee) }}" min="0" step="0.01" required
                                   class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            @error('participation_fee') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-bold text-text mb-2">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" required
                                    class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                                <option value="upcoming" {{ old('status', $activity->status) === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ old('status', $activity->status) === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status', $activity->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $activity->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Target Audience --}}
                    <div class="space-y-4">
                        <div>
                            <label for="target_audience" class="block text-sm font-bold text-text mb-2">Target Audience <span class="text-danger">*</span></label>
                            <p class="text-xs text-muted mb-2">Select who should see this activity and receive notifications.</p>
                            <select name="target_audience" id="target_audience" x-model="audience" required
                                    class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                                <option value="national">National (Everyone)</option>
                                <option value="domination">Zone (Domination)</option>
                                <option value="battalion">Battalion</option>
                                <option value="company">Company</option>
                            </select>
                            @error('target_audience') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Domination multi-select --}}
                        <div x-show="audience === 'domination'" x-cloak x-transition.opacity
                             x-data="multiSelect({{ $dominations->map(fn($d) => ['id' => $d->id, 'label' => $d->name])->toJson() }}, {{ json_encode(old('entity_ids', $activity->entity_ids ?? ($activity->entity_id ? [$activity->entity_id] : []))) }})"
                             class="bg-background rounded-xl p-4 border border-border">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-bold text-text">Select Zone(s) <span class="text-danger">*</span></label>
                                <div class="flex gap-2 text-xs">
                                    <button type="button" @click="selectAll()" class="text-primary hover:underline font-semibold">Select All</button>
                                    <span class="text-muted">·</span>
                                    <button type="button" @click="clearAll()" class="text-muted hover:text-danger font-semibold">Clear</button>
                                </div>
                            </div>
                            <p class="text-xs text-muted mb-3">
                                <span x-text="selected.length"></span> selected
                            </p>
                            <input type="text" x-model="search" placeholder="Search zones…"
                                   class="w-full rounded-lg border-border bg-surface text-text text-sm px-3 py-2 mb-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                                <template x-for="item in filtered" :key="item.id">
                                    <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-surface cursor-pointer transition-colors"
                                           :class="selected.includes(item.id) ? 'bg-primary/10 border border-primary/30' : ''">
                                        <input type="checkbox" name="entity_ids[]" :value="item.id"
                                               :checked="selected.includes(item.id)"
                                               @change="toggle(item.id)"
                                               class="rounded border-border text-primary focus:ring-primary/30">
                                        <span class="text-sm text-text" x-text="item.label"></span>
                                    </label>
                                </template>
                                <p x-show="filtered.length === 0" class="text-xs text-muted text-center py-4">No zones found.</p>
                            </div>
                            @error('entity_ids') <p class="text-danger text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Battalion multi-select --}}
                        <div x-show="audience === 'battalion'" x-cloak x-transition.opacity
                             x-data="multiSelect({{ $battalions->map(fn($b) => ['id' => $b->id, 'label' => $b->name . ' (' . ($b->domination?->name ?? '—') . ')'])->toJson() }}, {{ json_encode(old('entity_ids', $activity->entity_ids ?? ($activity->entity_id ? [$activity->entity_id] : []))) }})"
                             class="bg-background rounded-xl p-4 border border-border">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-bold text-text">Select Battalion(s) <span class="text-danger">*</span></label>
                                <div class="flex gap-2 text-xs">
                                    <button type="button" @click="selectAll()" class="text-primary hover:underline font-semibold">Select All</button>
                                    <span class="text-muted">·</span>
                                    <button type="button" @click="clearAll()" class="text-muted hover:text-danger font-semibold">Clear</button>
                                </div>
                            </div>
                            <p class="text-xs text-muted mb-3">
                                <span x-text="selected.length"></span> selected
                            </p>
                            <input type="text" x-model="search" placeholder="Search battalions…"
                                   class="w-full rounded-lg border-border bg-surface text-text text-sm px-3 py-2 mb-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                                <template x-for="item in filtered" :key="item.id">
                                    <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-surface cursor-pointer transition-colors"
                                           :class="selected.includes(item.id) ? 'bg-primary/10 border border-primary/30' : ''">
                                        <input type="checkbox" name="entity_ids[]" :value="item.id"
                                               :checked="selected.includes(item.id)"
                                               @change="toggle(item.id)"
                                               class="rounded border-border text-primary focus:ring-primary/30">
                                        <span class="text-sm text-text" x-text="item.label"></span>
                                    </label>
                                </template>
                                <p x-show="filtered.length === 0" class="text-xs text-muted text-center py-4">No battalions found.</p>
                            </div>
                            @error('entity_ids') <p class="text-danger text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Company multi-select --}}
                        <div x-show="audience === 'company'" x-cloak x-transition.opacity
                             x-data="multiSelect({{ $companies->map(fn($c) => ['id' => $c->id, 'label' => $c->name . ' (' . ($c->battalion?->name ?? '—') . ')'])->toJson() }}, {{ json_encode(old('entity_ids', $activity->entity_ids ?? ($activity->entity_id ? [$activity->entity_id] : []))) }})"
                             class="bg-background rounded-xl p-4 border border-border">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-bold text-text">Select Company/ies <span class="text-danger">*</span></label>
                                <div class="flex gap-2 text-xs">
                                    <button type="button" @click="selectAll()" class="text-primary hover:underline font-semibold">Select All</button>
                                    <span class="text-muted">·</span>
                                    <button type="button" @click="clearAll()" class="text-muted hover:text-danger font-semibold">Clear</button>
                                </div>
                            </div>
                            <p class="text-xs text-muted mb-3">
                                <span x-text="selected.length"></span> selected
                            </p>
                            <input type="text" x-model="search" placeholder="Search companies…"
                                   class="w-full rounded-lg border-border bg-surface text-text text-sm px-3 py-2 mb-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                                <template x-for="item in filtered" :key="item.id">
                                    <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-surface cursor-pointer transition-colors"
                                           :class="selected.includes(item.id) ? 'bg-primary/10 border border-primary/30' : ''">
                                        <input type="checkbox" name="entity_ids[]" :value="item.id"
                                               :checked="selected.includes(item.id)"
                                               @change="toggle(item.id)"
                                               class="rounded border-border text-primary focus:ring-primary/30">
                                        <span class="text-sm text-text" x-text="item.label"></span>
                                    </label>
                                </template>
                                <p x-show="filtered.length === 0" class="text-xs text-muted text-center py-4">No companies found.</p>
                            </div>
                            @error('entity_ids') <p class="text-danger text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-text mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-none">{{ old('description', $activity->description) }}</textarea>
                        @error('description') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Requirements --}}
                    <div>
                        <label for="requirements" class="block text-sm font-bold text-text mb-2">Eligibility Requirements</label>
                        <textarea name="requirements" id="requirements" rows="3"
                                  class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-none">{{ old('requirements', $activity->requirements) }}</textarea>
                        <p class="text-xs text-muted mt-1">Describe any requirements members must meet to participate.</p>
                        @error('requirements') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                        <a href="{{ route('activities.show', $activity) }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-muted hover:text-text bg-background hover:bg-border transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary/90 shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all">
                            Update Activity
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function multiSelect(items, preselected) {
            return {
                items: items,
                selected: preselected || [],
                search: '',
                get filtered() {
                    const q = this.search.toLowerCase();
                    return q ? this.items.filter(i => i.label.toLowerCase().includes(q)) : this.items;
                },
                toggle(id) {
                    const idx = this.selected.indexOf(id);
                    if (idx === -1) this.selected.push(id);
                    else this.selected.splice(idx, 1);
                },
                selectAll() {
                    this.filtered.forEach(i => {
                        if (!this.selected.includes(i.id)) this.selected.push(i.id);
                    });
                },
                clearAll() {
                    const filteredIds = this.filtered.map(i => i.id);
                    this.selected = this.selected.filter(id => !filteredIds.includes(id));
                },
            };
        }
    </script>
</x-app-layout>
