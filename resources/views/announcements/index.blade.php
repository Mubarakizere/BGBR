<x-app-layout>
    <x-slot name="header">
        Announcements
    </x-slot>

    <div class="px-6 py-8">
        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-text">Announcements</h1>
                <p class="text-sm text-muted mt-1">Stay updated with the latest news across all levels.</p>
            </div>
            @if(auth()->user()->hasRole(['Super Admin', 'Domination Admin', 'Battalion Commander', 'Company Captain']))
            <a href="{{ route('announcements.create') }}" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Announcement
            </a>
            @endif
        </div>

        {{-- Filters --}}
        <div class="mb-6 bg-surface rounded-2xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('announcements.index') }}" class="flex flex-wrap items-center gap-4">
                <select name="level" class="bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="">All Levels</option>
                    <option value="national" {{ request('level') === 'national' ? 'selected' : '' }}>National</option>
                    <option value="domination" {{ request('level') === 'domination' ? 'selected' : '' }}>Domination</option>
                    <option value="battalion" {{ request('level') === 'battalion' ? 'selected' : '' }}>Battalion</option>
                    <option value="company" {{ request('level') === 'company' ? 'selected' : '' }}>Company</option>
                </select>
                <button type="submit" class="bg-primary/10 text-primary font-bold py-2.5 px-5 rounded-xl hover:bg-primary/20 transition-colors text-sm">Filter</button>
                @if(request('level'))
                <a href="{{ route('announcements.index') }}" class="text-sm text-muted hover:text-text font-medium transition-colors">Clear</a>
                @endif
            </form>
        </div>

        {{-- Announcements Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden hover:shadow-md hover:border-primary/20 transition-all duration-300 group flex flex-col">
                    {{-- Level Badge Header --}}
                    @php
                        $levelColors = [
                            'national' => 'from-primary to-primary/80',
                            'domination' => 'from-secondary to-secondary/80',
                            'battalion' => 'from-success to-success/80',
                            'company' => 'from-accent to-accent/80',
                        ];
                        $gradient = $levelColors[$announcement->visibility_level] ?? 'from-primary to-primary/80';
                    @endphp
                    <div class="bg-gradient-to-r {{ $gradient }} px-6 py-3">
                        <span class="text-white text-xs font-black uppercase tracking-widest">{{ $announcement->visibility_level }}</span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-black text-text mb-2 group-hover:text-primary transition-colors">{{ $announcement->title }}</h3>
                        <p class="text-sm text-muted flex-1 line-clamp-3">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>

                        <div class="mt-4 pt-4 border-t border-border flex items-center justify-between">
                            <div class="text-xs text-muted">
                                <span class="font-semibold">{{ $announcement->creator?->name ?? 'System' }}</span>
                                <span class="mx-1">·</span>
                                {{ $announcement->created_at->diffForHumans() }}
                            </div>
                            <a href="{{ route('announcements.show', $announcement) }}" class="text-sm font-bold text-primary hover:text-primary/80 transition-colors">Read →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-surface rounded-2xl shadow-sm border border-border p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-background mb-4">
                            <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <p class="text-muted font-medium">No announcements to display.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
