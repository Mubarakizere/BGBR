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
               engageOpen: {{ request()->routeIs('announcements.*') || request()->routeIs('activities.*') ? 'true' : 'false' }},
               adminOpen: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('audit-logs.*') || request()->routeIs('users.pending') ? 'true' : 'false' }},
               orgOpen: {{ request()->routeIs('battalions.*') || request()->routeIs('companies.*') || request()->routeIs('members.*') || request()->routeIs('materials-requests.*') ? 'true' : 'false' }},
               opsOpen: {{ request()->routeIs('denominations.*') || request()->routeIs('zones.*') || request()->routeIs('account-deposits.*') || request()->routeIs('reports.*') ? 'true' : 'false' }},
               websiteOpen: {{ request()->routeIs('admin.website.*') ? 'true' : 'false' }}
           }">

        {{-- Brand --}}
        <div class="h-[60px] flex items-center justify-between px-5 border-b border-white/[0.05]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-md p-0.5">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Boys and Girls Brigade Logo" class="w-full h-full object-contain rounded-[5px]" />
                </div>
                <div class="flex flex-col">
                    <span class="text-[15px] font-bold tracking-tight text-white">Boys and Girls Brigade</span>
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
Dashboard
            </a>

            {{-- ── ENGAGEMENT GROUP (collapsible) ── --}}
            <div class="mt-5 mb-1">
                <button @click="engageOpen = !engageOpen"
                        class="w-full flex items-center justify-between px-3 group">
                    <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-white/25 group-hover:text-white/40 transition-colors">Engagement</span>
                    <svg :class="engageOpen ? 'rotate-0' : '-rotate-90'"
                         class="w-3 h-3 text-white/20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div x-show="engageOpen" x-collapse>
                {{-- ── Announcements ── --}}
                @php $isAnn = request()->routeIs('announcements.*'); @endphp
                <a href="{{ route('announcements.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                          {{ $isAnn ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Announcements
                </a>

                {{-- ── Activities ── --}}
                @if(auth()->user()->can('view activities') || auth()->user()->can('manage activities') || auth()->user()->can('submit activity participation'))
                    @php $isAct = request()->routeIs('activities.*'); @endphp
                    <a href="{{ route('activities.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isAct ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Activities
                    </a>
                @endif
            </div>

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
Battalions
                        </a>
                    @endcan

                    @can('manage companies')
                        @php $isComp = request()->routeIs('companies.*'); @endphp
                        <a href="{{ route('companies.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isComp ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Companies
                        </a>

                        @php $isMat = request()->routeIs('materials-requests.*'); @endphp
                        <a href="{{ route('materials-requests.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isMat ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Material Requests
                        </a>
                    @endcan

                    @can('register members')
                        @php $isMem = request()->routeIs('members.*'); @endphp
                        <a href="{{ route('members.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isMem ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
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
Denominations
                        </a>

                        @php $isZones = request()->routeIs('zones.*'); @endphp
                        <a href="{{ route('zones.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isZones ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Zones
                        </a>

                        @php $isDeposits = request()->routeIs('account-deposits.*'); @endphp
                        <a href="{{ route('account-deposits.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isDeposits ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Account Deposits
                        </a>
                        
                        @can('approve fees')
                            @php $isFees = request()->routeIs('admin.fees.*'); @endphp
                            <a href="{{ route('admin.fees.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                      {{ $isFees ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
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
Pending Approvals
                        </a>
                    @endcan

                    @can('manage users')
                        @php $isUsers = request()->routeIs('users.index'); @endphp
                        <a href="{{ route('users.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isUsers ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
User Management
                        </a>
                    @endcan

                    @can('manage system settings')
                        @php $isRoles = request()->routeIs('roles.*'); @endphp
                        <a href="{{ route('roles.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isRoles ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Roles & Permissions
                        </a>
                    @endcan

                    @can('view audit logs')
                        @php $isAudit = request()->routeIs('audit-logs.*'); @endphp
                        <a href="{{ route('audit-logs.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                                  {{ $isAudit ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
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
Overview
                    </a>

                    @php $isWPages = request()->routeIs('admin.website.pages.*'); @endphp
                    <a href="{{ route('admin.website.pages.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWPages ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Pages
                    </a>

                    @php $isWLeaders = request()->routeIs('admin.website.leaders.*'); @endphp
                    <a href="{{ route('admin.website.leaders.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWLeaders ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Leadership
                    </a>

                    @php $isWEvents = request()->routeIs('admin.website.events.*'); @endphp
                    <a href="{{ route('admin.website.events.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWEvents ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Events
                    </a>

                    @php $isWNews = request()->routeIs('admin.website.news.*'); @endphp
                    <a href="{{ route('admin.website.news.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWNews ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
News
                    </a>

                    @php $isWGallery = request()->routeIs('admin.website.gallery.*'); @endphp
                    <a href="{{ route('admin.website.gallery.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWGallery ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Gallery
                    </a>

                    @php $isWFaqs = request()->routeIs('admin.website.faqs.*'); @endphp
                    <a href="{{ route('admin.website.faqs.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWFaqs ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
FAQs
                    </a>

                    @php $isWContacts = request()->routeIs('admin.website.contacts.*'); @endphp
                    <a href="{{ route('admin.website.contacts.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150 mt-0.5
                              {{ $isWContacts ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
Contact Messages
                        @php $unreadContacts = \App\Models\SiteContact::unread()->count(); @endphp
                        @if($unreadContacts > 0)
                            <span class="ml-auto px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-danger text-white min-w-[18px] text-center">{{ $unreadContacts }}</span>
                        @endif
                    </a>
                </div>
            @endcan

            {{-- ── Documentation ── --}}
            <div class="mt-5 mb-1 border-t border-white/[0.05] pt-4">
                @php $isDocs = request()->routeIs('docs.system'); @endphp
                <a href="{{ route('docs.system') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13px] font-medium transition-all duration-150
                          {{ $isDocs ? 'bg-white/[0.1] text-white' : 'text-white/55 hover:text-white/90 hover:bg-white/[0.04]' }}">
System Documentation
                </a>
            </div>

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
