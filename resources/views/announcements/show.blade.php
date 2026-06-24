<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('announcements.index') }}" class="w-8 h-8 rounded-lg bg-surface border border-border flex items-center justify-center text-muted hover:text-text hover:border-text/20 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="font-bold">Announcement Details</div>
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 py-8 max-w-4xl mx-auto">
        @php
            $levelStyles = [
                'national' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-600', 'border' => 'border-blue-500/20', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                'domination' => ['bg' => 'bg-violet-500/10', 'text' => 'text-violet-600', 'border' => 'border-violet-500/20', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                'battalion' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600', 'border' => 'border-emerald-500/20', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                'company' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-600', 'border' => 'border-amber-500/20', 'icon' => 'M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
            ];
            $style = $levelStyles[$announcement->visibility_level] ?? ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'border' => 'border-primary/20', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
        @endphp

        <div class="bg-surface rounded-3xl shadow-lg border border-border overflow-hidden relative">
            {{-- Decorative background --}}
            <div class="absolute top-0 right-0 p-12 opacity-[0.03] pointer-events-none">
                <svg class="w-64 h-64" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            </div>

            {{-- Header --}}
            <div class="p-8 sm:p-12 border-b border-border bg-background/30 relative z-10">
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"></path></svg>
                        {{ $announcement->visibility_level }}
                    </span>
                    @php $entities = $announcement->entities; @endphp
                    @if($entities->count() > 0)
                        <span class="text-sm text-muted font-bold flex items-center gap-1.5 bg-surface px-3 py-1.5 rounded-lg border border-border shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            @if($entities->count() > 1)
                                <span class="cursor-help border-b border-dashed border-muted" title="{{ $entities->pluck('name')->join(', ') }}">{{ $entities->count() }} Selected</span>
                            @else
                                {{ $entities->first()->name }}
                            @endif
                        </span>
                    @endif
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-text mb-6 leading-tight tracking-tight">{{ $announcement->title }}</h1>
                
                <div class="flex flex-wrap items-center gap-6 bg-surface border border-border rounded-xl p-4 inline-flex shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-lg">
                            {{ substr($announcement->creator?->name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-black text-text">{{ $announcement->creator?->name ?? 'System' }}</div>
                            <div class="text-xs font-medium text-muted">Author</div>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-border hidden sm:block"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-background border border-border flex items-center justify-center text-muted">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-text">{{ $announcement->created_at->format('M d, Y') }}</div>
                            <div class="text-xs font-medium text-muted">{{ $announcement->created_at->format('h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 sm:p-12 text-text leading-loose text-[15px] relative z-10">
                <div class="prose prose-sm sm:prose-base max-w-none prose-headings:font-black prose-headings:text-text prose-a:text-primary prose-a:font-bold hover:prose-a:text-primary/80 prose-strong:font-black prose-strong:text-text">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
            </div>

            {{-- Actions --}}
            @if(auth()->user()->hasRole('Super Admin') || auth()->id() === $announcement->created_by)
            <div class="p-6 border-t border-border bg-background/50 flex items-center justify-end gap-3 relative z-10">
                <a href="{{ route('announcements.edit', $announcement) }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-surface border border-border text-text font-bold text-sm hover:bg-background transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Announcement
                </a>
                <button type="button" 
                    @click="$dispatch('open-delete-modal', { action: '{{ route('announcements.destroy', $announcement) }}', message: 'Are you sure you want to delete this announcement? This action cannot be undone.' })"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-danger text-white font-bold text-sm hover:bg-danger/90 transition-all shadow-sm shadow-danger/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete
                </button>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
