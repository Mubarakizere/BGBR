<x-app-layout>
    <x-slot name="header">
        Materials Purchase Requests
    </x-slot>

    <div class="px-6 py-8" x-data="{ openModal: false, editing: null }">
        
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-text tracking-tight">Materials Purchase Requests</h1>
                <p class="text-sm text-muted mt-1">Track and manage inventory procurement requests submitted by companies.</p>
            </div>
            @can('create', App\Models\MaterialsRequest::class)
            <button @click="editing = null; openModal = true" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Request
            </button>
            @endcan
        </div>

        {{-- Dynamic Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-primary/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Total Requests</p>
                    <p class="text-2xl font-black text-text">{{ number_format($totalCount) }}</p>
                </div>
            </div>
            
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-yellow-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Pending Attention</p>
                    <p class="text-2xl font-black text-yellow-600">{{ number_format($pendingCount) }}</p>
                </div>
            </div>

            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-emerald-500/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Approved/Fulfilled</p>
                    <p class="text-2xl font-black text-emerald-600">{{ number_format($approvedCount) }}</p>
                </div>
            </div>

            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-4 group hover:border-danger/30 transition-all">
                <div class="w-12 h-12 rounded-xl bg-danger/10 flex items-center justify-center text-danger group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted uppercase tracking-wider">Rejected Requests</p>
                    <p class="text-2xl font-black text-danger">{{ number_format($rejectedCount) }}</p>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div class="mb-6 bg-surface rounded-2xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('materials-requests.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search item name..." class="w-full pl-10 bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <select name="status" class="bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="fulfilled" {{ request('status') === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <button type="submit" class="bg-primary/10 text-primary font-bold py-2.5 px-5 rounded-xl hover:bg-primary/20 transition-colors text-sm">Filter</button>
                
                @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('materials-requests.index') }}" class="text-sm text-muted hover:text-text font-medium transition-colors">Clear</a>
                @endif
            </form>
        </div>

        {{-- Premium Table --}}
        <div class="bg-surface border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-background/50 border-b border-border">
                            <th class="px-6 py-4 text-left text-xs font-black text-muted uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-muted uppercase tracking-wider">Requested Item</th>
                            <th class="px-6 py-4 text-center text-xs font-black text-muted uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-muted uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-muted uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($requests as $req)
                        <tr class="hover:bg-background/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-text">{{ $req->company->name ?? '-' }}</span>
                                    <span class="text-xs text-muted">{{ $req->company->battalion->name ?? 'Unknown Battalion' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-text group-hover:text-primary transition-colors">{{ $req->item_name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-text bg-background border border-border px-2.5 py-1 rounded-lg">{{ $req->quantity }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($req->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-black bg-yellow-50 text-yellow-700 uppercase tracking-widest border border-yellow-100">
                                        Pending
                                    </span>
                                @elseif($req->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-black bg-indigo-50 text-indigo-700 uppercase tracking-widest border border-indigo-100">
                                        Approved
                                    </span>
                                @elseif($req->status === 'fulfilled')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-black bg-emerald-50 text-emerald-700 uppercase tracking-widest border border-emerald-100">
                                        Fulfilled
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-black bg-red-50 text-red-700 uppercase tracking-widest border border-red-100">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-1">
                                @can('update', $req)
                                <button @click="editing = {{ json_encode($req) }}; openModal = true" class="text-sm font-bold text-primary hover:text-primary/80 transition-colors mr-2">Update Status</button>
                                @endcan
                                
                                @can('delete', $req)
                                <form action="{{ route('materials-requests.destroy', $req) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this purchase request?')" class="w-8 h-8 rounded-lg flex items-center justify-center text-muted hover:bg-danger/10 hover:text-danger transition-colors" title="Delete Request">
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
                                <h3 class="text-lg font-bold text-text mb-1">No requests found</h3>
                                <p class="text-sm text-muted">There are no materials requests registered matching your filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-border bg-background/30">
                {{ $requests->links() }}
            </div>
            @endif
        </div>

        {{-- Add / Update Status Modal --}}
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
                        <h3 class="text-lg font-black text-text" x-text="editing ? 'Update Request Status' : 'Submit Material Purchase Request'"></h3>
                        <button @click="openModal = false" class="text-muted hover:text-text transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form :action="editing ? '/materials-requests/' + editing.id : '/materials-requests'" method="POST">
                        @csrf
                        <template x-if="editing">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="p-6 space-y-5">
                            
                            {{-- Edit Mode Status Selection --}}
                            <template x-if="editing">
                                <div class="space-y-4">
                                    <div class="bg-background rounded-xl p-4 border border-border">
                                        <p class="text-xs text-muted font-bold uppercase tracking-wider">Item Description</p>
                                        <p class="text-base font-black text-text mt-1" x-text="editing.item_name"></p>
                                        <p class="text-xs text-muted mt-2">Quantity Requested: <span class="font-bold text-text" x-text="editing.quantity"></span></p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-bold text-text mb-1.5">Update Status <span class="text-danger">*</span></label>
                                        <select name="status" required class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary" :value="editing ? editing.status : 'pending'">
                                            <option value="pending">Pending Approval</option>
                                            <option value="approved">Approved</option>
                                            <option value="fulfilled">Fulfilled</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </template>

                            {{-- Create Mode Inputs --}}
                            <template x-if="!editing">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-text mb-1.5">Item Name <span class="text-danger">*</span></label>
                                        <input type="text" name="item_name" required placeholder="E.g. Drill Uniforms, Flags, Ribbons" class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-text mb-1.5">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" min="1" required placeholder="Enter quantity" class="w-full bg-background border border-border rounded-xl px-4 py-2.5 text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    </div>
                                </div>
                            </template>

                        </div>

                        <div class="px-6 py-4 bg-background border-t border-border flex justify-end gap-3">
                            <button type="button" @click="openModal = false" class="px-5 py-2.5 text-sm font-bold text-text hover:bg-surface border border-border rounded-xl transition-colors shadow-sm">Cancel</button>
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span x-text="editing ? 'Update Status' : 'Submit Request'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
