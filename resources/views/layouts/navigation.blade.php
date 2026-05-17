{{-- Sidebar wrapper --}}
<div class="relative z-40">

    {{-- Mobile backdrop --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm md:hidden"
         style="display: none;"></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           class="fixed md:sticky top-0 left-0 w-72 h-screen flex flex-col bg-gradient-to-b from-[#0F1847] via-[#141E55] to-[#0C1339] text-white transition-transform duration-300 ease-in-out shadow-2xl md:shadow-lg z-50">

        {{-- ═══════════ LOGO / BRAND ═══════════ --}}
        <div class="h-16 flex items-center justify-between px-5 border-b border-white/[0.06]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-[#3B4FD4] rounded-xl flex items-center justify-center shadow-lg shadow-primary/30 group-hover:shadow-primary/50 transition-shadow duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="text-lg font-extrabold tracking-tight bg-gradient-to-r from-white to-white/70 bg-clip-text text-transparent">
                    BGBR Portal
                </span>
            </a>
            {{-- Mobile close button --}}
            <button @click="sidebarOpen = false" class="md:hidden text-white/50 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- ═══════════ NAVIGATION LINKS ═══════════ --}}
        <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-6 scrollbar-hide">

            {{-- Main --}}
            <div>
                <div class="space-y-0.5">
                    @php $isDash = request()->routeIs('dashboard'); @endphp
                    <a href="{{ route('dashboard') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isDash ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        {{-- Active indicator pill --}}
                        @if($isDash)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isDash ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </span>
                        Dashboard
                    </a>
                </div>
            </div>

            {{-- Super Admin Section --}}
            @can('manage dominations')
            <div>
                <h4 class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Super Admin</h4>
                <div class="space-y-0.5">
                    {{-- Pending Approvals --}}
                    @php $isPending = request()->routeIs('users.pending'); @endphp
                    <a href="{{ route('users.pending') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isPending ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isPending)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isPending ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        Pending Approvals
                    </a>

                    {{-- Dominations --}}
                    @php $isDom = request()->routeIs('dominations.*'); @endphp
                    <a href="{{ route('dominations.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isDom ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isDom)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isDom ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Dominations
                    </a>

                    {{-- Account Deposits --}}
                    @php $isDeposits = request()->routeIs('account-deposits.*'); @endphp
                    <a href="{{ route('account-deposits.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isDeposits ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isDeposits)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isDeposits ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Account Deposits
                    </a>
                </div>
            </div>
            @endcan

            {{-- Battalion Section --}}
            @can('manage battalions')
            <div>
                <h4 class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Battalion</h4>
                <div class="space-y-0.5">
                    @php $isBatt = request()->routeIs('battalions.*'); @endphp
                    <a href="{{ route('battalions.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isBatt ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isBatt)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isBatt ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </span>
                        Battalions
                    </a>
                </div>
            </div>
            @endcan

            {{-- Company Section --}}
            @can('manage companies')
            <div>
                <h4 class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Company</h4>
                <div class="space-y-0.5">
                    @php $isComp = request()->routeIs('companies.*'); @endphp
                    <a href="{{ route('companies.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isComp ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isComp)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isComp ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </span>
                        Companies
                    </a>

                    @php $isMat = request()->routeIs('materials-requests.*'); @endphp
                    <a href="{{ route('materials-requests.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isMat ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isMat)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isMat ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </span>
                        Material Requests
                    </a>
                </div>
            </div>
            @endcan

            {{-- Activities Section --}}
            @if(auth()->user()->can('manage activities') || auth()->user()->can('submit activity participation'))
            <div>
                <h4 class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Activities</h4>
                <div class="space-y-0.5">
                    @php $isAct = request()->routeIs('activities.*'); @endphp
                    <a href="{{ route('activities.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isAct ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isAct)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isAct ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </span>
                        Activities
                    </a>
                </div>
            </div>
            @endif

            {{-- Members Section --}}
            @can('register members')
            <div>
                <h4 class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Members</h4>
                <div class="space-y-0.5">
                    @php $isMem = request()->routeIs('members.*'); @endphp
                    <a href="{{ route('members.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isMem ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isMem)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isMem ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </span>
                        Members List
                    </a>
                </div>
            </div>
            @endcan

            {{-- Reports Section --}}
            @if(auth()->user()->hasRole(['Company Captain', 'Company Officer', 'Battalion Commander', 'Domination Admin', 'Super Admin']))
            <div>
                <h4 class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Reporting</h4>
                <div class="space-y-0.5">
                    @php $isReports = request()->routeIs('reports.*'); @endphp
                    <a href="{{ route('reports.index') }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-semibold transition-all duration-200
                              {{ $isReports ? 'bg-white/[0.12] text-white shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/[0.06]' }}">
                        @if($isReports)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-secondary rounded-r-full"></span>
                        @endif
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200
                                     {{ $isReports ? 'bg-primary/60 text-white' : 'bg-white/[0.06] text-white/50 group-hover:bg-white/[0.1] group-hover:text-white/80' }}">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        Reports
                    </a>
                </div>
            </div>
            @endif

        </nav>

        {{-- ═══════════ USER PROFILE FOOTER ═══════════ --}}
        <div class="p-3 border-t border-white/[0.06]">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/[0.06] transition-all duration-200 group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-secondary/80 to-secondary flex items-center justify-center text-[#0F1847] font-bold text-sm shadow-lg shadow-secondary/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white/90 truncate group-hover:text-white transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-white/40 truncate">{{ Auth::user()->roles->pluck('name')->first() ?? 'Member' }}</p>
                </div>
                <svg class="w-4 h-4 text-white/20 group-hover:text-white/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

    </aside>
</div>
