<x-app-layout>
    <x-slot name="header">
        {{ __('Companies Management') }}
    </x-slot>

    <div class="py-8" x-data="{ openModal: false, editing: null, openOfficerModal: false, assigningTo: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Title Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-text tracking-tight">Companies</h1>
                    <p class="text-sm text-muted mt-1">Manage companies and assign officers</p>
                </div>
                <button @click="editing = null; openModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Company
                </button>
            </div>

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">Total Companies</p>
                        <p class="text-lg font-extrabold text-text">{{ $companies->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-success/10 flex items-center justify-center text-success">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">Total Officers</p>
                        <p class="text-lg font-extrabold text-text">{{ $companies->sum(fn($c) => $c->officers->count()) }}</p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl border border-border p-4 flex items-center gap-3 col-span-2 lg:col-span-1">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted">Avg Contribution</p>
                        <p class="text-lg font-extrabold text-text">{{ $companies->count() > 0 ? round($companies->avg(fn($c) => $c->contributionPercentage), 1) : 0 }}%</p>
                    </div>
                </div>
            </div>

            {{-- Companies Table Card --}}
            <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border" id="companies-table">
                        <thead>
                            <tr class="bg-background">
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Company</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Battalion</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Contribution</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-muted">Officers</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($companies as $company)
                            <tr class="hover:bg-primary/[0.02] transition-colors duration-150 group">
                                {{-- Company Name --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                            {{ strtoupper(substr($company->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-text">{{ $company->name }}</p>
                                            @if($company->date_started)
                                                <p class="text-xs text-muted">Since {{ \Carbon\Carbon::parse($company->date_started)->format('M Y') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Battalion --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-background border border-border text-text">
                                        {{ $company->battalion->name ?? '—' }}
                                    </span>
                                </td>

                                {{-- Contribution --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-32">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-bold text-text">{{ $company->contributionPercentage }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-border/50 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $company->contributionPercentage >= 75 ? 'bg-success' : ($company->contributionPercentage >= 40 ? 'bg-secondary' : 'bg-danger') }}"
                                                 style="width: {{ $company->contributionPercentage }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Officers --}}
                                <td class="px-6 py-4">
                                    @if($company->officers->count() > 0)
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($company->officers as $officer)
                                                <span class="inline-flex items-center gap-1 pl-1 pr-2 py-0.5 rounded-full text-[11px] font-medium bg-primary/5 border border-primary/10 text-text">
                                                    <span class="w-5 h-5 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[9px] font-bold">{{ strtoupper(substr($officer->name, 0, 1)) }}</span>
                                                    {{ Str::before($officer->name, ' ') }}
                                                    <span class="text-muted">({{ $officer->pivot->rank }})</span>
                                                    <form action="{{ route('companies.officers.remove', [$company, $officer]) }}" method="POST" class="inline" onsubmit="return confirm('Remove this officer?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="ml-0.5 text-muted hover:text-danger transition-colors">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </form>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-muted italic">No officers</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button @click="assigningTo = {{ $company->toJson() }}; openOfficerModal = true" class="p-2 rounded-lg text-muted hover:text-success hover:bg-success/10 transition-all" title="Assign Officer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        </button>
                                        <button @click="editing = {{ $company->toJson() }}; openModal = true" class="p-2 rounded-lg text-muted hover:text-primary hover:bg-primary/10 transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline" onsubmit="return confirm('Delete this company?');">
                                            @csrf @method('DELETE')
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
                                            <svg class="w-8 h-8 text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-text mb-1">No companies yet</p>
                                        <p class="text-xs text-muted mb-4">Get started by adding your first company</p>
                                        <button @click="editing = null; openModal = true" class="text-sm font-bold text-primary hover:underline">+ Add Company</button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ═══════ Add/Edit Company Modal ═══════ --}}
        <div x-show="openModal" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>
            {{-- Panel --}}
            <div class="relative bg-surface rounded-2xl shadow-2xl border border-border w-full max-w-lg z-10 overflow-hidden"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-border flex items-center justify-between bg-background">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-text" x-text="editing ? 'Edit Company' : 'Add Company'"></h3>
                    </div>
                    <button @click="openModal = false" class="text-muted hover:text-text transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                {{-- Modal Body --}}
                <form :action="editing ? '/companies/' + editing.id : '{{ route('companies.store') }}'" method="POST">
                    @csrf
                    <template x-if="editing"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" :value="editing ? editing.name : ''" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Enter company name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Battalion <span class="text-danger">*</span></label>
                            <select name="battalion_id" required x-init="$watch('editing', val => { if(val) $el.value = val.battalion_id })"
                                    class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                <option value="">— Select Battalion —</option>
                                @foreach($battalions as $btn)
                                    <option value="{{ $btn->id }}">{{ $btn->name }} ({{ $btn->domination->name ?? 'No Dom' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Date Started</label>
                            <input type="date" name="date_started" :value="editing ? editing.date_started : ''"
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>
                    </div>
                    {{-- Modal Footer --}}
                    <div class="px-6 py-4 border-t border-border bg-background flex items-center justify-end gap-3">
                        <button type="button" @click="openModal = false"
                                class="px-5 py-2.5 rounded-xl border border-border bg-surface text-sm font-semibold text-muted hover:text-text transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-bold shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 transition-all">
                            <span x-text="editing ? 'Update' : 'Save'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════ Assign Officer Modal ═══════ --}}
        <div x-show="openOfficerModal" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openOfficerModal = false"></div>
            <div class="relative bg-surface rounded-2xl shadow-2xl border border-border w-full max-w-lg z-10 overflow-hidden">
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-border flex items-center justify-between bg-background">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-success/10 flex items-center justify-center text-success">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-text">Assign Officer</h3>
                            <p class="text-xs text-muted">to <span class="font-semibold text-primary" x-text="assigningTo ? assigningTo.name : ''"></span></p>
                        </div>
                    </div>
                    <button @click="openOfficerModal = false" class="text-muted hover:text-text transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                {{-- Body --}}
                <form :action="assigningTo ? '/companies/' + assigningTo.id + '/officers' : '#'" method="POST">
                    @csrf
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Select User <span class="text-danger">*</span></label>
                            <select name="user_id" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                <option value="">— Select User —</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-1.5">Rank <span class="text-danger">*</span></label>
                            <select name="rank" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                <option value="NCO">NCO</option>
                                <option value="W/O">W/O</option>
                                <option value="Lt">Lt</option>
                                <option value="Capt">Capt</option>
                                <option value="Trainer">Trainer</option>
                            </select>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-border bg-background flex items-center justify-end gap-3">
                        <button type="button" @click="openOfficerModal = false"
                                class="px-5 py-2.5 rounded-xl border border-border bg-surface text-sm font-semibold text-muted hover:text-text transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-success text-white text-sm font-bold shadow-md shadow-success/20 hover:shadow-lg hover:shadow-success/30 transition-all">
                            Assign Officer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
