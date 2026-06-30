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
           class="fixed md:sticky top-0 left-0 w-[270px] h-screen flex flex-col bg-[#0E1538] text-white transition-transform duration-300 ease-in-out shadow-2xl md:shadow-lg z-50"
           x-data="{
               adminOpen: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('audit-logs.*') || request()->routeIs('users.pending') ? 'true' : 'false' }},
               orgOpen: {{ request()->routeIs('battalions.*') || request()->routeIs('companies.*') || request()->routeIs('members.*') || request()->routeIs('materials-requests.*') ? 'true' : 'false' }},
               opsOpen: {{ request()->routeIs('denominations.*') || request()->routeIs('zones.*') || request()->routeIs('account-deposits.*') || request()->routeIs('reports.*') ? 'true' : 'false' }},
               websiteOpen: {{ request()->routeIs('admin.website.*') ? 'true' : 'false' }}
           }">

        {{-- Brand --}}
        <div class="h-[60px] flex items-center justify-between px-5 border-b border-white/[0.05]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-md p-0.5">
                    <img src="{{ asset('images/logo.jpg') }}" alt="BGBR Logo" class="w-full h-full object-contain rounded-[5px]" />
                </div>
                <div class="leading-none">
                    <span class="text-[15px] font-bold tracking-tight text-white">BGBR</span>
                    <span class="block text-[10px] font-medium text-white/35 tracking-wide">Management Portal</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-white/40 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 scrollbar-hide">

            {{-- ── Dashboard ── --}}
            @php $isDash = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                      {{ $isDash ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isDash ? 'bg-blue-500/20 text-blue-400' : 'text-white/40' }}">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"></path></svg>
                </span>
                Dashboard
            </a>

            {{-- ── Announcements ── --}}
            @php $isAnn = request()->routeIs('announcements.*'); @endphp
            <a href="{{ route('announcements.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                      {{ $isAnn ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isAnn ? 'bg-amber-500/20 text-amber-400' : 'text-white/40' }}">
                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </span>
                Announcements
            </a>

            {{-- ── Activities ── --}}
            @if(auth()->user()->can('manage activities') || auth()->user()->can('submit activity participation'))
                @php $isAct = request()->routeIs('activities.*'); @endphp
                <a href="{{ route('activities.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                          {{ $isAct ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                    <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isAct ? 'bg-emerald-500/20 text-emerald-400' : 'text-white/40' }}">
                        <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </span>
                    Activities
                </a>
            @endif

            {{-- ── ORGANIZATION GROUP (collapsible) ── --}}
            @if(auth()->user()->can('manage battalions') || auth()->user()->can('manage companies') || auth()->user()->can('register members'))
                <div class="mt-5 mb-1">
                    <button @click="orgOpen = !orgOpen"
                            class="w-full flex items-center justify-between px-3 group">
                        <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-white/25 group-hover:text-white/40 transition-colors">Organization</span>
                        <svg :class="orgOpen ? 'rotate-0' : '-rotate-90'"
                             class="w-3 h-3 text-white/20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div x-show="orgOpen" x-collapse>
                    @can('manage battalions')
                        @php $isBatt = request()->routeIs('battalions.*'); @endphp
                        <a href="{{ route('battalions.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                                  {{ $isBatt ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isBatt ? 'bg-violet-500/20 text-violet-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            Battalions
                        </a>
                    @endcan

                    @can('manage companies')
                        @php $isComp = request()->routeIs('companies.*'); @endphp
                        <a href="{{ route('companies.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isComp ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isComp ? 'bg-violet-500/20 text-violet-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            </span>
                            Companies
                        </a>

                        @php $isMat = request()->routeIs('materials-requests.*'); @endphp
                        <a href="{{ route('materials-requests.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isMat ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isMat ? 'bg-violet-500/20 text-violet-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </span>
                            Material Requests
                        </a>
                    @endcan

                    @can('register members')
                        @php $isMem = request()->routeIs('members.*'); @endphp
                        <a href="{{ route('members.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isMem ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isMem ? 'bg-violet-500/20 text-violet-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            Members
                        </a>
                    @endcan
                </div>
            @endif

            {{-- ── OPERATIONS GROUP (collapsible) ── --}}
            @if(auth()->user()->can('manage denominations') ||
                auth()->user()->hasRole(['Company Captain', 'Company Officer', 'Battalion Commander', 'Denomination Admin', 'Super Admin']))
                <div class="mt-5 mb-1">
                    <button @click="opsOpen = !opsOpen"
                            class="w-full flex items-center justify-between px-3 group">
                        <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-white/25 group-hover:text-white/40 transition-colors">Operations</span>
                        <svg :class="opsOpen ? 'rotate-0' : '-rotate-90'"
                             class="w-3 h-3 text-white/20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div x-show="opsOpen" x-collapse>
                    @can('manage denominations')
                        @php $isDom = request()->routeIs('denominations.*'); @endphp
                        <a href="{{ route('denominations.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                                  {{ $isDom ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isDom ? 'bg-cyan-500/20 text-cyan-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Denominations
                        </a>

                        @php $isZones = request()->routeIs('zones.*'); @endphp
                        <a href="{{ route('zones.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isZones ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isZones ? 'bg-teal-500/20 text-teal-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            Zones
                        </a>

                        @php $isDeposits = request()->routeIs('account-deposits.*'); @endphp
                        <a href="{{ route('account-deposits.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isDeposits ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isDeposits ? 'bg-cyan-500/20 text-cyan-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Account Deposits
                        </a>
                        
                        @can('approve fees')
                            @php $isFees = request()->routeIs('admin.fees.*'); @endphp
                            <a href="{{ route('admin.fees.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                      {{ $isFees ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                                <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isFees ? 'bg-cyan-500/20 text-cyan-400' : 'text-white/40' }}">
                                    <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </span>
                                Fee Submissions
                            </a>
                        @endcan
                    @endcan

                    {{-- Reports --}}
                    @if(auth()->user()->hasRole(['Company Captain', 'Company Officer', 'Battalion Commander', 'Denomination Admin', 'Super Admin']))
                        @php $isReports = request()->routeIs('reports.*'); @endphp
                        <a href="{{ route('reports.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isReports ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isReports ? 'bg-cyan-500/20 text-cyan-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </span>
                            Reports
                        </a>
                    @endif
                </div>
            @endif

            {{-- ── SYSTEM GROUP (collapsible) ── --}}
            @if(auth()->user()->can('manage users') || auth()->user()->can('manage denominations'))
                <div class="mt-5 mb-1.5">
                    <button @click="adminOpen = !adminOpen"
                            class="w-full flex items-center justify-between px-3 group">
                        <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-white/25 group-hover:text-white/40 transition-colors">System</span>
                        <svg :class="adminOpen ? 'rotate-0' : '-rotate-90'"
                             class="w-3 h-3 text-white/20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div x-show="adminOpen" x-collapse>
                    @can('manage denominations')
                        @php $isPending = request()->routeIs('users.pending'); @endphp
                        <a href="{{ route('users.pending') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                                  {{ $isPending ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isPending ? 'bg-orange-500/20 text-orange-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Pending Approvals
                        </a>
                    @endcan

                    @can('manage users')
                        @php $isUsers = request()->routeIs('users.index'); @endphp
                        <a href="{{ route('users.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isUsers ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isUsers ? 'bg-orange-500/20 text-orange-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </span>
                            User Management
                        </a>
                    @endcan

                    @can('manage system settings')
                        @php $isRoles = request()->routeIs('roles.*'); @endphp
                        <a href="{{ route('roles.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isRoles ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isRoles ? 'bg-orange-500/20 text-orange-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            Roles & Permissions
                        </a>
                    @endcan

                    @can('view audit logs')
                        @php $isAudit = request()->routeIs('audit-logs.*'); @endphp
                        <a href="{{ route('audit-logs.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isAudit ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                            <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isAudit ? 'bg-orange-500/20 text-orange-400' : 'text-white/40' }}">
                                <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </span>
                            Audit Logs
                        </a>
                    @endcan
                </div>
            @endif

            {{-- ── WEBSITE CMS GROUP (collapsible) ── --}}
            @can('manage website')
                <div class="mt-5 mb-1.5">
                    <button @click="websiteOpen = !websiteOpen"
                            class="w-full flex items-center justify-between px-3 group">
                        <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-white/25 group-hover:text-white/40 transition-colors">Website CMS</span>
                        <svg :class="websiteOpen ? 'rotate-0' : '-rotate-90'"
                             class="w-3 h-3 text-white/20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div x-show="websiteOpen" x-collapse>
                    @php $isWDash = request()->routeIs('admin.website.dashboard'); @endphp
                    <a href="{{ route('admin.website.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                              {{ $isWDash ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWDash ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        </span>
                        Overview
                    </a>

                    @php $isWPages = request()->routeIs('admin.website.pages.*'); @endphp
                    <a href="{{ route('admin.website.pages.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWPages ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWPages ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        Pages
                    </a>

                    @php $isWLeaders = request()->routeIs('admin.website.leaders.*'); @endphp
                    <a href="{{ route('admin.website.leaders.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWLeaders ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWLeaders ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        Leadership
                    </a>

                    @php $isWEvents = request()->routeIs('admin.website.events.*'); @endphp
                    <a href="{{ route('admin.website.events.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWEvents ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWEvents ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        Events
                    </a>

                    @php $isWNews = request()->routeIs('admin.website.news.*'); @endphp
                    <a href="{{ route('admin.website.news.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWNews ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWNews ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </span>
                        News
                    </a>

                    @php $isWGallery = request()->routeIs('admin.website.gallery.*'); @endphp
                    <a href="{{ route('admin.website.gallery.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWGallery ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWGallery ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        Gallery
                    </a>

                    @php $isWFaqs = request()->routeIs('admin.website.faqs.*'); @endphp
                    <a href="{{ route('admin.website.faqs.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWFaqs ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWFaqs ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        FAQs
                    </a>

                    @php $isWContacts = request()->routeIs('admin.website.contacts.*'); @endphp
                    <a href="{{ route('admin.website.contacts.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWContacts ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
                        <span class="w-7 h-7 rounded-md flex items-center justify-center {{ $isWContacts ? 'bg-pink-500/20 text-pink-400' : 'text-white/40' }}">
                            <svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        Contact Messages
                        @php $unreadContacts = \App\Models\SiteContact::unread()->count(); @endphp
                        @if($unreadContacts > 0)
                            <span class="ml-auto px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-danger text-white min-w-[18px] text-center">{{ $unreadContacts }}</span>
                        @endif
                    </a>
                </div>
            @endcan

        </nav>

        {{-- User Profile Footer --}}
        <div class="p-3 border-t border-white/[0.05]">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/[0.04] transition-all duration-150 group">
                @if(Auth::user()->photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->photo_path) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover ring-1 ring-white/10 shrink-0">
                @else
                    <div class="w-8 h-8 rounded-full bg-white/[0.08] flex items-center justify-center text-white/60 font-semibold text-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-medium text-white/80 truncate group-hover:text-white transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-white/30 truncate">{{ Auth::user()->roles->pluck('name')->first() ?? 'Member' }}</p>
                </div>
                <svg class="w-3.5 h-3.5 text-white/15 group-hover:text-white/40 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

    </aside>
</div>
