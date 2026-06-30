<x-app-layout>
    <x-slot name="header">
        {{ __('Battalion Details') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-text tracking-tight">{{ $battalion->name }}</h1>
                    <p class="text-sm text-muted mt-1">
                        Denomination: {{ $battalion->denomination->name ?? 'N/A' }} 
                    </p>
                </div>
                <a href="{{ route('battalions.index') }}" class="px-5 py-2.5 bg-surface border border-border text-text text-sm font-bold rounded-xl shadow-sm hover:bg-background transition-all">
                    Back to Battalions
                </a>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Status --}}
                <div class="bg-surface rounded-2xl border border-border p-6 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 {{ $battalion->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                        @if($battalion->is_active)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @endif
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted mb-1">Status</h3>
                    <p class="text-xl font-extrabold {{ $battalion->is_active ? 'text-success' : 'text-danger' }}">
                        {{ $battalion->is_active ? 'ACTIVE' : 'INACTIVE' }}
                    </p>
                </div>

                {{-- Companies Count --}}
                <div class="bg-surface rounded-2xl border border-border p-6 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted mb-1">Total Companies</h3>
                    <p class="text-2xl font-extrabold text-text">{{ $battalion->companies->count() }}</p>
                </div>

                {{-- Contribution --}}
                <div class="bg-surface rounded-2xl border border-border p-6 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted mb-1">Overall Fee Contribution</h3>
                    <p class="text-2xl font-extrabold text-text">{{ $battalion->contributionPercentage }}%</p>
                </div>
            </div>

            {{-- Companies List --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-border bg-background">
                    <h3 class="text-lg font-bold text-text">Companies in Battalion</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead>
                            <tr class="bg-background">
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Company</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Status</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Members</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Contribution</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($battalion->companies as $company)
                            <tr class="hover:bg-primary/[0.02] transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-text">
                                    {{ $company->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($company->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-success/10 border border-success/20 text-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-danger/10 border border-danger/20 text-danger">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    {{ $company->members()->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text font-bold">
                                    {{ $company->contributionPercentage }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-sm font-semibold text-text">No companies found</p>
                                    <p class="text-xs text-muted mt-1">This battalion does not have any companies assigned yet.</p>
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
