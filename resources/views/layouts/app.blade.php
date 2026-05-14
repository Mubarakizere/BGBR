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
                @if(session('success'))
                    <div class="px-6 mt-6">
                        <div class="bg-success/10 border border-success/30 text-success p-4 rounded-xl shadow-sm flex items-start gap-3" role="alert">
                            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="font-bold">Success</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="px-6 mt-6">
                        <div class="bg-danger/10 border border-danger/30 text-danger p-4 rounded-xl shadow-sm flex items-start gap-3" role="alert">
                            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="font-bold">Error</p>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 w-full pb-10">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
