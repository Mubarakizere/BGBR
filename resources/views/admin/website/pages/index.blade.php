<x-app-layout>
    <x-slot name="header">Website Pages</x-slot>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-text">Page Sections</h2>
                <p class="text-sm text-muted">Manage editable content blocks for the public website.</p>
            </div>
            <a href="{{ route('admin.website.pages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Section
            </a>
        </div>
        <div class="bg-surface rounded-2xl border border-border overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="bg-background border-b border-border">
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Slug</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Title</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Order</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-border">
                    @forelse($pages as $page)
                    <tr class="hover:bg-primary/5 transition">
                        <td class="px-6 py-4 font-mono text-xs text-primary font-bold">{{ $page->slug }}</td>
                        <td class="px-6 py-4 font-semibold text-text">{{ $page->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $page->is_active ? 'bg-success/10 text-success' : 'bg-muted/10 text-muted' }}">
                                {{ $page->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-muted">{{ $page->sort_order }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.website.pages.edit', $page) }}" class="p-2 rounded-lg hover:bg-primary/10 text-primary transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.website.pages.destroy', $page) }}" onsubmit="return confirm('Delete this section?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-danger/10 text-danger transition" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted">No page sections yet. Create one to get started.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
