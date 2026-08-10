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
                    @can('manage activities')
                    <h1 class="text-2xl font-black text-text">Activities Management</h1>
                    <p class="text-muted text-sm mt-1">Manage activities, track participation & fee collection</p>
                    @else
                    <h1 class="text-2xl font-black text-text">Activities</h1>
                    <p class="text-muted text-sm mt-1">View upcoming activities and register to participate</p>
                    @endcan
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
                    @can('manage activities')
                    <select name="audience" class="rounded-xl border-border bg-background text-text text-sm px-4 py-2.5 focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">All Audiences</option>
                        <option value="national" {{ request('audience') === 'national' ? 'selected' : '' }}>National</option>
                        <option value="denomination" {{ request('audience') === 'denomination' ? 'selected' : '' }}>Zone</option>
                        <option value="battalion" {{ request('audience') === 'battalion' ? 'selected' : '' }}>Battalion</option>
                        <option value="company" {{ request('audience') === 'company' ? 'selected' : '' }}>Company</option>
                    </select>
                    @endcan
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

            {{-- Activities --}}
            @if($activities->count() > 0)

                {{-- ===== ADMIN / OFFICER VIEW: Full Management Table ===== --}}
                @if(auth()->user()->can('manage activities') || auth()->user()->can('submit activity participation'))
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

                {{-- ===== MEMBER VIEW: Clean Card Layout ===== --}}
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activities as $activity)
                    @php
                        $myMember = auth()->user()->member;
                        $myPivot = $myMember ? $activity->members()->where('member_id', $myMember->id)->first() : null;
                        $isRegistered = $myPivot !== null;
                    @endphp
                    <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                        {{-- Card Header --}}
                        <div class="bg-gradient-to-r from-primary to-primary/80 px-5 py-4 relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-white rounded-full mix-blend-overlay opacity-10"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider
                                        @if($activity->status === 'upcoming') bg-secondary/20 text-secondary
                                        @elseif($activity->status === 'ongoing') bg-success/20 text-green-200
                                        @elseif($activity->status === 'completed') bg-white/20 text-white
                                        @else bg-danger/20 text-red-200 @endif">
                                        {{ $activity->status }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-white/15 text-white/80">
                                        @if($activity->target_audience === 'national')
                                            National
                                        @else
                                            {{ ucfirst($activity->target_audience) }}
                                        @endif
                                    </span>
                                </div>
                                <h3 class="text-lg font-black text-white leading-tight">{{ $activity->title }}</h3>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5">
                            <div class="space-y-3 mb-4">
                                @if($activity->date)
                                <div class="flex items-center gap-2 text-sm text-muted">
                                    <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $activity->date->format('F d, Y') }}
                                </div>
                                @endif
                                @if($activity->location)
                                <div class="flex items-center gap-2 text-sm text-muted">
                                    <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $activity->location }}
                                </div>
                                @endif
                                @if($activity->participation_fee > 0)
                                <div class="flex items-center gap-2 text-sm text-muted">
                                    <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="font-bold text-text">{{ number_format($activity->participation_fee, 0) }} RWF</span>
                                </div>
                                @endif
                            </div>

                            @if($activity->description)
                            <p class="text-xs text-muted line-clamp-2 mb-4">{{ $activity->description }}</p>
                            @endif

                            {{-- Registration Status --}}
                            @if($isRegistered)
                                <div class="bg-background rounded-xl border border-border p-3 mb-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-xs font-bold text-success">Registered</span>
                                    </div>
                                    @if($myPivot->pivot->fee_paid)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-success/10 text-success">Payment Confirmed</span>
                                    @elseif($myPivot->pivot->payment_proof_path)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-secondary/10 text-secondary">Proof Submitted — Awaiting Confirmation</span>
                                    @elseif($activity->participation_fee > 0)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-danger/10 text-danger">Fee Unpaid</span>
                                    @endif
                                </div>
                            @endif

                            {{-- Actions --}}
                            <div class="flex items-center gap-2">
                                <a href="{{ route('activities.show', $activity) }}" class="flex-1 inline-flex items-center justify-center gap-2 bg-primary/10 hover:bg-primary/20 text-primary font-bold py-2.5 px-4 rounded-xl text-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View Details
                                </a>
                                @if(!$isRegistered && $myMember && $myMember->registration_fee_paid && $activity->status !== 'completed' && $activity->status !== 'cancelled')
                                <form method="POST" action="{{ route('activities.participants.self-register', $activity) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-all shadow-lg shadow-primary/20">
                                        Register
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

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
                    @elseif(auth()->user()->can('manage activities'))
                        Get started by creating your first activity.
                    @else
                        There are no activities available for you at this time. Check back later!
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
