<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-500 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            </div>
            Announcements
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 py-8">
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-text tracking-tight">Announcements</h1>
                <p class="text-sm text-muted mt-1.5">Stay updated with the latest news and broadcast messages.</p>
            </div>
            @if(auth()->user()->hasRole(['Super Admin', 'Denomination Admin', 'Battalion Commander', 'Company Captain']))
            <a href="{{ route('announcements.create') }}" class="group relative inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-primary border border-transparent rounded-xl hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/30 hover:shadow-primary/40 hover:-translate-y-0.5">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Announcement
            </a>
            @endif
        </div>

        {{-- Filters & Search --}}
        <div class="mb-8 bg-surface rounded-2xl shadow-sm border border-border p-2">
            <form method="GET" action="{{ route('announcements.index') }}" class="flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-muted">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <select name="level" class="w-full bg-background border-none rounded-xl pl-11 pr-4 py-3 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 transition-all cursor-pointer">
                        <option value="">All Organization Levels</option>
                        <option value="national" {{ request('level') === 'national' ? 'selected' : '' }}>National Level</option>
                        <option value="denomination" {{ request('level') === 'denomination' ? 'selected' : '' }}>Denomination Level</option>
                        <option value="battalion" {{ request('level') === 'battalion' ? 'selected' : '' }}>Battalion Level</option>
                        <option value="company" {{ request('level') === 'company' ? 'selected' : '' }}>Company Level</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 sm:flex-none bg-primary/10 text-primary font-bold py-3 px-6 rounded-xl hover:bg-primary/20 transition-colors text-sm flex items-center justify-center gap-2">
                        Filter
                    </button>
                    @if(request('level'))
                    <a href="{{ route('announcements.index') }}" class="flex-1 sm:flex-none bg-background border border-border text-text font-bold py-3 px-6 rounded-xl hover:bg-surface transition-colors text-sm flex items-center justify-center">
                        Clear
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Announcements Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden hover:shadow-xl hover:shadow-primary/5 hover:border-primary/30 transition-all duration-300 group flex flex-col hover:-translate-y-1 relative">
                    {{-- Level Badge Header --}}
                    @php
                        $levelStyles = [
                            'national' => ['bg' => 'from-blue-500 to-blue-600', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'denomination' => ['bg' => 'from-violet-500 to-violet-600', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            'battalion' => ['bg' => 'from-emerald-500 to-emerald-600', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                            'company' => ['bg' => 'from-amber-500 to-amber-600', 'icon' => 'M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
                        ];
                        $style = $levelStyles[$announcement->visibility_level] ?? ['bg' => 'from-gray-500 to-gray-600', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
                    @endphp
                    
                    <div class="h-2 w-full bg-gradient-to-r {{ $style['bg'] }}"></div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-widest bg-background border border-border text-muted group-hover:border-primary/20 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"></path></svg>
                                    {{ $announcement->visibility_level }}
                                </span>
                                @if(!$announcement->is_approved)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-600 border border-amber-500/20">Pending</span>
                                @endif
                            </div>
                            <span class="text-[11px] font-medium text-muted bg-background px-2.5 py-1 rounded-md border border-border flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $announcement->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h3 class="text-lg font-black text-text mb-3 group-hover:text-primary transition-colors line-clamp-2 leading-tight">
                            <a href="{{ route('announcements.show', $announcement) }}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $announcement->title }}
                            </a>
                        </h3>
                        
                        <p class="text-sm text-muted flex-1 line-clamp-3 leading-relaxed">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>

                        <div class="mt-6 pt-5 border-t border-border/50 flex items-center justify-between z-10 relative">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                    {{ substr($announcement->creator?->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-text">{{ $announcement->creator?->name ?? 'System' }}</span>
                                    <span class="text-[10px] text-muted">Author</span>
                                </div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-background border border-border flex items-center justify-center text-muted group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all duration-300">
                                <svg class="w-4 h-4 translate-x-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-surface rounded-3xl shadow-sm border border-border border-dashed p-16 text-center max-w-2xl mx-auto">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-primary/5 text-primary mb-6 shadow-inner">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-text mb-2">No announcements found</h3>
                        <p class="text-muted font-medium mb-6">There are currently no announcements matching your criteria.</p>
                        @if(request('level'))
                            <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-background border border-border text-text font-bold hover:bg-surface transition-colors shadow-sm">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
        <div class="mt-8 bg-surface rounded-2xl shadow-sm border border-border p-4">
            {{ $announcements->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
