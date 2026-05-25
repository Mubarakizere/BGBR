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

                <!-- Permission-Gated Quick Actions Section -->
                <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden {{ isset($chartData) ? 'lg:col-span-1' : 'lg:col-span-3' }}">
                    <div class="px-8 py-6 border-b border-border bg-background/50">
                        <h3 class="text-xl font-bold text-text">Operational Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 {{ isset($chartData) ? 'lg:grid-cols-2' : 'md:grid-cols-4' }} gap-4">
                            
                            @can('register members')
                            <a href="{{ route('members.index') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-primary hover:bg-primary/5 transition-all text-center group">
                                <div class="w-12 h-12 rounded-full bg-background flex items-center justify-center text-muted mb-4 group-hover:bg-primary/10 group-hover:text-primary transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-text group-hover:text-primary">Directory</span>
                            </a>
                            @endcan

                            @can('manage companies')
                            <a href="{{ route('companies.index') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-accent hover:bg-accent/5 transition-all text-center group">
                                <div class="w-12 h-12 rounded-full bg-background flex items-center justify-center text-muted mb-4 group-hover:bg-accent/10 group-hover:text-accent transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-text group-hover:text-accent">Companies</span>
                            </a>
                            @endcan

                            @can('manage battalions')
                            <a href="{{ route('battalions.index') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-secondary hover:bg-secondary/5 transition-all text-center group">
                                <div class="w-12 h-12 rounded-full bg-background flex items-center justify-center text-muted mb-4 group-hover:bg-secondary/10 group-hover:text-secondary transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-text group-hover:text-secondary">Battalions</span>
                            </a>
                            @endcan

                            <!-- Standard action for all logged in users -->
                            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-6 border border-border rounded-xl hover:border-muted hover:bg-muted/5 transition-all text-center group">
                                <div class="w-12 h-12 rounded-full bg-background flex items-center justify-center text-muted mb-4 group-hover:bg-border group-hover:text-text transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-text group-hover:text-text">My Profile</span>
                            </a>

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
</x-app-layout>
