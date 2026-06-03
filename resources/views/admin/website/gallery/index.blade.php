<x-app-layout>
    <x-slot name="header">Gallery</x-slot>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div><h2 class="text-xl font-extrabold text-text">Photo Gallery</h2><p class="text-sm text-muted">Upload and manage photos for the public gallery.</p></div>
            <a href="{{ route('admin.website.gallery.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Upload Image</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($images as $image)
            <div class="bg-surface rounded-2xl border border-border overflow-hidden group">
                <div class="aspect-square overflow-hidden"><img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $image->title }}"></div>
                <div class="p-3">
                    <p class="text-xs font-semibold text-text truncate">{{ $image->title ?? 'Untitled' }}</p>
                    @if($image->album)<p class="text-[10px] text-primary font-bold uppercase mt-0.5">{{ $image->album }}</p>@endif
                    <div class="flex items-center justify-between mt-2">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $image->is_active ? 'bg-success/10 text-success' : 'bg-muted/10 text-muted' }}">{{ $image->is_active ? 'Active' : 'Hidden' }}</span>
                        <div class="flex gap-1">
                            <a href="{{ route('admin.website.gallery.edit', $image) }}" class="p-1 rounded hover:bg-primary/10 text-primary transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            <form method="POST" action="{{ route('admin.website.gallery.destroy', $image) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-1 rounded hover:bg-danger/10 text-danger transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-muted">No gallery images yet.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
