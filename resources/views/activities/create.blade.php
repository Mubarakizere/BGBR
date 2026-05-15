<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-text leading-tight">
            {{ __('Create Activity') }}
        </h2>
    </x-slot>

    <div class="py-8 px-6">
        <div class="max-w-3xl mx-auto">

            {{-- Back Link --}}
            <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-primary font-semibold mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Activities
            </a>

            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-primary to-primary/80 px-8 py-6">
                    <h3 class="text-xl font-black text-white">New Activity</h3>
                    <p class="text-white/70 text-sm mt-1">Fill in the details to create a new national activity</p>
                </div>

                <form method="POST" action="{{ route('activities.store') }}" class="p-8 space-y-6">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-text mb-2">Activity Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                               placeholder="e.g. National Training Camp 2026">
                        @error('title') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Date & Location Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-bold text-text mb-2">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" value="{{ old('date') }}" required
                                   class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            @error('date') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-bold text-text mb-2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                   class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                   placeholder="e.g. Kigali Convention Centre">
                            @error('location') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Fee & Status Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="participation_fee" class="block text-sm font-bold text-text mb-2">Participation Fee (RWF) <span class="text-danger">*</span></label>
                            <input type="number" name="participation_fee" id="participation_fee" value="{{ old('participation_fee', 0) }}" min="0" step="0.01" required
                                   class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                   placeholder="0">
                            @error('participation_fee') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-bold text-text mb-2">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" required
                                    class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                                <option value="upcoming" {{ old('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-text mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-none"
                                  placeholder="Describe the activity...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Requirements --}}
                    <div>
                        <label for="requirements" class="block text-sm font-bold text-text mb-2">Eligibility Requirements</label>
                        <textarea name="requirements" id="requirements" rows="3"
                                  class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-none"
                                  placeholder="e.g. Must have registration fee paid. Must be active for at least 6 months.">{{ old('requirements') }}</textarea>
                        <p class="text-xs text-muted mt-1">Describe any requirements members must meet to participate.</p>
                        @error('requirements') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                        <a href="{{ route('activities.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-muted hover:text-text bg-background hover:bg-border transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary/90 shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all">
                            Create Activity
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
