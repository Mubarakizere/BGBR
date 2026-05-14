<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg mb-8 overflow-hidden relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white rounded-full mix-blend-overlay opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white rounded-full mix-blend-overlay opacity-10"></div>
                <div class="px-8 py-10 relative z-10 text-white">
                    <h3 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-indigo-100 max-w-2xl text-lg">Here's what's happening with your BGBR command center today. Stay up to date with the latest statistics and reports.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="p-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Members</p>
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Member::count() }}</h4>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Companies</p>
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Company::count() }}</h4>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="p-3 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Battalions</p>
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Battalion::count() }}</h4>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="p-3 rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Deposits</p>
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\AccountDeposit::count() }}</h4>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activity Panel -->
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @can('register members')
                        <a href="{{ route('members.index') }}" class="block p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-slate-800 transition text-center">
                            <span class="text-indigo-600 font-medium">Manage Members</span>
                        </a>
                        @endcan
                        @can('manage companies')
                        <a href="{{ route('companies.index') }}" class="block p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-slate-800 transition text-center">
                            <span class="text-indigo-600 font-medium">Manage Companies</span>
                        </a>
                        @endcan
                        @can('manage battalions')
                        <a href="{{ route('battalions.index') }}" class="block p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-slate-800 transition text-center">
                            <span class="text-indigo-600 font-medium">Manage Battalions</span>
                        </a>
                        @endcan
                        <a href="{{ route('profile.edit') }}" class="block p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-slate-800 transition text-center">
                            <span class="text-indigo-600 font-medium">Update Profile</span>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
