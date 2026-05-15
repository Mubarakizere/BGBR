<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-text leading-tight">
            {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-8 px-6">
        <div class="max-w-7xl mx-auto">

            {{-- Back Link --}}
            <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-primary font-semibold mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Activities
            </a>

            {{-- Activity Detail Card --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden mb-8">
                {{-- Header with gradient --}}
                <div class="bg-gradient-to-r from-primary to-primary/80 px-8 py-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white rounded-full mix-blend-overlay opacity-10"></div>
                    <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-32 h-32 bg-white rounded-full mix-blend-overlay opacity-10"></div>

                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-2xl font-black text-white">{{ $activity->title }}</h1>
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                    @if($activity->status === 'upcoming') bg-secondary/20 text-secondary
                                    @elseif($activity->status === 'ongoing') bg-success/20 text-green-200
                                    @elseif($activity->status === 'completed') bg-white/20 text-white
                                    @else bg-danger/20 text-red-200 @endif">
                                    {{ $activity->status }}
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-4 text-white/70 text-sm">
                                @if($activity->date)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $activity->date->format('F d, Y') }}
                                </span>
                                @endif
                                @if($activity->location)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $activity->location }}
                                </span>
                                @endif
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ number_format($activity->participation_fee, 0) }} RWF per participant
                                </span>
                            </div>
                        </div>

                        @can('update', $activity)
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('activities.edit', $activity) }}" class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded-xl text-sm transition backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Are you sure you want to delete this activity? All participation records will be removed.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 bg-danger/20 hover:bg-danger/40 text-white font-bold py-2 px-4 rounded-xl text-sm transition backdrop-blur-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>

                {{-- Stats & Details --}}
                <div class="p-8">
                    @php
                        $totalParticipants = $activity->members->count();
                        $paidCount = $activity->members->where('pivot.fee_paid', true)->count();
                        $unpaidCount = $totalParticipants - $paidCount;
                        $totalExpected = $totalParticipants * $activity->participation_fee;
                        $totalCollected = $paidCount * $activity->participation_fee;
                        $percentage = $totalExpected > 0 ? round(($totalCollected / $totalExpected) * 100) : 0;
                    @endphp

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-background rounded-xl p-4 text-center border border-border">
                            <p class="text-[10px] text-muted font-bold uppercase tracking-widest mb-1">Total Participants</p>
                            <p class="text-2xl font-black text-text">{{ $totalParticipants }}</p>
                        </div>
                        <div class="bg-background rounded-xl p-4 text-center border border-border">
                            <p class="text-[10px] text-muted font-bold uppercase tracking-widest mb-1">Fees Paid</p>
                            <p class="text-2xl font-black text-success">{{ $paidCount }}</p>
                        </div>
                        <div class="bg-background rounded-xl p-4 text-center border border-border">
                            <p class="text-[10px] text-muted font-bold uppercase tracking-widest mb-1">Fees Unpaid</p>
                            <p class="text-2xl font-black text-danger">{{ $unpaidCount }}</p>
                        </div>
                        <div class="bg-background rounded-xl p-4 text-center border border-border">
                            <p class="text-[10px] text-muted font-bold uppercase tracking-widest mb-1">Collected</p>
                            <p class="text-2xl font-black text-primary">{{ number_format($totalCollected, 0) }} <span class="text-xs text-muted">RWF</span></p>
                        </div>
                    </div>

                    {{-- Fee Progress Bar --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-muted font-semibold">Fee Collection Progress</span>
                            <span class="font-bold text-text">{{ number_format($totalCollected, 0) }} / {{ number_format($totalExpected, 0) }} RWF ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-background rounded-full h-3 overflow-hidden border border-border">
                            <div class="h-full rounded-full transition-all duration-700
                                @if($percentage >= 80) bg-success
                                @elseif($percentage >= 40) bg-secondary
                                @else bg-danger @endif"
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    {{-- Description & Requirements --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($activity->description)
                        <div class="bg-background rounded-xl p-5 border border-border">
                            <h4 class="text-sm font-bold text-text mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Description
                            </h4>
                            <p class="text-sm text-muted whitespace-pre-line">{{ $activity->description }}</p>
                        </div>
                        @endif

                        @if($activity->requirements)
                        <div class="bg-secondary/5 rounded-xl p-5 border border-secondary/20">
                            <h4 class="text-sm font-bold text-text mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                Eligibility Requirements
                            </h4>
                            <p class="text-sm text-muted whitespace-pre-line">{{ $activity->requirements }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Register Participant Section --}}
            @can('registerParticipant', App\Models\Activity::class)
            <div class="bg-surface rounded-2xl border border-border shadow-sm p-6 mb-8">
                <h3 class="text-lg font-bold text-text mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Register a Participant
                </h3>

                @php
                    // Get eligible members from the current user's company
                    $user = auth()->user();
                    $availableMembers = \App\Models\Member::where('company_id', $user->company_id)
                        ->whereNotIn('id', $activity->members->pluck('id'))
                        ->orderBy('name')
                        ->get();
                @endphp

                @if($availableMembers->count() > 0)
                <form method="POST" action="{{ route('activities.participants.store', $activity) }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1">
                        <select name="member_id" required class="w-full rounded-xl border-border bg-background text-text px-4 py-3 focus:ring-2 focus:ring-primary/30 focus:border-primary transition text-sm">
                            <option value="">Select a member to register...</option>
                            @foreach($availableMembers as $m)
                                <option value="{{ $m->id }}" {{ !$m->registration_fee_paid ? 'disabled' : '' }}>
                                    {{ $m->name }} ({{ $m->rank }})
                                    {{ !$m->registration_fee_paid ? '— ⚠ Registration fee not paid' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Register
                    </button>
                </form>

                {{-- Eligibility notice --}}
                @if($availableMembers->where('registration_fee_paid', false)->count() > 0)
                <div class="mt-3 bg-secondary/5 border border-secondary/20 rounded-xl p-3 flex items-start gap-2">
                    <svg class="w-4 h-4 text-secondary mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                    <p class="text-xs text-muted">Members whose registration fee has not been paid are shown as disabled and cannot be registered.</p>
                </div>
                @endif

                @else
                <div class="bg-background rounded-xl p-4 text-center border border-border">
                    <p class="text-sm text-muted">All eligible members from your company are already registered, or no members available.</p>
                </div>
                @endif
            </div>
            @endcan

            {{-- Participants Table --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-border flex items-center justify-between">
                    <h3 class="text-lg font-bold text-text flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Participants ({{ $totalParticipants }})
                    </h3>
                </div>

                @if($activity->members->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead class="bg-background">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-muted uppercase tracking-widest">#</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-muted uppercase tracking-widest">Member</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-muted uppercase tracking-widest">Rank</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-muted uppercase tracking-widest">Company</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-muted uppercase tracking-widest">Fee Status</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-muted uppercase tracking-widest">Payment Date</th>
                                <th class="px-6 py-3 text-right text-[10px] font-bold text-muted uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($activity->members as $index => $member)
                            <tr class="hover:bg-background/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-muted">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-text">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-muted">{{ $member->rank }}</td>
                                <td class="px-6 py-4 text-sm text-muted">{{ $member->company->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if($member->pivot->fee_paid)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-success/10 text-success">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Paid
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-danger/10 text-danger">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path></svg>
                                        Unpaid
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-muted">
                                    {{ $member->pivot->payment_date ? \Carbon\Carbon::parse($member->pivot->payment_date)->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @can('markPayment', App\Models\Activity::class)
                                            @if(!$member->pivot->fee_paid)
                                            <form method="POST" action="{{ route('activities.participants.pay', [$activity, $member]) }}"
                                                  onsubmit="return confirm('Mark fee as paid for {{ $member->name }}? This will create a national account deposit of {{ number_format($activity->participation_fee, 0) }} RWF.')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="inline-flex items-center gap-1 text-xs font-bold text-success hover:text-white bg-success/10 hover:bg-success px-3 py-1.5 rounded-lg transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Mark Paid
                                                </button>
                                            </form>
                                            @endif
                                        @endcan

                                        @can('registerParticipant', App\Models\Activity::class)
                                        <form method="POST" action="{{ route('activities.participants.remove', [$activity, $member]) }}"
                                              onsubmit="return confirm('Remove {{ $member->name }} from this activity?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-xs font-bold text-danger hover:text-white bg-danger/10 hover:bg-danger px-3 py-1.5 rounded-lg transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Remove
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <div class="p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-sm font-bold text-text mb-1">No Participants Yet</h4>
                    <p class="text-xs text-muted">Register members to this activity using the form above.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
