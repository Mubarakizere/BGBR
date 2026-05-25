<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BGBR Rwanda') }}</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E2FA3">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="BGBR">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192x192.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-background text-text overflow-x-hidden selection:bg-secondary selection:text-text">
    
    <!-- Navigation -->
    <nav class="absolute top-0 w-full z-50 px-6 py-4 lg:px-12 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="bg-white/90 backdrop-blur-sm p-1.5 rounded-xl shadow-sm border border-white/20">
                <img src="{{ asset('images/logo.jpg') }}" alt="BGBR Logo" class="w-10 h-10 object-contain" />
            </div>
            <span class="text-white font-extrabold tracking-tight text-xl drop-shadow-md">BGBR</span>
        </div>
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="text-white font-medium hover:text-secondary transition-colors px-4 py-2">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-primary bg-white rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 hover:bg-gray-50 transition-all duration-200 ring-2 ring-transparent focus:ring-secondary focus:outline-none">
                    Log In
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center bg-primary overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 z-0 opacity-40">
            <div class="absolute top-[-10%] right-[-5%] w-[40rem] h-[40rem] rounded-full bg-secondary/30 blur-[100px] animate-pulse mix-blend-screen" style="animation-duration: 8s;"></div>
            <div class="absolute bottom-[-20%] left-[-10%] w-[50rem] h-[50rem] rounded-full bg-[#3B82F6]/40 blur-[120px] mix-blend-screen"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 px-6 w-full max-w-5xl mx-auto text-center flex flex-col items-center">
            
            <div class="inline-block mb-6 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-sm font-semibold tracking-wide shadow-sm">
                Welcome to the Management Portal
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6 drop-shadow-lg">
                The Boys' and Girls'<br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-[#FFE270] drop-shadow-sm">Brigade Rwanda</span>
            </h1>
            
            <p class="mt-4 text-lg sm:text-xl text-blue-100 max-w-2xl mx-auto font-medium leading-relaxed drop-shadow mb-10">
                Sure & Steadfast. Empowering youth through Christian values, leadership, and discipline. Access the central portal to manage battalions, members, and activities.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 text-base font-bold text-primary bg-secondary hover:bg-[#FFE270] rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                        Go to Dashboard
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 text-base font-bold text-primary bg-white hover:bg-gray-50 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                        Access Account
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-white/10 hover:bg-white/20 border border-white/30 backdrop-blur-md rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
            
            <!-- Floating Feature Pills -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-4 text-white/80 text-sm font-medium">
                <div class="flex items-center justify-center gap-2 bg-white/5 rounded-full py-2.5 px-4 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-secondary" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    Member DB
                </div>
                <div class="flex items-center justify-center gap-2 bg-white/5 rounded-full py-2.5 px-4 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Activities
                </div>
                <div class="flex items-center justify-center gap-2 bg-white/5 rounded-full py-2.5 px-4 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Finance
                </div>
                <div class="flex items-center justify-center gap-2 bg-white/5 rounded-full py-2.5 px-4 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Reports
                </div>
            </div>

        </div>
    </div>
</body>
</html>
