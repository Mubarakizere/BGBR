<x-app-layout>
    <x-slot name="header">Message from {{ $contact->name }}</x-slot>
    <div class="p-6"><div class="max-w-2xl">
        <a href="{{ route('admin.website.contacts.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back to Messages</a>
        <div class="bg-surface rounded-2xl border border-border overflow-hidden">
            <div class="p-6 border-b border-border bg-background/50">
                <h3 class="text-lg font-bold text-text">{{ $contact->subject }}</h3>
                <div class="flex items-center gap-4 mt-2 text-sm text-muted">
                    <span>From: <strong class="text-text">{{ $contact->name }}</strong></span>
                    <span>&bull;</span>
                    <span>{{ $contact->created_at->format('F j, Y \\a\\t g:i A') }}</span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div><label class="text-xs font-bold text-muted uppercase tracking-wide">Email</label><p class="text-sm mt-1"><a href="mailto:{{ $contact->email }}" class="text-primary font-semibold hover:underline">{{ $contact->email }}</a></p></div>
                    <div><label class="text-xs font-bold text-muted uppercase tracking-wide">Phone</label><p class="text-sm mt-1">{{ $contact->phone ?? '—' }}</p></div>
                    <div><label class="text-xs font-bold text-muted uppercase tracking-wide">IP Address</label><p class="text-sm mt-1 font-mono text-muted">{{ $contact->ip_address ?? '—' }}</p></div>
                    <div><label class="text-xs font-bold text-muted uppercase tracking-wide">Status</label><p class="mt-1"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $contact->is_read ? 'bg-success/10 text-success' : 'bg-primary/10 text-primary' }}">{{ $contact->is_read ? 'Read' : 'Unread' }}</span></p></div>
                </div>
                <div>
                    <label class="text-xs font-bold text-muted uppercase tracking-wide">Message</label>
                    <div class="mt-2 p-4 bg-background rounded-xl text-sm text-text leading-relaxed border border-border">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/></svg> Reply via Email
                    </a>
                    <form method="POST" action="{{ route('admin.website.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')
                        <button class="px-4 py-2 border border-danger/20 text-danger rounded-xl text-sm font-bold hover:bg-danger hover:text-white transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
</x-app-layout>
