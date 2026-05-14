<x-app-layout>
    <x-slot name="header">
        {{ __('Member Profile') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header with Actions --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('members.index') }}" class="w-10 h-10 rounded-xl bg-surface border border-border flex items-center justify-center text-muted hover:text-primary hover:border-primary/30 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold text-text tracking-tight">Member Profile</h1>
                        <p class="text-sm text-muted mt-0.5">Detailed information for this member</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('members.edit', $member) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-border bg-surface text-sm font-semibold text-text hover:border-primary/30 hover:text-primary transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <a href="{{ route('members.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary text-white text-sm font-bold shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        All Members
                    </a>
                </div>
            </div>

            {{-- Profile Hero Card --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden mb-6">
                {{-- Gradient Banner --}}
                <div class="relative h-36 bg-gradient-to-br from-primary via-[#2A3FBF] to-[#141E55]">
                    <div class="absolute top-4 right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                    <div class="absolute bottom-0 left-6 w-16 h-16 bg-white/5 rounded-full blur-lg"></div>

                    {{-- Fee Status Badge on Banner --}}
                    <div class="absolute top-4 right-4">
                        @if($member->registration_fee_paid)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-success/20 text-white backdrop-blur-sm border border-success/30">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Fee Paid
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-danger/20 text-white backdrop-blur-sm border border-danger/30">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Fee Pending
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Profile Info --}}
                <div class="px-6 pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-12 relative z-10">
                        {{-- Avatar --}}
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden ring-4 ring-surface shadow-xl flex-shrink-0 bg-surface">
                            @if($member->photo_path)
                                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $member->photo_path) }}" alt="{{ $member->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl font-black text-primary bg-primary/10">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Name & Rank --}}
                        <div class="pb-1">
                            <h2 class="text-2xl font-extrabold text-text tracking-tight">{{ $member->name }}</h2>
                            <p class="text-sm font-medium text-muted mt-0.5">{{ $member->rank }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Assignment Info --}}
                <div class="bg-surface rounded-2xl border border-border shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-text">Assignment Info</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-border/50">
                            <span class="text-sm text-muted">Company</span>
                            <span class="text-sm font-semibold text-text">{{ $member->company->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-border/50">
                            <span class="text-sm text-muted">Battalion</span>
                            <span class="text-sm font-semibold text-text">{{ $member->company->battalion->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm text-muted">Domination</span>
                            <span class="text-sm font-semibold text-text">{{ $member->company->battalion->domination->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Service Details --}}
                <div class="bg-surface rounded-2xl border border-border shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-lg bg-success/10 flex items-center justify-center text-success">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-text">Service Details</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-border/50">
                            <span class="text-sm text-muted">Tenure</span>
                            <span class="text-sm font-semibold text-text">{{ $member->tenure ?? '0' }} Years</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-border/50">
                            <span class="text-sm text-muted">Member Since</span>
                            <span class="text-sm font-semibold text-text">{{ $member->created_at->format('F j, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm text-muted">System ID</span>
                            <span class="text-xs font-mono bg-background px-2 py-1 rounded-lg border border-border text-muted">{{ $member->id }}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
