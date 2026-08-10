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

        <title>{{ config('app.name', 'Boys and Girls Brigade Rwanda') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="text-text antialiased bg-background">
        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />
        <x-flash-message type="warning" :message="session('warning')" />
        <x-flash-message type="info" :message="session('info')" />

        <div class="min-h-screen flex">
            <!-- Left Pane (Brand Visuals) -->
            <div class="hidden lg:flex lg:w-5/12 relative overflow-hidden flex-col justify-between p-12 shadow-[10px_0_30px_rgba(0,0,0,0.1)] z-10">
                <!-- Background Image of Rwanda -->
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1544654803-b69140b285a1?auto=format&fit=crop&q=80&w=1000');"></div>
                <!-- Blue Overlay for text readability -->
                <div class="absolute inset-0 bg-[#1E2FA3] opacity-80"></div>
                
                <div class="relative z-10 flex flex-col justify-center h-full">
                    <h1 class="text-5xl font-extrabold text-white tracking-tight mb-6 leading-tight drop-shadow-lg">
                        The Boys' and Girls'<br/>
                        <span class="text-secondary">Brigade Rwanda</span>
                    </h1>
                    <p class="text-xl text-white/90 max-w-md font-medium leading-relaxed drop-shadow">
                        Sure & Steadfast. Empowering youth through Christian values, leadership, and discipline.
                    </p>
                </div>
                
                <div class="relative z-10 text-white/70 text-sm font-medium">
                    &copy; {{ date('Y') }} Boys and Girls Brigade Rwanda. All rights reserved.
                </div>
            </div>

            <!-- Right Pane (Form Area) -->
            <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 relative bg-background">
                <!-- Background decorative blob on right side -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <!-- Mobile Only Header -->
                <div class="lg:hidden w-full max-w-md mb-6 text-center relative z-10">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Boys and Girls Brigade Logo" class="w-20 h-auto object-contain mx-auto drop-shadow-sm rounded-2xl bg-white p-2" />
                </div>

                <div class="w-full max-w-md relative z-10">
                    <!-- Desktop Logo -->
                    <div class="hidden lg:flex justify-center mb-6">
                        <div class="bg-white/90 backdrop-blur-sm p-2 rounded-2xl shadow-sm border border-gray-100">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Boys and Girls Brigade Logo" class="w-20 h-auto object-contain drop-shadow-sm" />
                        </div>
                    </div>

                    <!-- Card Wrapper -->
                    <div class="bg-surface p-6 sm:p-8 rounded-3xl shadow-xl border border-border backdrop-blur-sm relative overflow-hidden">
                        <!-- Top subtle gradient line -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-secondary to-primary"></div>
                        
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
