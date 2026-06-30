<x-app-layout>
    <x-slot name="header">
        {{ __('Company Details') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-text tracking-tight">{{ $company->name }}</h1>
                    <p class="text-sm text-muted mt-1">
                        Battalion: {{ $company->battalion->name ?? 'N/A' }} 
                        @if($company->battalion && $company->battalion->denomination)
                            &mdash; {{ $company->battalion->denomination->name }}
                        @endif
                    </p>
                </div>
                <a href="{{ route('companies.index') }}" class="px-5 py-2.5 bg-surface border border-border text-text text-sm font-bold rounded-xl shadow-sm hover:bg-background transition-all">
                    Back to Companies
                </a>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Status --}}
                <div class="bg-surface rounded-2xl border border-border p-6 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 {{ $company->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                        @if($company->is_active)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @endif
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted mb-1">Status</h3>
                    <p class="text-xl font-extrabold {{ $company->is_active ? 'text-success' : 'text-danger' }}">
                        {{ $company->is_active ? 'ACTIVE' : 'INACTIVE' }}
                    </p>
                </div>

                {{-- Members Count --}}
                <div class="bg-surface rounded-2xl border border-border p-6 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted mb-1">Total Members</h3>
                    <p class="text-2xl font-extrabold text-text">{{ $company->members->count() }}</p>
                </div>

                {{-- Contribution --}}
                <div class="bg-surface rounded-2xl border border-border p-6 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted mb-1">Fee Contribution</h3>
                    <p class="text-2xl font-extrabold text-text">{{ $company->contributionPercentage }}%</p>
                </div>
            </div>

            {{-- Members List --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-border bg-background">
                    <h3 class="text-lg font-bold text-text">Company Members</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead>
                            <tr class="bg-background">
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Name</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Gender</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Phone</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Fee Paid</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($company->members as $member)
                            <tr class="hover:bg-primary/[0.02] transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-text">
                                    {{ $member->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    {{ $member->gender }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    {{ $member->phone ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($member->registration_fee_paid)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-success/10 border border-success/20 text-success">
                                            Yes
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-danger/10 border border-danger/20 text-danger">
                                            No
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-sm font-semibold text-text">No members found</p>
                                    <p class="text-xs text-muted mt-1">This company does not have any members yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
