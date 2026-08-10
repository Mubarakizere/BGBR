<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- PWA Meta Tags -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#1E2FA3">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Boys and Girls Brigade">
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192x192.png') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-text bg-background overflow-hidden" x-data="{ sidebarOpen: false, searchModalOpen: false }" @keydown.window.ctrl.k.prevent="searchModalOpen = true" @keydown.window.meta.k.prevent="searchModalOpen = true">
        <div class="h-screen flex w-full">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto bg-background relative">
                <!-- Top Header / Top Bar -->
                <header class="bg-surface/80 backdrop-blur-lg border-b border-border shadow-sm z-30 sticky top-0">
                    <div class="px-6 h-16 flex items-center justify-between">
                        <!-- Header slot if exists -->
                        <div class="flex items-center gap-6">
                            <!-- Mobile menu button -->
                            <button @click="sidebarOpen = true" class="md:hidden text-muted hover:text-primary transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            
                            @if (isset($header))
                                <div class="font-black text-xl text-primary tracking-tight hidden sm:block">
                                    {{ $header }}
                                </div>
                            @endif

                            <!-- Top Nav Stats Removed for a cleaner pro look -->
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4">
                            <!-- Global Search Trigger -->
                            <button @click="searchModalOpen = true" class="hidden sm:flex relative items-center w-48 lg:w-64 pl-10 pr-4 py-2 bg-background border border-border rounded-full text-sm font-medium text-muted hover:border-primary hover:text-text transition-all shadow-sm text-left group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-muted group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <span class="flex-1">Search...</span>
                                <kbd class="hidden xl:inline-block text-[10px] font-semibold bg-surface border border-border rounded px-1.5 py-0.5 text-muted shadow-sm">Ctrl K</kbd>
                            </button>
                            <!-- Notification Bell -->
                            <div class="relative" x-data="{ showNotifications: false }" @click.outside="showNotifications = false">
                                <button @click="showNotifications = !showNotifications" class="relative p-2 text-muted hover:text-primary transition rounded-full hover:bg-primary/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    <template x-if="$store.notifications.count > 0">
                                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-danger rounded-full ring-2 ring-surface"></span>
                                    </template>
                                </button>
                                
                                <div x-show="showNotifications" style="display: none;"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-80 bg-surface rounded-2xl shadow-xl border border-border overflow-hidden z-50 origin-top-right">
                                    <div class="p-4 border-b border-border flex items-center justify-between bg-surface/50">
                                        <h3 class="font-bold text-text">Notifications</h3>
                                        <template x-if="$store.notifications.count > 0">
                                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-[11px] text-primary hover:underline font-semibold">Mark all as read</button>
                                            </form>
                                        </template>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <template x-for="notification in $store.notifications.items" :key="notification.id">
                                            <form method="POST" :action="notification.read_route" class="block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full text-left p-4 border-b border-border hover:bg-primary/5 transition group cursor-pointer block">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0 text-primary group-hover:bg-primary group-hover:text-surface transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold text-text leading-tight group-hover:text-primary transition" x-text="notification.title"></p>
                                                            <p class="text-[11px] text-muted mt-1 line-clamp-2" x-text="notification.content_excerpt"></p>
                                                            <p class="text-[10px] text-muted/60 mt-2 font-medium uppercase tracking-wider" x-text="notification.created_at"></p>
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        </template>
                                        
                                        <template x-if="$store.notifications.count === 0">
                                            <div class="p-6 text-center">
                                                <div class="w-12 h-12 rounded-full bg-primary/5 text-primary/30 flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                                </div>
                                                <p class="text-sm text-muted font-medium">No new notifications</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-surface hover:bg-danger hover:text-surface text-sm text-danger font-bold py-1.5 px-4 rounded-full transition-all border border-danger/20 flex items-center gap-2 shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span class="hidden sm:inline">Log out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Flash Messages -->
                <x-flash-message type="success" :message="session('success')" />
                <x-flash-message type="error" :message="session('error')" />
                <x-flash-message type="warning" :message="session('warning')" />
                <x-flash-message type="info" :message="session('info')" />

                <!-- Page Content -->
                <main class="flex-1 w-full pb-10">
                    {{ $slot }}
                </main>
            </div>
        </div>
        {{-- Global Delete Confirmation Modal --}}
        <x-delete-confirm-modal />

        {{-- Global Search Modal --}}
        <div x-show="searchModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog" aria-modal="true"
             x-data="{ 
                 query: '', 
                 results: { battalions: [], companies: [], members: [] }, 
                 loading: false,
                 fetchResults() {
                     if (this.query.length < 2) {
                         this.results = { battalions: [], companies: [], members: [] };
                         return;
                     }
                     this.loading = true;
                     fetch('{{ route('search.index') }}?q=' + encodeURIComponent(this.query), {
                         headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                     })
                     .then(res => res.json())
                     .then(data => {
                         this.results = data;
                         this.loading = false;
                     });
                 }
             }">
            
            <div x-show="searchModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="searchModalOpen = false"></div>

            <div x-show="searchModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0" class="mx-auto max-w-2xl transform divide-y divide-border overflow-hidden rounded-2xl bg-surface shadow-2xl ring-1 ring-black ring-opacity-5 transition-all relative z-10 mt-10 sm:mt-20" @click.stop>
                
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model.debounce.300ms="query" @input="fetchResults" x-ref="searchInput" class="h-14 w-full border-0 bg-transparent pl-11 pr-4 text-text placeholder:text-muted focus:ring-0 sm:text-base outline-none font-medium" placeholder="Search battalions, companies, members..." autocomplete="off" @keydown.escape="searchModalOpen = false" x-init="$watch('searchModalOpen', value => { if (value) { setTimeout(() => $refs.searchInput.focus(), 100); } else { query = ''; results = { battalions: [], companies: [], members: [] }; } })">
                </div>

                <!-- Results -->
                <div x-show="query.length > 0" class="max-h-[60vh] overflow-y-auto p-3" style="display: none;">
                    
                    <div x-show="loading" class="p-8 text-center text-sm text-muted">
                        <svg class="animate-spin h-6 w-6 mx-auto text-primary mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Searching...
                    </div>

                    <div x-show="!loading && results.battalions.length === 0 && results.companies.length === 0 && results.members.length === 0" class="p-8 text-center text-sm text-muted" style="display: none;">
                        No results found for "<span x-text="query" class="font-bold text-text"></span>".
                    </div>

                    <!-- Battalions -->
                    <template x-if="results.battalions && results.battalions.length > 0">
                        <div class="mb-4">
                            <h2 class="bg-surface px-3 py-1.5 text-xs font-bold text-muted uppercase tracking-wider sticky top-0">Battalions</h2>
                            <ul class="mt-2 text-sm text-text">
                                <template x-for="item in results.battalions" :key="item.id">
                                    <li class="group cursor-pointer select-none rounded-xl px-4 py-3 hover:bg-primary/10 transition-colors">
                                        <a :href="item.url" class="flex flex-col w-full h-full">
                                            <span class="font-bold text-text group-hover:text-primary transition-colors" x-text="item.title"></span>
                                            <span class="text-xs font-medium text-muted mt-0.5 uppercase tracking-wider" x-text="item.subtitle"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>

                    <!-- Companies -->
                    <template x-if="results.companies && results.companies.length > 0">
                        <div class="mb-4">
                            <h2 class="bg-surface px-3 py-1.5 text-xs font-bold text-muted uppercase tracking-wider sticky top-0">Companies</h2>
                            <ul class="mt-2 text-sm text-text">
                                <template x-for="item in results.companies" :key="item.id">
                                    <li class="group cursor-pointer select-none rounded-xl px-4 py-3 hover:bg-success/10 transition-colors">
                                        <a :href="item.url" class="flex flex-col w-full h-full">
                                            <span class="font-bold text-text group-hover:text-success transition-colors" x-text="item.title"></span>
                                            <span class="text-xs font-medium text-muted mt-0.5 uppercase tracking-wider" x-text="item.subtitle"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>

                    <!-- Members -->
                    <template x-if="results.members && results.members.length > 0">
                        <div>
                            <h2 class="bg-surface px-3 py-1.5 text-xs font-bold text-muted uppercase tracking-wider sticky top-0">Members</h2>
                            <ul class="mt-2 text-sm text-text">
                                <template x-for="item in results.members" :key="item.id">
                                    <li class="group cursor-pointer select-none rounded-xl px-4 py-3 hover:bg-indigo-500/10 transition-colors">
                                        <a :href="item.url" class="flex flex-col w-full h-full">
                                            <span class="font-bold text-text group-hover:text-indigo-600 transition-colors" x-text="item.title"></span>
                                            <span class="text-xs font-medium text-muted mt-0.5 uppercase tracking-wider" x-text="item.subtitle"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>
                
                <!-- Helper footer -->
                <div class="flex flex-wrap items-center bg-background/50 py-3 px-4 text-xs font-medium text-muted justify-between border-t border-border">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5"><kbd class="font-bold bg-surface border border-border rounded px-1.5 shadow-sm text-[10px]">ESC</kbd> to close</span>
                    </div>
                    <span>Boys and Girls Brigade</span>
                </div>
            </div>
        </div>

        @auth
            <!-- Toast Notification Container -->
            <div class="fixed bottom-4 right-4 z-[100] flex flex-col gap-2 pointer-events-none" id="toast-container">
                <template x-for="toast in $store.notifications.toasts" :key="toast.id">
                    <div x-show="toast.show" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="bg-surface border border-border shadow-lg rounded-xl p-4 w-80 pointer-events-auto relative overflow-hidden group">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0 text-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-text leading-tight truncate" x-text="toast.title"></p>
                                <p class="text-xs text-muted mt-0.5 line-clamp-2" x-text="toast.content"></p>
                            </div>
                            <button @click="$store.notifications.dismiss(toast.id)" class="text-muted/50 hover:text-muted transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            @php
                $initialNotifications = Auth::user()->unreadNotifications->take(10)->map(function($n) {
                    return [
                        'id' => $n->id,
                        'title' => $n->data['title'] ?? 'Notification',
                        'content_excerpt' => $n->data['content_excerpt'] ?? '',
                        'created_at' => $n->created_at->diffForHumans(),
                        'read_route' => route('notifications.read', $n->id)
                    ];
                });
            @endphp
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.store('notifications', {
                        count: {{ Auth::user()->unreadNotifications->count() ?? 0 }},
                        items: @json($initialNotifications),
                        toasts: [],
                        
                        init() {
                            this.startPolling();
                        },

                        startPolling() {
                            setInterval(() => {
                                fetch('{{ route('notifications.fetch') }}')
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.count > this.count) {
                                            let existingIds = this.items.map(i => i.id);
                                            data.notifications.forEach(n => {
                                                if (!existingIds.includes(n.id)) {
                                                    this.addToast(n.title, n.content_excerpt);
                                                }
                                            });
                                        }
                                        this.count = data.count;
                                        this.items = data.notifications;
                                    })
                                    .catch(err => console.error('Error fetching notifications:', err));
                            }, 15000); // 15 seconds
                        },

                        addToast(title, content) {
                            const id = Date.now();
                            this.toasts.push({ id, title, content, show: true });
                            setTimeout(() => this.dismiss(id), 5000); // Hide after 5 seconds
                        },

                        dismiss(id) {
                            const toast = this.toasts.find(t => t.id === id);
                            if(toast) toast.show = false;
                            setTimeout(() => {
                                this.toasts = this.toasts.filter(t => t.id !== id);
                            }, 300);
                        }
                    });
                });
            </script>
        @endauth
    </body>
</html>
