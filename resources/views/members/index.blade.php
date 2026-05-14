<x-app-layout>
    <x-slot name="header">
        {{ __('Members Management') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Title Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-text tracking-tight">Members Directory</h1>
                    <p class="text-sm text-muted mt-1">Manage and track all registered members</p>
                </div>
                <a href="{{ route('members.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Member
                </a>
            </div>

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">Total</p>
                        <p class="text-lg font-extrabold text-text">{{ $members->total() }}</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-success/10 flex items-center justify-center text-success">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">Fee Paid</p>
                        <p class="text-lg font-extrabold text-text">{{ \App\Models\Member::where('registration_fee_paid', true)->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-danger/10 flex items-center justify-center text-danger">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">Fee Pending</p>
                        <p class="text-lg font-extrabold text-text">{{ \App\Models\Member::where('registration_fee_paid', false)->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">This Month</p>
                        <p class="text-lg font-extrabold text-text">{{ \App\Models\Member::whereMonth('created_at', now()->month)->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Members Table Card --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border" id="members-table">
                        <thead>
                            <tr class="bg-background">
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Member</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Company</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Tenure</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Fee Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse ($members as $member)
                                <tr class="hover:bg-primary/[0.02] transition-colors duration-150 group">
                                    {{-- Member Info --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('members.show', $member) }}" class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden ring-2 ring-border group-hover:ring-primary/30 transition-all">
                                                @if($member->photo_path)
                                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $member->photo_path) }}" alt="{{ $member->name }}">
                                                @else
                                                    <div class="w-full h-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-text group-hover:text-primary transition-colors">{{ $member->name }}</p>
                                                <p class="text-xs text-muted">{{ $member->rank }}</p>
                                            </div>
                                        </a>
                                    </td>

                                    {{-- Company --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-text font-medium">{{ $member->company->name ?? 'N/A' }}</p>
                                    </td>

                                    {{-- Tenure --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-muted">{{ $member->tenure ?? '0' }} yrs</p>
                                    </td>

                                    {{-- Fee Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($member->registration_fee_paid)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-success/10 text-success">
                                                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                                Paid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-danger/10 text-danger">
                                                <span class="w-1.5 h-1.5 rounded-full bg-danger animate-pulse"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('members.show', $member) }}" class="p-2 rounded-lg text-muted hover:text-primary hover:bg-primary/10 transition-all" title="View">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('members.edit', $member) }}" class="p-2 rounded-lg text-muted hover:text-primary hover:bg-primary/10 transition-all" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-muted hover:text-danger hover:bg-danger/10 transition-all" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-full bg-primary/5 flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </div>
                                            <p class="text-sm font-semibold text-text mb-1">No members found</p>
                                            <p class="text-xs text-muted mb-4">Get started by adding your first member</p>
                                            <a href="{{ route('members.create') }}" class="text-sm font-bold text-primary hover:underline">+ Add Member</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($members->hasPages())
                    <div class="px-6 py-4 border-t border-border bg-background/50">
                        {{ $members->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
