<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-text bg-background overflow-hidden" x-data="{ sidebarOpen: false }">
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

                            <!-- Top Nav Stats -->
                            <div class="hidden lg:flex gap-6 ml-4 pl-6 border-l border-border">
                                <div class="flex items-center gap-3 group cursor-pointer">
                                    <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary transition group-hover:bg-primary group-hover:text-surface">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-muted font-bold uppercase tracking-widest">Total Members</p>
                                        <p class="text-sm font-black text-text leading-tight">{{ \App\Models\Member::count() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 group cursor-pointer">
                                    <div class="w-9 h-9 rounded-full bg-success/10 flex items-center justify-center text-success transition group-hover:bg-success group-hover:text-surface">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-muted font-bold uppercase tracking-widest">Active Companies</p>
                                        <p class="text-sm font-black text-text leading-tight">{{ \App\Models\Company::count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4">
                            <!-- Notification Bell -->
                            <div class="relative" x-data="{ showNotifications: false }" @click.outside="showNotifications = false">
                                <button @click="showNotifications = !showNotifications" class="relative p-2 text-muted hover:text-primary transition rounded-full hover:bg-primary/10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-danger rounded-full ring-2 ring-surface"></span>
                                    @endif
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
                                        @if(Auth::user()->unreadNotifications->count() > 0)
                                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-[11px] text-primary hover:underline font-semibold">Mark all as read</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(Auth::user()->unreadNotifications as $notification)
                                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full text-left p-4 border-b border-border hover:bg-primary/5 transition group cursor-pointer block">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0 text-primary group-hover:bg-primary group-hover:text-surface transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold text-text leading-tight group-hover:text-primary transition">{{ $notification->data['title'] ?? 'New Notification' }}</p>
                                                            <p class="text-[11px] text-muted mt-1 line-clamp-2">{{ $notification->data['content_excerpt'] ?? '' }}</p>
                                                            <p class="text-[10px] text-muted/60 mt-2 font-medium uppercase tracking-wider">{{ $notification->created_at->diffForHumans() }}</p>
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        @empty
                                            <div class="p-6 text-center">
                                                <div class="w-12 h-12 rounded-full bg-primary/5 text-primary/30 flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                                </div>
                                                <p class="text-sm text-muted font-medium">No new notifications</p>
                                            </div>
                                        @endforelse
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
    </body>
</html>
