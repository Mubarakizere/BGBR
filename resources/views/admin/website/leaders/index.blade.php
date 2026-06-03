<x-app-layout>
    <x-slot name="header">Leadership Team</x-slot>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-text">Leadership Team</h2>
                <p class="text-sm text-muted">Manage leaders displayed on the public website.</p>
            </div>
            <a href="{{ route('admin.website.leaders.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Leader
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($leaders as $leader)
            <div class="bg-surface rounded-2xl border border-border overflow-hidden">
                <div class="h-40 bg-gradient-to-br from-primary to-blue-500 flex items-center justify-center overflow-hidden">
                    @if($leader->photo_path)
                        <img src="{{ asset('storage/' . $leader->photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-text text-sm">{{ $leader->name }}</h3>
                    <p class="text-xs text-primary font-semibold">{{ $leader->title }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $leader->is_active ? 'bg-success/10 text-success' : 'bg-muted/10 text-muted' }}">{{ $leader->is_active ? 'Active' : 'Inactive' }}</span>
                        <div class="flex gap-1">
                            <a href="{{ route('admin.website.leaders.edit', $leader) }}" class="p-1.5 rounded-lg hover:bg-primary/10 text-primary transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            <form method="POST" action="{{ route('admin.website.leaders.destroy', $leader) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="p-1.5 rounded-lg hover:bg-danger/10 text-danger transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-muted">No leaders added yet.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
