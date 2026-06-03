<x-app-layout>
    <x-slot name="header">Website Events</x-slot>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div><h2 class="text-xl font-extrabold text-text">Public Events</h2><p class="text-sm text-muted">Manage events shown on the public website.</p></div>
            <a href="{{ route('admin.website.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Event</a>
        </div>
        <div class="bg-surface rounded-2xl border border-border overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="bg-background border-b border-border">
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Event</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Location</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-border">
                    @forelse($events as $event)
                    <tr class="hover:bg-primary/5 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($event->is_featured)<span class="px-1.5 py-0.5 bg-secondary/20 text-secondary text-[10px] font-bold rounded uppercase">Featured</span>@endif
                                <span class="font-semibold text-text">{{ $event->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-muted">{{ $event->event_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-muted">{{ $event->location ?? '—' }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $event->is_active ? 'bg-success/10 text-success' : 'bg-muted/10 text-muted' }}">{{ $event->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.website.events.edit', $event) }}" class="p-2 rounded-lg hover:bg-primary/10 text-primary transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                <form method="POST" action="{{ route('admin.website.events.destroy', $event) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-danger/10 text-danger transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted">No events yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
