<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('announcements.show', $announcement) }}" class="text-muted hover:text-text transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            Edit Announcement
        </div>
    </x-slot>

    <div class="px-6 py-8 max-w-3xl mx-auto" x-data="{ level: '{{ old('visibility_level', $announcement->visibility_level) }}' }">
        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="p-6 border-b border-border bg-background/50">
                <h2 class="text-lg font-black text-text">Edit Announcement</h2>
            </div>

            <form action="{{ route('announcements.update', $announcement) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-bold text-text mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                    @error('title') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-bold text-text mb-2">Content</label>
                    <textarea name="content" id="content" rows="6" required
                              class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors resize-y">{{ old('content', $announcement->content) }}</textarea>
                    @error('content') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="visibility_level" class="block text-sm font-bold text-text mb-2">Target Audience</label>
                    <select name="visibility_level" id="visibility_level" x-model="level"
                            class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                        @foreach($levels as $lvl)
                            <option value="{{ $lvl }}" {{ $announcement->visibility_level === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-show="level === 'domination'" x-cloak>
                    <label class="block text-sm font-bold text-text mb-2">Select Domination</label>
                    <select name="entity_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                        <option value="">-- Auto --</option>
                        @foreach($dominations as $dom)
                            <option value="{{ $dom->id }}" {{ $announcement->entity_id === $dom->id ? 'selected' : '' }}>{{ $dom->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-show="level === 'battalion'" x-cloak>
                    <label class="block text-sm font-bold text-text mb-2">Select Battalion</label>
                    <select name="entity_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                        <option value="">-- Auto --</option>
                        @foreach($battalions as $btn)
                            <option value="{{ $btn->id }}" {{ $announcement->entity_id === $btn->id ? 'selected' : '' }}>{{ $btn->name }} ({{ $btn->domination?->name ?? '—' }})</option>
                        @endforeach
                    </select>
                </div>

                <div x-show="level === 'company'" x-cloak>
                    <label class="block text-sm font-bold text-text mb-2">Select Company</label>
                    <select name="entity_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                        <option value="">-- Auto --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ $announcement->entity_id === $company->id ? 'selected' : '' }}>{{ $company->name }} ({{ $company->battalion?->name ?? '—' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-border">
                    <a href="{{ route('announcements.show', $announcement) }}" class="px-6 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</a>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-lg shadow-primary/20">
                        Update Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
