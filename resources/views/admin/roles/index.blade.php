<x-app-layout>
    <x-slot name="header">
        Role & Permission Management
    </x-slot>

    <div class="px-6 py-8" x-data="{ openEditModal: false, selectedRole: null, selectedPermissions: [] }">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-success/10 border border-success/20 text-success text-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-danger/10 border border-danger/20 text-danger text-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Header Section --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-text">Role & Permission Management</h1>
                <p class="text-sm text-muted mt-1">Define system access control levels, create roles, and allocate dynamic permissions.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            {{-- Roles List --}}
            <div class="xl:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($roles as $role)
                        <div class="bg-surface rounded-2xl border border-border shadow-sm overflow-hidden flex flex-col justify-between group hover:border-primary/30 transition-all duration-300">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-text group-hover:text-primary transition-colors">{{ $role->name }}</h3>
                                        <p class="text-xs text-muted mt-0.5">{{ $role->permissions->count() }} active permissions</p>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </div>
                                </div>

                                {{-- Permissions Badges --}}
                                <div class="flex flex-wrap gap-1.5 mt-4 max-h-[150px] overflow-y-auto pr-1">
                                    @forelse($role->permissions as $perm)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-extrabold bg-background border border-border text-muted uppercase tracking-wider">
                                            {{ $perm->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-muted italic">No permissions assigned.</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="p-6 bg-background/30 border-t border-border flex items-center justify-end gap-2">
                                @if($role->name !== 'Super Admin')
                                    <button @click="selectedRole = {{ json_encode($role) }}; selectedPermissions = {{ json_encode($role->permissions->pluck('name')) }}; openEditModal = true"
                                            class="w-full bg-primary/10 text-primary hover:bg-primary/20 transition-colors font-bold text-xs py-2.5 px-4 rounded-xl flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Permissions
                                    </button>
                                @else
                                    <span class="w-full text-center text-xs font-bold text-success/70 py-2 bg-success/5 rounded-xl border border-success/10 uppercase tracking-wider">
                                        Inherits All Permissions Systemwide
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($roles->hasPages())
                    <div class="mt-6">
                        {{ $roles->links() }}
                    </div>
                @endif
            </div>

            {{-- Create Role Form Sidebar --}}
            <div class="space-y-6">
                <div class="bg-surface rounded-2xl border border-border shadow-sm p-6 sticky top-6">
                    <div class="mb-6">
                        <h2 class="text-lg font-black text-text">Create New Role</h2>
                        <p class="text-xs text-muted mt-1">Introduce a new customized role into the security hierarchy.</p>
                    </div>

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Role Name</label>
                                <input type="text" id="name" name="name" required placeholder="e.g. Inspector General"
                                       class="w-full px-4 py-3 rounded-xl bg-background border border-border text-sm text-text focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                @error('name')
                                    <span class="text-xs text-danger font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full bg-primary hover:bg-primary/95 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Dynamic Alpine Edit Permissions Modal --}}
        <div x-show="openEditModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="openEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="openEditModal = false"></div>

                <div x-show="openEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-surface rounded-2xl shadow-2xl max-w-3xl w-full border border-border overflow-hidden z-10 flex flex-col max-h-[85vh]">

                    <form x-bind:action="'/admin/roles/' + selectedRole?.id + '/permissions'" method="POST" class="flex flex-col h-full overflow-hidden">
                        @csrf
                        @method('PUT')

                        <div class="p-6 border-b border-border bg-background/20">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-black text-text">Edit Role Permissions</h3>
                                    <p class="text-xs text-muted mt-1">Configure capabilities and system scope boundaries for the role: <span class="font-bold text-primary" x-text="selectedRole?.name"></span></p>
                                </div>
                                <button type="button" @click="openEditModal = false" class="text-muted hover:text-text">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-background/5">
                            {{-- Checkbox Actions --}}
                            <div class="flex items-center gap-4 bg-background/50 border border-border p-3.5 rounded-xl text-xs">
                                <button type="button" @click="selectedPermissions = {{ json_encode($permissions->pluck('name')) }}"
                                        class="text-primary font-bold hover:underline">Select All</button>
                                <span class="text-border">|</span>
                                <button type="button" @click="selectedPermissions = []"
                                        class="text-muted font-bold hover:underline">Deselect All</button>
                            </div>

                            {{-- Dynamic List --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($permissions as $perm)
                                    <label class="flex items-start gap-3 p-3.5 rounded-xl border border-border bg-surface hover:bg-background/25 cursor-pointer select-none transition-all">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                               x-model="selectedPermissions"
                                               class="mt-0.5 text-primary focus:ring-primary/20 border-border rounded">
                                        <div>
                                            <span class="block text-xs font-bold text-text uppercase tracking-wider">{{ $perm->name }}</span>
                                            <span class="block text-[10px] text-muted mt-0.5">Authorizes actions belonging to this capability.</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-6 border-t border-border bg-background/30 flex items-center justify-end gap-3">
                            <button type="button" @click="openEditModal = false"
                                    class="px-5 py-2.5 rounded-xl border border-border text-muted font-bold hover:bg-background transition-colors text-sm">Cancel</button>
                            <button type="submit"
                                    class="bg-primary hover:bg-primary/95 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20 text-sm">Save Permissions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
