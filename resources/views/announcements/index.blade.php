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

        {{-- Announcements Table --}}
        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-background/50 border-b border-border">
                            <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Level</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Author</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($announcements as $announcement)
                            <tr class="hover:bg-background/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if(!$announcement->is_read)
                                            <div class="w-2 h-2 flex-shrink-0 rounded-full bg-blue-500 animate-pulse" title="New Unread Announcement"></div>
                                        @else
                                            <div class="w-2 h-2 flex-shrink-0 rounded-full bg-transparent"></div>
                                        @endif
                                        <div>
                                            <div class="font-bold group-hover:text-primary transition-colors {{ !$announcement->is_read ? 'text-text' : 'text-text/70' }}">
                                                {{ $announcement->title }}
                                            </div>
                                            <div class="text-xs text-muted mt-1 line-clamp-1 max-w-sm lg:max-w-md">
                                                {{ Str::limit(strip_tags($announcement->content), 80) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-widest bg-background border border-border text-muted">
                                        {{ $announcement->visibility_level }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if(!$announcement->is_approved)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-600 border border-amber-500/20">Pending</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-600 border border-emerald-500/20">Approved</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-[10px]">
                                            {{ substr($announcement->creator?->name ?? 'S', 0, 1) }}
                                        </div>
                                        <span class="text-xs font-bold text-text">{{ $announcement->creator?->name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-medium text-muted">
                                        {{ $announcement->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @can('view', $announcement)
                                        <a href="{{ route('announcements.show', $announcement) }}" class="p-1.5 text-muted hover:text-primary transition-colors bg-background rounded-lg border border-border hover:border-primary/30 hover:shadow-sm" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        @endcan

                                        @can('approve', $announcement)
                                            @if(!$announcement->is_approved)
                                                <button type="button" @click="$dispatch('open-approve-modal', { action: '{{ route('announcements.approve', $announcement) }}', message: 'Are you sure you want to approve this announcement?' })"
                                                        class="p-1.5 text-muted hover:text-emerald-500 transition-colors bg-background rounded-lg border border-border hover:border-emerald-500/30 hover:shadow-sm" title="Approve">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            @endif
                                        @endcan

                                        @can('delete', $announcement)
                                            <button type="button" @click="$dispatch('open-delete-modal', { action: '{{ route('announcements.destroy', $announcement) }}', message: 'Are you sure you want to delete this announcement?' })"
                                                    class="p-1.5 text-muted hover:text-red-500 transition-colors bg-background rounded-lg border border-border hover:border-red-500/30 hover:shadow-sm" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary/5 text-primary mb-4 shadow-inner">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-black text-text mb-1">No announcements found</h3>
                                    <p class="text-sm text-muted font-medium mb-4">There are currently no announcements matching your criteria.</p>
                                    @if(request('level'))
                                        <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-background border border-border text-text font-bold hover:bg-surface transition-colors shadow-sm text-xs">
                                            Clear Filters
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($announcements->hasPages())
        <div class="mt-8 bg-surface rounded-2xl shadow-sm border border-border p-4">
            {{ $announcements->links() }}
        </div>
        @endif
    </div>

    {{-- Confirmation Modals --}}
    <x-delete-confirm-modal />
    <x-approve-confirm-modal />
</x-app-layout>
