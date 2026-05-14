<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-text leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 px-6">
        <div class="max-w-7xl mx-auto">
            
            <!-- Welcome Banner -->
            <div class="bg-primary rounded-3xl shadow-lg mb-8 overflow-hidden relative">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-surface rounded-full mix-blend-overlay opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-surface rounded-full mix-blend-overlay opacity-10"></div>
                <div class="px-10 py-12 relative z-10 text-surface">
                    <h3 class="text-4xl font-black mb-3">Welcome, Super Admin! 👋</h3>
                    <p class="text-surface/80 max-w-2xl text-lg font-medium">You have full access to the BGBR Rwanda management system. Monitor system health, approve new members, and oversee the entire hierarchy.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-5 transition hover:shadow-md hover:border-primary/30 group">
                    <div class="p-4 rounded-xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-surface transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Total Dominations</p>
                        <h4 class="text-3xl font-black text-text">{{ \App\Models\Domination::count() }}</h4>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-5 transition hover:shadow-md hover:border-secondary/30 group">
                    <div class="p-4 rounded-xl bg-secondary/10 text-secondary group-hover:bg-secondary group-hover:text-surface transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Total Battalions</p>
                        <h4 class="text-3xl font-black text-text">{{ \App\Models\Battalion::count() }}</h4>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex items-center gap-5 transition hover:shadow-md hover:border-success/30 group">
                    <div class="p-4 rounded-xl bg-success/10 text-success group-hover:bg-success group-hover:text-surface transition-colors relative">
                        <!-- Notification dot for pending approvals -->
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-success border-2 border-surface"></span>
                        </span>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-muted uppercase tracking-widest mb-1">Pending Approvals</p>
                        <h4 class="text-3xl font-black text-text">{{ \App\Models\User::where('is_approved', false)->count() }}</h4>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-text">Administrative Actions</h3>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('users.pending') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-primary hover:bg-primary/5 transition-all text-center group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-text group-hover:text-primary">Review Approvals</span>
                    </a>
                    
                    <a href="{{ route('dominations.index') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-primary hover:bg-primary/5 transition-all text-center group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-text group-hover:text-primary">Dominations</span>
                    </a>

                    <a href="{{ route('account-deposits.index') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-primary hover:bg-primary/5 transition-all text-center group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-text group-hover:text-primary">National Deposits</span>
                    </a>

                    <a href="{{ route('members.index') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-primary hover:bg-primary/5 transition-all text-center group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-text group-hover:text-primary">All Members</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
