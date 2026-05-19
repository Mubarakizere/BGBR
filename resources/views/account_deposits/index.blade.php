<x-app-layout>
    <x-slot name="header">
        Account Deposits
    </x-slot>

    <div class="px-6 py-8" x-data="{ openModal: false, filterLevel: '{{ request('level', '') }}', modalLevel: 'national' }">
        
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-text tracking-tight">Account Deposits</h1>
                <p class="text-sm text-muted mt-1">Track and manage financial deposits at battalion and national levels.</p>
            </div>
            @can('create', App\Models\AccountDeposit::class)
            <button @click="openModal = true" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Record Deposit
            </button>
            @endcan
        </div>

        {{-- Interactive Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-primary/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Total Managed</p>
                    <p class="text-xl font-black text-text">{{ number_format($totalAmount, 2) }} <span class="text-sm font-semibold text-muted">RWF</span></p>
                </div>
            </div>
            
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-indigo-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">National Treasury</p>
                    <p class="text-xl font-black text-indigo-600">{{ number_format($nationalAmount, 2) }} <span class="text-sm font-semibold text-muted">RWF</span></p>
                </div>
            </div>

            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-emerald-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Battalion Holdings</p>
                    <p class="text-xl font-black text-emerald-600">{{ number_format($battalionAmount, 2) }} <span class="text-sm font-semibold text-muted">RWF</span></p>
                </div>
            </div>

            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-secondary/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Transactions</p>
                    <p class="text-xl font-black text-text">{{ number_format($transactionCount) }}</p>
                </div>
            </div>
        </div>

        {{-- Advanced Filter Card --}}
        <div class="mb-6 bg-surface rounded-2xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('account-deposits.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description..." class="w-full pl-10 bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <select name="level" x-model="filterLevel" class="bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="">All Levels</option>
                    <option value="national">National</option>
                    <option value="battalion">Battalion</option>
                </select>

                <div x-show="filterLevel === 'battalion' || filterLevel === ''" x-transition.opacity class="min-w-[200px]">
                    <select name="battalion_id" class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        <option value="">All Battalions</option>
                        @foreach($battalions as $btn)
                            <option value="{{ $btn->id }}" {{ request('battalion_id') == $btn->id ? 'selected' : '' }}>{{ $btn->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-primary/10 text-primary font-bold py-2.5 px-5 rounded-xl hover:bg-primary/20 transition-colors text-sm">Apply Filters</button>
                
                @if(request()->anyFilled(['search', 'level', 'battalion_id']))
                <a href="{{ route('account-deposits.index') }}" class="text-sm text-muted hover:text-text font-medium transition-colors">Clear</a>
                @endif
            </form>
        </div>

        {{-- Premium Table --}}
        <div class="bg-surface border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-background/50 border-b border-border">
                            <th class="px-6 py-4 text-left text-xs font-black text-muted uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-muted uppercase tracking-wider">Level & Entity</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-muted uppercase tracking-wider">Description</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-muted uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-muted uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($deposits as $deposit)
                        <tr class="hover:bg-background/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-semibold text-text">{{ $deposit->created_at->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($deposit->level === 'national')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-black bg-indigo-50 text-indigo-700 uppercase tracking-widest border border-indigo-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                                        National
                                    </span>
                                @else
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-black bg-emerald-50 text-emerald-700 uppercase tracking-widest border border-emerald-100">
                                            Battalion
                                        </span>
                                        <span class="text-sm font-medium text-muted truncate max-w-[200px]">
                                            {{ $deposit->entity->name ?? 'Unknown' }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-text font-medium">{{ $deposit->description ?: '—' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-lg font-black text-text group-hover:text-primary transition-colors">
                                    {{ number_format($deposit->amount, 2) }} <span class="text-xs font-bold text-muted ml-1">RWF</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @can('delete', $deposit)
                                <form action="{{ route('account-deposits.destroy', $deposit) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this deposit record? This action cannot be undone.')" class="w-8 h-8 rounded-lg flex items-center justify-center text-muted hover:bg-danger/10 hover:text-danger transition-colors" title="Delete Deposit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-background mb-4">
                                    <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-text mb-1">No deposits found</h3>
                                <p class="text-sm text-muted">There are no financial records matching your current criteria.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($deposits->hasPages())
            <div class="px-6 py-4 border-t border-border bg-background/30">
                {{ $deposits->links() }}
            </div>
            @endif
        </div>

        {{-- Record Deposit Modal --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                
                {{-- Backdrop --}}
                <div x-show="openModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-[#0F1847]/40 backdrop-blur-sm" 
                     @click="openModal = false"></div>

                {{-- Modal Panel --}}
                <div x-show="openModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block w-full max-w-lg overflow-hidden text-left align-bottom transition-all transform bg-surface rounded-2xl shadow-2xl sm:my-8 sm:align-middle border border-border">
                    
                    <div class="px-6 py-5 border-b border-border bg-background/50 flex justify-between items-center">
                        <h3 class="text-lg font-black text-text">Record Deposit</h3>
                        <button @click="openModal = false" class="text-muted hover:text-text transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('account-deposits.store') }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-5">
                            
                            {{-- Amount --}}
                            <div>
                                <label class="block text-sm font-bold text-text mb-1.5">Amount (RWF) <span class="text-danger">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-muted font-bold">RWF</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" name="amount" required class="w-full pl-14 bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>

                            {{-- Level --}}
                            @if(auth()->user()->hasRole('Super Admin'))
                            <div>
                                <label class="block text-sm font-bold text-text mb-1.5">Deposit Level <span class="text-danger">*</span></label>
                                <select name="level" x-model="modalLevel" required class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <option value="national">National Level</option>
                                    <option value="battalion">Battalion Level</option>
                                </select>
                            </div>
                            @else
                            {{-- Domination Admins can only record battalion deposits --}}
                            <input type="hidden" name="level" value="battalion">
                            <div x-init="modalLevel = 'battalion'"></div>
                            @endif

                            {{-- Battalion Select (only shown if level is battalion) --}}
                            <div x-show="modalLevel === 'battalion'" x-transition.opacity>
                                <label class="block text-sm font-bold text-text mb-1.5">Select Battalion <span class="text-danger">*</span></label>
                                <select name="entity_id" :required="modalLevel === 'battalion'" :disabled="modalLevel !== 'battalion'" class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <option value="">-- Select Battalion --</option>
                                    @foreach($battalions as $btn)
                                        <option value="{{ $btn->id }}">{{ $btn->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- National Entity ID --}}
                            <div x-show="modalLevel === 'national'">
                                <input type="hidden" name="entity_id" value="{{ auth()->id() }}" :disabled="modalLevel !== 'national'">
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-bold text-text mb-1.5">Description / Memo</label>
                                <input type="text" name="description" placeholder="Optional details about this deposit" class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            
                        </div>

                        <div class="px-6 py-4 bg-background border-t border-border flex justify-end gap-3">
                            <button type="button" @click="openModal = false" class="px-5 py-2.5 text-sm font-bold text-text hover:bg-surface border border-border rounded-xl transition-colors shadow-sm">Cancel</button>
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Save Deposit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
