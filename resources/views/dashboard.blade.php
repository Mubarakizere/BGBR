<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-text leading-tight">
            {{ __('Command Center') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Welcome Banner -->
            <div class="bg-primary rounded-3xl shadow-xl mb-8 overflow-hidden relative">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-surface rounded-full mix-blend-overlay opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-surface rounded-full mix-blend-overlay opacity-10"></div>
                
                <div class="px-8 py-10 relative z-10 text-surface">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-surface/50 text-sm font-medium uppercase tracking-wider mb-1">{{ now()->format('l, d M Y') }}</p>
                            <h3 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ Auth::user()->name }}</h3>
                            <p class="text-surface/60 text-base font-medium mt-1">{{ Auth::user()->roles->pluck('name')->first() ?? 'Member' }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-surface/10 hover:bg-surface/20 border border-surface/20 rounded-xl text-sm font-semibold text-surface transition-colors duration-200">
                                <svg class="w-4 h-4 inline-block mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Command Section (For Officers/Commanders) -->
            @if(isset($myCommand))
            <div class="mb-8">
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 md:p-8 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-primary/5 to-transparent z-0"></div>
                    <div class="relative z-10">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-widest text-primary mb-1">My Command</h3>
                                <h2 class="text-2xl font-extrabold text-text mb-2">{{ $myCommand->name }} ({{ $myCommand->type }})</h2>
                                <div class="flex flex-wrap items-center gap-3 mt-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-semibold {{ $myCommand->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $myCommand->is_active ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path></svg>
                                        {{ $myCommand->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-semibold bg-background border border-border text-text">
                                        {{ $myCommand->type === 'Battalion' ? $myCommand->companies->count() . ' Companies' : $myCommand->members->count() . ' Members' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ $myCommand->type === 'Battalion' ? route('battalions.show', $myCommand) : route('companies.show', $myCommand) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-bold rounded-xl shadow-md shadow-primary/20 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                    View Full Details
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Dynamic Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Members Count Widget -->
                @can('view members')
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-primary/50 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="p-3 rounded-xl bg-primary/10 text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 bg-background text-muted rounded-full">Members</span>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-3xl font-black text-text mb-1">{{ number_format($totalMembers) }}</h4>
                        <p class="text-sm font-medium text-muted">Total active personnel</p>
                    </div>
                </div>
                @endcan

                <!-- Fees Collected Widget -->
                @can('manage system settings')
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-success/50 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-success/5 rounded-full blur-2xl group-hover:bg-success/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="p-3 rounded-xl bg-success/10 text-success">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 bg-background text-muted rounded-full">Finances</span>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-3xl font-black text-text mb-1">{{ number_format($totalFeesCollected) }} <span class="text-lg text-muted font-medium">RWF</span></h4>
                        <p class="text-sm font-medium text-muted">Total national deposits</p>
                    </div>
                </div>
                @endcan

                <!-- Pending Reports Widget -->
                @can('view all reports')
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-secondary/50 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-secondary/5 rounded-full blur-2xl group-hover:bg-secondary/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="p-3 rounded-xl bg-secondary/10 text-secondary relative">
                            @if($pendingReports > 0)
                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-secondary border-2 border-surface"></span>
                            </span>
                            @endif
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 bg-background text-muted rounded-full">Reports</span>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-3xl font-black text-text mb-1">{{ number_format($pendingReports) }}</h4>
                        <p class="text-sm font-medium text-muted">Awaiting review</p>
                    </div>
                </div>
                @endcan

                <!-- User Approvals Widget -->
                @can('manage users')
                <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-danger/50 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-danger/5 rounded-full blur-2xl group-hover:bg-danger/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="p-3 rounded-xl bg-danger/10 text-danger relative">
                            @if($pendingUsers > 0)
                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-danger border-2 border-surface"></span>
                            </span>
                            @endif
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 bg-background text-muted rounded-full">Users</span>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-3xl font-black text-text mb-1">{{ number_format($pendingUsers) }}</h4>
                        <p class="text-sm font-medium text-muted">Pending approvals</p>
                    </div>
                </div>
                @endcan
            </div>

            <!-- Dynamic Content Feeds -->
            @if((isset($latestAnnouncements) && $latestAnnouncements->isNotEmpty()) || (isset($upcomingActivities) && $upcomingActivities->isNotEmpty()) || (isset($recentMembers) && $recentMembers->isNotEmpty()) || (isset($pendingUsersList) && $pendingUsersList->isNotEmpty()) || (isset($pendingReportsList) && $pendingReportsList->isNotEmpty()))
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                @if(isset($latestAnnouncements) && $latestAnnouncements->isNotEmpty())
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-background/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-text flex items-center gap-2">
                            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Latest Announcements
                        </h3>
                        <a href="{{ Route::has('announcements.index') ? route('announcements.index') : '#' }}" class="text-sm text-primary font-semibold hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-border">
                        @foreach($latestAnnouncements as $announcement)
                        <div class="p-4 hover:bg-background/50 transition-colors">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-text">{{ $announcement->title }}</h4>
                                <span class="text-xs text-muted">{{ $announcement->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-muted line-clamp-2">{{ strip_tags($announcement->content) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($upcomingActivities) && $upcomingActivities->isNotEmpty())
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-background/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-text flex items-center gap-2">
                            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Upcoming Activities
                        </h3>
                        <a href="{{ Route::has('activities.index') ? route('activities.index') : '#' }}" class="text-sm text-primary font-semibold hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-border">
                        @foreach($upcomingActivities as $activity)
                        <div class="p-4 hover:bg-background/50 transition-colors flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-success/10 rounded-xl flex flex-col items-center justify-center text-success">
                                <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($activity->date)->format('M') }}</span>
                                <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($activity->date)->format('d') }}</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-text">{{ $activity->title }}</h4>
                                <p class="text-xs text-muted mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $activity->location ?? 'TBA' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($recentMembers) && $recentMembers->isNotEmpty())
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-background/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-text flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            New Members
                        </h3>
                        <a href="{{ Route::has('members.index') ? route('members.index') : '#' }}" class="text-sm text-primary font-semibold hover:underline">Directory</a>
                    </div>
                    <div class="divide-y divide-border">
                        @foreach($recentMembers as $member)
                        <div class="p-4 hover:bg-background/50 transition-colors flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-text">{{ $member->name }}</h4>
                                    <p class="text-xs text-muted">{{ $member->rank ?? 'Member' }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-muted">{{ $member->created_at->diffForHumans() }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if((isset($pendingUsersList) && $pendingUsersList->isNotEmpty()) || (isset($pendingReportsList) && $pendingReportsList->isNotEmpty()))
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-background/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-text flex items-center gap-2">
                            <svg class="w-5 h-5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Pending Actions
                        </h3>
                    </div>
                    <div class="divide-y divide-border">
                        @if(isset($pendingUsersList))
                        @foreach($pendingUsersList as $pUser)
                        <div class="p-4 hover:bg-background/50 transition-colors flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-danger"></div>
                                <div>
                                    <h4 class="text-sm font-bold text-text">User Approval Required</h4>
                                    <p class="text-xs text-muted">{{ $pUser->name }} ({{ $pUser->email }})</p>
                                </div>
                            </div>
                            <a href="{{ Route::has('users.index') ? route('users.index') : '#' }}" class="text-xs px-3 py-1 bg-surface border border-border rounded-lg hover:border-danger hover:text-danger transition-colors">Review</a>
                        </div>
                        @endforeach
                        @endif

                        @if(isset($pendingReportsList))
                        @foreach($pendingReportsList as $pReport)
                        <div class="p-4 hover:bg-background/50 transition-colors flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                <div>
                                    <h4 class="text-sm font-bold text-text">Report Review Required</h4>
                                    <p class="text-xs text-muted">{{ $pReport->title }}</p>
                                </div>
                            </div>
                            <a href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}" class="text-xs px-3 py-1 bg-surface border border-border rounded-lg hover:border-secondary hover:text-secondary transition-colors">Review</a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif

            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Graphics / Premium Features (Takes 2 columns if exists) -->
                @if(isset($chartData))
                <div class="lg:col-span-2 bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                    <div class="px-8 py-6 border-b border-border bg-background/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-text">Platform Growth Metrics</h3>
                            <p class="text-sm text-muted mt-1">New member registrations over the last 6 months.</p>
                        </div>
                        <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full border border-primary/20">Pro View</span>
                    </div>
                    <div class="p-6">
                        <div id="growthChart" class="w-full h-72"></div>
                    </div>
                </div>
                @endif

                <!-- Interactive Event Calendar -->
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden {{ isset($chartData) ? 'lg:col-span-1' : 'lg:col-span-3' }}">
                    <div class="px-8 py-6 border-b border-border bg-background/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-text">Event Calendar</h3>
                            <p class="text-sm text-muted mt-1" id="calendar-month-year"></p>
                        </div>
                        <div class="p-2 bg-primary/10 text-primary rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-7 gap-1 text-center mb-2" id="calendar-days-header">
                            <div class="text-xs font-bold text-muted uppercase">Sun</div>
                            <div class="text-xs font-bold text-muted uppercase">Mon</div>
                            <div class="text-xs font-bold text-muted uppercase">Tue</div>
                            <div class="text-xs font-bold text-muted uppercase">Wed</div>
                            <div class="text-xs font-bold text-muted uppercase">Thu</div>
                            <div class="text-xs font-bold text-muted uppercase">Fri</div>
                            <div class="text-xs font-bold text-muted uppercase">Sat</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1" id="calendar-grid">
                            <!-- Calendar days will be injected here via JS -->
                        </div>
                        <div class="mt-4 flex items-center justify-center gap-4 text-xs text-muted">
                            <div class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-success"></div> Event</div>
                            <div class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-transparent border-2 border-primary"></div> Today</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    @if(isset($chartData))
    <!-- Premium Graphics Script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'New Members',
                    data: {!! json_encode($chartData['series']) !!}
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                colors: ['#1E2FA3'], // Using system primary color
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: {!! json_encode($chartData['labels']) !!},
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#667085' } }
                },
                yaxis: {
                    labels: { style: { colors: '#667085' } }
                },
                grid: {
                    borderColor: '#E4E7EC',
                    strokeDashArray: 4,
                }
            };

            var chart = new ApexCharts(document.querySelector("#growthChart"), options);
            chart.render();
        });
    </script>
    @endif
    
    <!-- Calendar JS Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const activities = {!! json_encode($calendarActivities ?? []) !!};
            const calendarGrid = document.getElementById('calendar-grid');
            const monthYearLabel = document.getElementById('calendar-month-year');
            
            if (!calendarGrid) return;

            const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth();
            
            monthYearLabel.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            const eventMap = {};
            activities.forEach(act => {
                const actDate = new Date(act.date);
                if (actDate.getMonth() === month && actDate.getFullYear() === year) {
                    const day = actDate.getDate();
                    if (!eventMap[day]) eventMap[day] = [];
                    eventMap[day].push(act);
                }
            });

            for (let i = 0; i < firstDay; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'aspect-square rounded-xl bg-transparent';
                calendarGrid.appendChild(emptyDiv);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = (day === date.getDate());
                const hasEvent = eventMap[day] && eventMap[day].length > 0;
                
                const dayDiv = document.createElement('div');
                dayDiv.className = 'aspect-square flex flex-col items-center justify-center rounded-xl relative text-sm font-medium transition-all duration-200 cursor-default p-1';
                
                if (isToday) {
                    dayDiv.classList.add('border-2', 'border-primary', 'text-primary', 'font-bold');
                } else {
                    dayDiv.classList.add('text-text');
                }

                dayDiv.textContent = day;

                if (hasEvent) {
                    dayDiv.classList.add('bg-success/10', 'hover:bg-success/20', 'cursor-pointer', 'group');
                    dayDiv.classList.remove('text-text');
                    if(!isToday) dayDiv.classList.add('text-success', 'font-bold');
                    
                    const dot = document.createElement('div');
                    dot.className = 'absolute bottom-1 w-1.5 h-1.5 rounded-full bg-success';
                    dayDiv.appendChild(dot);
                    
                    const tooltipText = eventMap[day].map(e => e.title).join(' | ');
                    dayDiv.title = tooltipText;
                    
                    // Simple custom tooltip on hover (optional enhancement if native title is enough)
                    // We'll stick to native title= as it is clean and robust out of the box.
                } else {
                    dayDiv.classList.add('hover:bg-surface/50');
                }
                
                calendarGrid.appendChild(dayDiv);
            }
        });
    </script>
</x-app-layout>
