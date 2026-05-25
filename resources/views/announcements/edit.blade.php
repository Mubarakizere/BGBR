<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('announcements.show', $announcement) }}" class="w-8 h-8 rounded-lg bg-surface border border-border flex items-center justify-center text-muted hover:text-text hover:border-text/20 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="font-bold">Edit Announcement</div>
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 py-8 max-w-4xl mx-auto" x-data="{ level: '{{ old('visibility_level', $announcement->visibility_level) }}' }">
        <div class="bg-surface rounded-3xl shadow-lg border border-border overflow-hidden">
            <div class="p-8 border-b border-border bg-background/30 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-text tracking-tight">Edit Announcement</h2>
                    <p class="text-sm text-muted mt-1 font-medium">Update the details of your announcement.</p>
                </div>
            </div>

            <form action="{{ route('announcements.update', $announcement) }}" method="POST" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Title --}}
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-black text-text">Announcement Title</label>
                        <div class="relative">
                            <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                                   class="w-full pl-4 pr-10 py-3.5 rounded-xl bg-background border border-border text-text font-medium focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all shadow-sm"
                                   placeholder="e.g. Monthly Staff Meeting Update">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-muted">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        @error('title') <p class="text-danger text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Visibility Level --}}
                    <div class="space-y-2">
                        <label for="visibility_level" class="block text-sm font-black text-text">Target Audience</label>
                        <div class="relative">
                            <select name="visibility_level" id="visibility_level" x-model="level"
                                    class="w-full pl-4 pr-10 py-3.5 rounded-xl bg-background border border-border text-text font-medium focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all shadow-sm appearance-none cursor-pointer">
                                @foreach($levels as $lvl)
                                    <option value="{{ $lvl }}">{{ ucfirst($lvl) }} Level</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-muted">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                            </div>
                        </div>
                        @error('visibility_level') <p class="text-danger text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Entity Selection (conditional) --}}
                    <div x-show="level === 'domination'" x-cloak x-transition.opacity class="space-y-2 bg-surface border border-border p-5 rounded-2xl">
                        <label class="block text-sm font-black text-text">Select Domination</label>
                        <p class="text-xs text-muted mb-3">Leave as auto to target your own domination.</p>
                        <select name="entity_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text font-medium focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all shadow-sm">
                            <option value="">-- Auto (your domination) --</option>
                            @foreach($dominations as $dom)
                                <option value="{{ $dom->id }}" {{ old('entity_id', $announcement->entity_id) == $dom->id ? 'selected' : '' }}>{{ $dom->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="level === 'battalion'" x-cloak x-transition.opacity class="space-y-2 bg-surface border border-border p-5 rounded-2xl">
                        <label class="block text-sm font-black text-text">Select Battalion</label>
                        <p class="text-xs text-muted mb-3">Leave as auto to target your own battalion.</p>
                        <select name="entity_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text font-medium focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all shadow-sm">
                            <option value="">-- Auto (your battalion) --</option>
                            @foreach($battalions as $btn)
                                <option value="{{ $btn->id }}" {{ old('entity_id', $announcement->entity_id) == $btn->id ? 'selected' : '' }}>{{ $btn->name }} ({{ $btn->domination?->name ?? '—' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="level === 'company'" x-cloak x-transition.opacity class="space-y-2 bg-surface border border-border p-5 rounded-2xl">
                        <label class="block text-sm font-black text-text">Select Company</label>
                        <p class="text-xs text-muted mb-3">Leave as auto to target your own company.</p>
                        <select name="entity_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text font-medium focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all shadow-sm">
                            <option value="">-- Auto (your company) --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('entity_id', $announcement->entity_id) == $company->id ? 'selected' : '' }}>{{ $company->name }} ({{ $company->battalion?->name ?? '—' }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Content --}}
                    <div class="space-y-2">
                        <label for="content" class="block text-sm font-black text-text">Message Content</label>
                        <textarea name="content" id="content" rows="8" required
                                  class="w-full p-4 rounded-xl bg-background border border-border text-text font-medium focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all shadow-sm resize-y leading-relaxed"
                                  placeholder="Write the full details of the announcement here...">{{ old('content', $announcement->content) }}</textarea>
                        @error('content') <p class="text-danger text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-border/50">
                    <a href="{{ route('announcements.show', $announcement) }}" class="px-6 py-3 rounded-xl bg-surface border border-border text-text font-bold hover:bg-background transition-all shadow-sm">
                        Cancel
                    </a>
                    <button type="submit" class="group relative inline-flex items-center justify-center gap-2 px-8 py-3 font-bold text-white transition-all duration-200 bg-primary border border-transparent rounded-xl hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/30 hover:shadow-primary/40 hover:-translate-y-0.5">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
