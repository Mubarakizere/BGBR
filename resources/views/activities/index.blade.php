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
                    <p class="text-muted text-sm mt-1">Manage activities, track participation & fee collection</p>
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
                    <select name="audience" class="rounded-xl border-border bg-background text-text text-sm px-4 py-2.5 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">All Audiences</option>
                        <option value="national" {{ request('audience') === 'national' ? 'selected' : '' }}>National</option>
                        <option value="denomination" {{ request('audience') === 'denomination' ? 'selected' : '' }}>Zone</option>
                        <option value="battalion" {{ request('audience') === 'battalion' ? 'selected' : '' }}>Battalion</option>
                        <option value="company" {{ request('audience') === 'company' ? 'selected' : '' }}>Company</option>
                    </select>
                    <button type="submit" class="bg-primary/10 hover:bg-primary/20 text-primary font-bold py-2.5 px-5 rounded-xl transition-colors text-sm">
                        Filter
                    </button>
                    @if(request('search') || request('status') || request('audience'))
                    <a href="{{ route('activities.index') }}" class="bg-background hover:bg-border text-muted font-bold py-2.5 px-5 rounded-xl transition-colors text-sm text-center">
                        Clear
                    </a>
                    @endif
                </form>
            </div>

            {{-- Activities Grid --}}
            @if($activities->count() > 0)
            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-background/50 border-b border-border">
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Activity</th>
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Target</th>
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Fee / Participants</th>
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider">Collection</th>
                                <th class="px-6 py-4 text-xs font-bold text-muted uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($activities as $activity)
                            <tr class="hover:bg-background/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <div class="font-bold text-text group-hover:text-primary transition-colors">
                                            {{ $activity->title }}
                                        </div>
                                        @if($activity->location)
                                        <div class="text-xs text-muted mt-0.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $activity->location }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    @if($activity->date)
                                        {{ $activity->date->format('M d, Y') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $entity = $activity->entity;
                                        $entityIsActive = true;
                                        if ($activity->target_audience === 'company' && $entity) {
                                            $entityIsActive = $entity->is_active;
                                        } elseif ($activity->target_audience === 'battalion' && $entity) {
                                            $entityIsActive = $entity->is_active;
                                        }
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                        @if($activity->target_audience === 'national') bg-primary/10 text-primary
                                        @elseif($activity->target_audience === 'denomination') bg-secondary/10 text-secondary
                                        @elseif($activity->target_audience === 'battalion') bg-success/10 text-success
                                        @else bg-danger/10 text-danger @endif">
                                        @if($activity->target_audience === 'national')
                                            National
                                        @else
                                            {{ ucfirst($activity->target_audience) }}: {{ $entity?->name ?? '—' }}
                                            @if(!$entityIsActive)
                                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-danger animate-pulse" title="Inactive"></span>
                                            @endif
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                        @if($activity->status === 'upcoming') bg-secondary/15 text-secondary
                                        @elseif($activity->status === 'ongoing') bg-success/15 text-success
                                        @elseif($activity->status === 'completed') bg-primary/15 text-primary
                                        @else bg-danger/15 text-danger @endif">
                                        {{ $activity->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="text-sm font-black text-text">{{ number_format($activity->participation_fee, 0) }} <span class="text-[10px] text-muted uppercase tracking-widest font-normal">RWF</span></div>
                                        <div class="text-xs text-muted">{{ $activity->members_count ?? $activity->members()->count() }} Participants</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap w-48">
                                    @php
                                        $totalExpected = ($activity->members_count ?? $activity->members()->count()) * $activity->participation_fee;
                                        $totalCollected = $activity->paidParticipants()->count() * $activity->participation_fee;
                                        $percentage = $totalExpected > 0 ? round(($totalCollected / $totalExpected) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center justify-between text-[10px] mb-1">
                                        <span class="text-muted font-bold uppercase tracking-widest">{{ $percentage }}% Collected</span>
                                    </div>
                                    <div class="w-full bg-background border border-border rounded-full h-1.5 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500
                                            @if($percentage >= 80) bg-success
                                            @elseif($percentage >= 40) bg-secondary
                                            @else bg-danger @endif"
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('activities.show', $activity) }}" class="inline-flex p-1.5 text-muted hover:text-primary transition-colors bg-background rounded-lg border border-border hover:border-primary/30 hover:shadow-sm" title="View Activity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    @if(request('search') || request('status') || request('audience'))
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
