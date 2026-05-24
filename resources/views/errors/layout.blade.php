<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') - {{ config('app.name', 'BGBR Rwanda') }}</title>
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
        <div class="min-h-screen flex">
            <!-- Left Pane (Visuals) -->
            <div class="hidden lg:flex lg:w-5/12 bg-primary relative overflow-hidden flex-col justify-between p-12 shadow-[10px_0_30px_rgba(0,0,0,0.1)] z-10">
                <!-- Decorative Gradients -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-secondary opacity-20 blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col justify-center h-full">
                    <h1 class="text-9xl font-extrabold text-white tracking-tight mb-2 leading-none drop-shadow-lg opacity-80">
                        @yield('code')
                    </h1>
                    <h2 class="text-4xl font-bold text-white tracking-tight mb-6 leading-tight drop-shadow-md">
                        @yield('message')
                    </h2>
                    <p class="text-xl text-white/80 max-w-md font-medium leading-relaxed drop-shadow">
                        Don't worry, even the most steadfast navigators sometimes go off course.
                    </p>
                </div>
                
                <div class="relative z-10 text-white/70 text-sm font-medium flex items-center gap-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="BGBR Logo" class="w-12 h-auto object-contain rounded-lg bg-white p-1" />
                    <span>&copy; {{ date('Y') }} BGBR Rwanda.</span>
                </div>
            </div>

            <!-- Right Pane (Action Area) -->
            <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-6 sm:p-12 relative bg-background">
                <!-- Background decorative blob on right side -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="w-full max-w-md relative z-10 text-center lg:text-left">
                    <!-- Mobile Only Error Display -->
                    <div class="lg:hidden mb-12">
                        <img src="{{ asset('images/logo.jpg') }}" alt="BGBR Logo" class="w-24 h-auto object-contain mx-auto drop-shadow-md rounded-2xl bg-white p-2 mb-8" />
                        <h1 class="text-8xl font-extrabold text-primary tracking-tight mb-2 leading-none">
                            @yield('code')
                        </h1>
                        <h2 class="text-2xl font-bold text-text mb-4">
                            @yield('message')
                        </h2>
                    </div>

                    <div class="bg-surface p-8 sm:p-10 rounded-3xl shadow-xl border border-border backdrop-blur-sm relative overflow-hidden text-center lg:text-left">
                        <!-- Top subtle gradient line -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-secondary to-primary"></div>
                        
                        <div class="mb-8">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6 mx-auto lg:mx-0">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-text mb-2">Oops! Something went wrong.</h3>
                            <p class="text-text/70 mb-6">
                                @yield('description', 'We encountered an unexpected error while trying to process your request.')
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="inline-flex justify-center items-center px-6 py-3 border border-border bg-white text-text font-medium rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Go Back
                            </a>
                            <a href="{{ url('/') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent bg-primary text-white font-medium rounded-xl hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/30 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
