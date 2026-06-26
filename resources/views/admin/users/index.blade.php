<x-app-layout>
    <x-slot name="header">
        User Management
    </x-slot>

    <div class="px-6 py-8" x-data="{ openModal: false, selectedUser: null, selectedRole: 'Member' }">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-black text-text">User Management</h1>
            <p class="text-sm text-muted mt-1">Manage users, assign roles, and control access across the system.</p>
        </div>

        {{-- Filters --}}
        <div class="mb-6 bg-surface rounded-2xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('users.index') }}" class="flex flex-wrap items-center gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                       class="flex-1 min-w-[200px] px-4 py-2.5 rounded-xl bg-background border border-border text-sm text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <select name="role" class="px-4 py-2.5 rounded-xl bg-background border border-border text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-4 py-2.5 rounded-xl bg-background border border-border text-sm font-medium text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="bg-primary/10 text-primary font-bold py-2.5 px-5 rounded-xl hover:bg-primary/20 transition-colors text-sm">Search</button>
                @if(request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('users.index') }}" class="text-sm text-muted hover:text-text font-medium">Clear</a>
                @endif
            </form>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @php
                $totalUsers = $users->total();
                $activeCount = \App\Models\User::where('is_approved', true)->count();
                $inactiveCount = \App\Models\User::where('is_approved', false)->count();
            @endphp
            <div class="bg-surface rounded-xl border border-border p-4 text-center">
                <p class="text-2xl font-black text-primary">{{ $totalUsers }}</p>
                <p class="text-xs text-muted font-bold uppercase mt-1">Total Users</p>
            </div>
            <div class="bg-surface rounded-xl border border-border p-4 text-center">
                <p class="text-2xl font-black text-success">{{ $activeCount }}</p>
                <p class="text-xs text-muted font-bold uppercase mt-1">Active</p>
            </div>
            <div class="bg-surface rounded-xl border border-border p-4 text-center">
                <p class="text-2xl font-black text-danger">{{ $inactiveCount }}</p>
                <p class="text-xs text-muted font-bold uppercase mt-1">Inactive</p>
            </div>
            <div class="bg-surface rounded-xl border border-border p-4 text-center">
                <p class="text-2xl font-black text-secondary">{{ $roles->count() }}</p>
                <p class="text-xs text-muted font-bold uppercase mt-1">Roles</p>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-background/50 text-xs text-muted uppercase font-black tracking-wider border-b border-border">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Assignment</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Joined</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($users as $user)
                        <tr class="hover:bg-background/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/80 to-primary flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-text">{{ $user->name }}</p>
                                        <p class="text-xs text-muted">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary/10 text-primary uppercase tracking-wide">
                                    {{ $user->roles->pluck('name')->first() ?? 'No Role' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-muted">
                                @if($user->denomination) <span class="block">Dom: {{ $user->denomination->name }}</span> @endif
                                @if($user->battalion) <span class="block">Btn: {{ $user->battalion->name }}</span> @endif
                                @if($user->company) <span class="block">Coy: {{ $user->company->name }}</span> @endif
                                @if(!$user->denomination && !$user->battalion && !$user->company) <span class="text-muted">—</span> @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_approved)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-success/10 text-success">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-danger/10 text-danger">
                                        <span class="w-1.5 h-1.5 rounded-full bg-danger"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-muted text-xs">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Toggle Active --}}
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('users.toggle-active', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $user->is_approved ? 'bg-danger/10 text-danger hover:bg-danger/20' : 'bg-success/10 text-success hover:bg-success/20' }}">
                                            {{ $user->is_approved ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Edit Role --}}
                                    <button @click="selectedUser = {{ json_encode($user->only(['id', 'name', 'email'])) }}; selectedRole = '{{ $user->roles->pluck('name')->first() ?? 'Member' }}'; openModal = true"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
                                        Edit Role
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-background mb-4">
                                    <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <p class="text-muted font-medium">No users found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="p-6 border-t border-border">
                {{ $users->withQueryString()->links() }}
            </div>
            @endif
        </div>

        {{-- Edit Role Modal --}}
        <div x-show="openModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openModal = false"></div>

                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-surface rounded-2xl shadow-2xl max-w-lg w-full border border-border overflow-hidden z-10">

                    <form x-bind:action="'/admin/users/' + selectedUser?.id + '/update-role'" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="p-6 border-b border-border">
                            <h3 class="text-lg font-black text-text">Update Role</h3>
                            <p class="text-sm text-muted mt-1">Assign a role and hierarchy for <strong x-text="selectedUser?.name" class="text-text"></strong></p>
                        </div>

                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-text mb-2">Role</label>
                                <select name="role" x-model="selectedRole" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="selectedRole === 'Denomination Admin'" x-cloak>
                                <label class="block text-sm font-bold text-text mb-2">Denomination</label>
                                <select name="denomination_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <option value="">-- Select --</option>
                                    @foreach($denominations as $dom)
                                        <option value="{{ $dom->id }}">{{ $dom->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="selectedRole === 'Battalion Commander'" x-cloak>
                                <label class="block text-sm font-bold text-text mb-2">Battalion</label>
                                <select name="battalion_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <option value="">-- Select --</option>
                                    @foreach($battalions as $btn)
                                        <option value="{{ $btn->id }}">{{ $btn->name }} ({{ $btn->denomination?->name ?? '—' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="['Company Captain', 'Company Officer', 'Member'].includes(selectedRole)" x-cloak>
                                <label class="block text-sm font-bold text-text mb-2">Company</label>
                                <select name="company_id" class="w-full px-4 py-3 rounded-xl bg-background border border-border text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <option value="">-- Select --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->battalion?->name ?? '—' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="p-6 border-t border-border bg-background/50 flex items-center justify-end gap-3">
                            <button type="button" @click="openModal = false" class="px-5 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</button>
                            <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 text-sm">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
