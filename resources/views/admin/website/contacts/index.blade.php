<x-app-layout>
    <x-slot name="header">Contact Messages</x-slot>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div><h2 class="text-xl font-extrabold text-text">Contact Submissions</h2><p class="text-sm text-muted">{{ $unreadCount }} unread message{{ $unreadCount != 1 ? 's' : '' }}</p></div>
        </div>
        <div class="bg-surface rounded-2xl border border-border overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="bg-background border-b border-border">
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">From</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Subject</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-border">
                    @forelse($contacts as $contact)
                    <tr class="hover:bg-primary/5 transition {{ !$contact->is_read ? 'bg-primary/[0.02]' : '' }}">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-text {{ !$contact->is_read ? 'font-bold' : '' }}">{{ $contact->name }}</span><br>
                            <span class="text-xs text-muted">{{ $contact->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-text {{ !$contact->is_read ? 'font-semibold' : '' }}">{{ Str::limit($contact->subject, 40) }}</td>
                        <td class="px-6 py-4 text-xs text-muted">{{ $contact->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $contact->is_read ? 'bg-muted/10 text-muted' : 'bg-primary/10 text-primary' }}">{{ $contact->is_read ? 'Read' : 'New' }}</span></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.website.contacts.show', $contact) }}" class="p-2 rounded-lg hover:bg-primary/10 text-primary transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                <form method="POST" action="{{ route('admin.website.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-danger/10 text-danger transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted">No contact messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $contacts->links() }}</div>
    </div>
</x-app-layout>
