<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('announcements.index') }}" class="text-muted hover:text-text transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            Announcement Details
        </div>
    </x-slot>

    <div class="px-6 py-8 max-w-4xl mx-auto">
        @php
            $levelColors = [
                'national' => 'bg-primary/10 text-primary border-primary/20',
                'domination' => 'bg-secondary/10 text-secondary border-secondary/20',
                'battalion' => 'bg-success/10 text-success border-success/20',
                'company' => 'bg-accent/10 text-accent border-accent/20',
            ];
            $color = $levelColors[$announcement->visibility_level] ?? 'bg-primary/10 text-primary';
        @endphp

        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            {{-- Header --}}
            <div class="p-8 border-b border-border">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest border {{ $color }}">
                        {{ $announcement->visibility_level }}
                    </span>
                    @if($announcement->entity)
                        <span class="text-sm text-muted font-medium">→ {{ $announcement->entity->name ?? '' }}</span>
                    @endif
                </div>
                <h1 class="text-2xl font-black text-text mb-3">{{ $announcement->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-muted">
                    <span>By <strong class="text-text">{{ $announcement->creator?->name ?? 'System' }}</strong></span>
                    <span>·</span>
                    <span>{{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 prose prose-sm max-w-none text-text leading-relaxed">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            {{-- Actions --}}
            @if(auth()->user()->hasRole('Super Admin') || auth()->id() === $announcement->created_by)
            <div class="p-6 border-t border-border bg-background/50 flex items-center justify-end gap-3">
                <a href="{{ route('announcements.edit', $announcement) }}" class="px-5 py-2.5 rounded-xl bg-primary/10 text-primary font-bold text-sm hover:bg-primary/20 transition-colors">
                    Edit
                </a>
                <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-danger/10 text-danger font-bold text-sm hover:bg-danger/20 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
