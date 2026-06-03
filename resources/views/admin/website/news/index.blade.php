<x-app-layout>
    <x-slot name="header">Website News</x-slot>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div><h2 class="text-xl font-extrabold text-text">News Articles</h2><p class="text-sm text-muted">Manage news and blog posts for the public website.</p></div>
            <a href="{{ route('admin.website.news.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> New Article</a>
        </div>
        <div class="bg-surface rounded-2xl border border-border overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="bg-background border-b border-border">
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Article</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Author</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Published</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-muted uppercase tracking-wider">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-border">
                    @forelse($articles as $article)
                    <tr class="hover:bg-primary/5 transition">
                        <td class="px-6 py-4"><span class="font-semibold text-text">{{ Str::limit($article->title, 50) }}</span><br><span class="text-xs text-muted font-mono">{{ $article->slug }}</span></td>
                        <td class="px-6 py-4 text-muted">{{ $article->author_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-muted text-xs">{{ $article->published_at?->format('M d, Y') ?? '—' }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $article->is_published ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning' }}">{{ $article->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.website.news.edit', $article) }}" class="p-2 rounded-lg hover:bg-primary/10 text-primary transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                <form method="POST" action="{{ route('admin.website.news.destroy', $article) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-danger/10 text-danger transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted">No articles yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
