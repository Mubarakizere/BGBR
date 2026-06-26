<x-app-layout>
    <x-slot name="header">
        Pending User Approvals
    </x-slot>

    <div class="px-6 py-8" x-data="{ 
        openModal: false, 
        rejectModal: false, 
        selectedUser: null, 
        selectedRole: 'Member',
        searchQuery: '{{ request('search') }}'
    }">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-text">Pending Approvals</h1>
                <p class="text-sm text-muted mt-1">Review and approve newly registered users before they can access the system.</p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-background border border-border text-sm font-bold text-muted hover:text-text hover:border-primary/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                All Users
            </a>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-surface rounded-xl border border-border p-4 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-warning/5 to-transparent"></div>
                <div class="relative">
                    <p class="text-2xl font-black text-warning">{{ $pendingUsers->total() }}</p>
                    <p class="text-xs text-muted font-bold uppercase mt-1">Pending</p>
                </div>
            </div>
            <div class="bg-surface rounded-xl border border-border p-4 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-success/5 to-transparent"></div>
                <div class="relative">
                    <p class="text-2xl font-black text-success">{{ \App\Models\User::where('is_approved', true)->count() }}</p>
                    <p class="text-xs text-muted font-bold uppercase mt-1">Approved</p>
                </div>
            </div>
            <div class="bg-surface rounded-xl border border-border p-4 text-center relative overflow-hidden col-span-2 md:col-span-1">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent"></div>
                <div class="relative">
                    <p class="text-2xl font-black text-primary">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-muted font-bold uppercase mt-1">Total Users</p>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 bg-success/10 border border-success/20 text-success rounded-xl px-5 py-4 flex items-center gap-3 animate-fade-in" x-data="{ show: true }" x-show="show" x-transition>
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold">{{ session('success') }}</p>
            <button @click="show = false" class="ml-auto text-success/70 hover:text-success">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif

        {{-- Search/Filter --}}
        <div class="mb-6 bg-surface rounded-2xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('users.pending') }}" class="flex flex-wrap items-center gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pending users by name or email..."
                       class="flex-1 min-w-[250px] px-4 py-2.5 rounded-xl bg-background border border-border text-sm text-text focus:ring-2 focus:ring-primary/30 focus:border-primary placeholder:text-muted/50">
                <button type="submit" class="bg-primary/10 text-primary font-bold py-2.5 px-5 rounded-xl hover:bg-primary/20 transition-colors text-sm">
                    Search
                </button>
                @if(request('search'))
                <a href="{{ route('users.pending') }}" class="text-sm text-muted hover:text-text font-medium transition-colors">Clear</a>
                @endif
            </form>
        </div>

        {{-- Users Table --}}
        @if($pendingUsers->isEmpty())
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-success/10 mb-5">
                    <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-text">All Caught Up!</h3>
                <p class="text-sm text-muted mt-2 max-w-md mx-auto">There are no pending user approvals at the moment. New registrations will appear here for your review.</p>
                <a href="{{ route('users.index') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary/10 text-primary font-bold text-sm hover:bg-primary/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    View All Users
                </a>
            </div>
        @else
            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-background/50 text-xs text-muted uppercase font-black tracking-wider border-b border-border">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Registered</th>
                                <th class="px-6 py-4">Waiting</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($pendingUsers as $user)
                            <tr class="hover:bg-background/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-warning/80 to-warning flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-warning/20">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-text">{{ $user->name }}</p>
                                            <p class="text-xs text-muted">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-muted text-xs">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-warning/10 text-warning">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $user->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="selectedUser = {{ json_encode($user->only(['id', 'name', 'email'])) }}; selectedRole = 'Member'; openModal = true"
                                                class="px-4 py-2 rounded-xl text-xs font-bold bg-success/10 text-success hover:bg-success/20 transition-all inline-flex items-center gap-1.5 opacity-80 group-hover:opacity-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Approve
                                        </button>
                                        <button @click="selectedUser = {{ json_encode($user->only(['id', 'name', 'email'])) }}; rejectModal = true"
                                                class="px-4 py-2 rounded-xl text-xs font-bold bg-danger/10 text-danger hover:bg-danger/20 transition-all inline-flex items-center gap-1.5 opacity-80 group-hover:opacity-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pendingUsers->hasPages())
                <div class="p-6 border-t border-border">
                    {{ $pendingUsers->withQueryString()->links() }}
                </div>
                @endif
            </div>
        @endif

        {{-- Approve Modal --}}
        <div x-show="openModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>

                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-surface rounded-2xl shadow-2xl max-w-lg w-full border border-border overflow-hidden z-10">

                    <form x-bind:action="'/admin/users/' + selectedUser?.id + '/approve'" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Modal Header --}}
                        <div class="p-6 border-b border-border">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-success/80 to-success flex items-center justify-center text-white shadow-lg shadow-success/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-text">Approve User</h3>
                                    <p class="text-sm text-muted mt-0.5">Assign a role and unit for <strong x-text="selectedUser?.name" class="text-text"></strong></p>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Body --}}
                        <div class="p-6 space-y-5">
                            {{-- User Info Card --}}
                            <div class="bg-background rounded-xl border border-border p-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/80 to-primary flex items-center justify-center text-white font-bold text-sm">
                                    <span x-text="selectedUser?.name?.charAt(0)?.toUpperCase()"></span>
                                </div>
                                <div>
                                    <p class="font-bold text-text text-sm" x-text="selectedUser?.name"></p>
                                    <p class="text-xs text-muted" x-text="selectedUser?.email"></p>
                                </div>
                            </div>

                            {{-- Role Selection --}}
                            <div>
                                <label class="block text-sm font-bold text-text mb-2">Assign Role</label>
                                <select name="role" x-model="selectedRole" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dynamic Fields --}}
                            <div x-show="selectedRole === 'Denomination Admin'" x-cloak x-transition>
                                <label class="block text-sm font-bold text-text mb-2">Select Denomination</label>
                                <select name="denomination_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                                    <option value="">-- Select Denomination --</option>
                                    @foreach($denominations as $dom)
                                        <option value="{{ $dom->id }}">{{ $dom->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="selectedRole === 'Battalion Commander'" x-cloak x-transition>
                                <label class="block text-sm font-bold text-text mb-2">Select Battalion</label>
                                <select name="battalion_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                                    <option value="">-- Select Battalion --</option>
                                    @foreach($battalions as $btn)
                                        <option value="{{ $btn->id }}">{{ $btn->name }} ({{ $btn->denomination?->name ?? '—' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="['Company Captain', 'Company Officer', 'Member'].includes(selectedRole)" x-cloak x-transition>
                                <label class="block text-sm font-bold text-text mb-2">Select Company</label>
                                <select name="company_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                                    <option value="">-- Select Company --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->battalion?->name ?? '—' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="p-6 border-t border-border bg-background/50 flex items-center justify-end gap-3">
                            <button type="button" @click="openModal = false" class="px-5 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</button>
                            <button type="submit" class="bg-success hover:bg-success/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-success/20 text-sm inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Approve User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Reject Confirmation Modal --}}
        <div x-show="rejectModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="rejectModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="rejectModal = false"></div>

                <div x-show="rejectModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-surface rounded-2xl shadow-2xl max-w-md w-full border border-border overflow-hidden z-10">

                    <form x-bind:action="'/admin/users/' + selectedUser?.id + '/reject'" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="p-6 text-center">
                            <div class="mx-auto w-14 h-14 rounded-full bg-danger/10 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-text">Reject User?</h3>
                            <p class="text-sm text-muted mt-2">
                                Are you sure you want to reject <strong x-text="selectedUser?.name" class="text-text"></strong>?
                                This will permanently delete their account.
                            </p>
                        </div>

                        <div class="p-6 border-t border-border bg-background/50 flex items-center justify-center gap-3">
                            <button type="button" @click="rejectModal = false" class="px-5 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</button>
                            <button type="submit" class="bg-danger hover:bg-danger/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-danger/20 text-sm inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Reject & Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
