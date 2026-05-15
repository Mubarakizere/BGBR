<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-text leading-tight">
            {{ __('Activities') }}
        </h2>
    </x-slot>

    <div class="py-8 px-6">
        <div class="max-w-7xl mx-auto">

            {{-- Page Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black text-text">Activities Management</h1>
                    <p class="text-muted text-sm mt-1">Manage national activities and track member participation</p>
                </div>
                @can('create', App\Models\Activity::class)
                <a href="{{ route('activities.create') }}"
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Activity
                </a>
                @endcan
            </div>

            {{-- Filters --}}
            <div class="bg-surface rounded-2xl border border-border p-4 mb-6 shadow-sm">
                <form method="GET" action="{{ route('activities.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search activities..."
                               class="w-full rounded-xl border-border bg-background text-text text-sm px-4 py-2.5 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                    </div>
                    <select name="status" class="rounded-xl border-border bg-background text-text text-sm px-4 py-2.5 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">All Statuses</option>
                        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="bg-primary/10 hover:bg-primary/20 text-primary font-bold py-2.5 px-5 rounded-xl transition-colors text-sm">
                        Filter
                    </button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('activities.index') }}" class="bg-background hover:bg-border text-muted font-bold py-2.5 px-5 rounded-xl transition-colors text-sm text-center">
                        Clear
                    </a>
                    @endif
                </form>
            </div>

            {{-- Activities Grid --}}
            @if($activities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                <a href="{{ route('activities.show', $activity) }}"
                   class="group bg-surface rounded-2xl border border-border shadow-sm hover:shadow-lg hover:border-primary/30 transition-all duration-300 overflow-hidden">
                    {{-- Status Bar --}}
                    <div class="h-1.5
                        @if($activity->status === 'upcoming') bg-secondary
                        @elseif($activity->status === 'ongoing') bg-success
                        @elseif($activity->status === 'completed') bg-primary
                        @else bg-danger @endif">
                    </div>

                    <div class="p-6">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-black text-text group-hover:text-primary transition-colors truncate">{{ $activity->title }}</h3>
                                @if($activity->location)
                                <p class="text-xs text-muted mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $activity->location }}
                                </p>
                                @endif
                            </div>
                            <span class="shrink-0 ml-3 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                @if($activity->status === 'upcoming') bg-secondary/15 text-secondary
                                @elseif($activity->status === 'ongoing') bg-success/15 text-success
                                @elseif($activity->status === 'completed') bg-primary/15 text-primary
                                @else bg-danger/15 text-danger @endif">
                                {{ $activity->status }}
                            </span>
                        </div>

                        {{-- Date --}}
                        @if($activity->date)
                        <div class="flex items-center gap-2 text-sm text-muted mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $activity->date->format('M d, Y') }}
                        </div>
                        @endif

                        {{-- Stats Row --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-background rounded-xl p-3 text-center">
                                <p class="text-[10px] text-muted font-bold uppercase tracking-widest">Fee</p>
                                <p class="text-lg font-black text-text">{{ number_format($activity->participation_fee, 0) }} <span class="text-xs text-muted">RWF</span></p>
                            </div>
                            <div class="bg-background rounded-xl p-3 text-center">
                                <p class="text-[10px] text-muted font-bold uppercase tracking-widest">Participants</p>
                                <p class="text-lg font-black text-text">{{ $activity->members_count ?? $activity->members()->count() }}</p>
                            </div>
                        </div>

                        {{-- Fee Progress --}}
                        @php
                            $totalExpected = ($activity->members_count ?? $activity->members()->count()) * $activity->participation_fee;
                            $totalCollected = $activity->paidParticipants()->count() * $activity->participation_fee;
                            $percentage = $totalExpected > 0 ? round(($totalCollected / $totalExpected) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="text-muted font-semibold">Fees Collected</span>
                                <span class="font-bold text-text">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-background rounded-full h-2 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500
                                    @if($percentage >= 80) bg-success
                                    @elseif($percentage >= 40) bg-secondary
                                    @else bg-danger @endif"
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $activities->withQueryString()->links() }}
            </div>

            @else
            {{-- Empty State --}}
            <div class="bg-surface rounded-2xl border border-border p-16 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-text mb-2">No Activities Found</h3>
                <p class="text-muted text-sm mb-6">
                    @if(request('search') || request('status'))
                        No activities match your current filters.
                    @else
                        Get started by creating your first activity.
                    @endif
                </p>
                @can('create', App\Models\Activity::class)
                <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-primary/25 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Activity
                </a>
                @endcan
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
