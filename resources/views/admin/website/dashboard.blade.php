<x-app-layout>
    <x-slot name="header">Website CMS</x-slot>

    <div class="p-6">
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-text tracking-tight">Website Content Management</h2>
            <p class="text-muted text-sm mt-1">Manage public website content — pages, leaders, events, news, gallery, and more.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-surface rounded-2xl p-5 border border-border">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-muted font-bold uppercase tracking-wider">Pages</p>
                        <p class="text-lg font-black text-text">{{ $stats['pages'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-surface rounded-2xl p-5 border border-border">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-muted font-bold uppercase tracking-wider">Leaders</p>
                        <p class="text-lg font-black text-text">{{ $stats['leaders'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-surface rounded-2xl p-5 border border-border">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-accent/10 flex items-center justify-center text-accent">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-muted font-bold uppercase tracking-wider">News</p>
                        <p class="text-lg font-black text-text">{{ $stats['news'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-surface rounded-2xl p-5 border border-border">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-danger/10 flex items-center justify-center text-danger">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-muted font-bold uppercase tracking-wider">Unread Messages</p>
                        <p class="text-lg font-black text-text">{{ $stats['unread_contacts'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('admin.website.pages.index') }}" class="bg-surface rounded-2xl p-5 border border-border hover:border-primary/30 hover:shadow-lg transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-text">Pages</p>
                        <p class="text-xs text-muted">Edit page content</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.website.leaders.index') }}" class="bg-surface rounded-2xl p-5 border border-border hover:border-primary/30 hover:shadow-lg transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-text">Leadership</p>
                        <p class="text-xs text-muted">Manage team</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.website.news.index') }}" class="bg-surface rounded-2xl p-5 border border-border hover:border-primary/30 hover:shadow-lg transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-text">News</p>
                        <p class="text-xs text-muted">Write articles</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.website.contacts.index') }}" class="bg-surface rounded-2xl p-5 border border-border hover:border-primary/30 hover:shadow-lg transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-danger/10 flex items-center justify-center text-danger group-hover:bg-danger group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-text">Messages</p>
                        <p class="text-xs text-muted">{{ $stats['unread_contacts'] }} unread</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Contact Messages -->
        @if($recentContacts->count())
        <div class="bg-surface rounded-2xl border border-border overflow-hidden">
            <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                <h3 class="font-bold text-text">Recent Contact Messages</h3>
                <a href="{{ route('admin.website.contacts.index') }}" class="text-xs text-primary font-bold hover:underline">View All</a>
            </div>
            <div class="divide-y divide-border">
                @foreach($recentContacts as $contact)
                <a href="{{ route('admin.website.contacts.show', $contact) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-primary/5 transition">
                    <div class="w-8 h-8 rounded-full {{ $contact->is_read ? 'bg-muted/10 text-muted' : 'bg-primary/10 text-primary' }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-text truncate {{ !$contact->is_read ? 'font-bold' : '' }}">{{ $contact->name }} — {{ $contact->subject }}</p>
                        <p class="text-xs text-muted truncate">{{ Str::limit($contact->message, 80) }}</p>
                    </div>
                    <span class="text-xs text-muted whitespace-nowrap">{{ $contact->created_at->diffForHumans() }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
