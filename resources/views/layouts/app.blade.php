<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Header / Top Bar -->
                <header class="bg-white dark:bg-gray-800 shadow-sm z-10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                        <!-- Header slot if exists -->
                        @if (isset($header))
                            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                                {{ $header }}
                            </div>
                        @else
                            <div></div>
                        @endif

                        <!-- User Dropdown (Simplified) -->
                        <div class="flex items-center gap-4">
                            <span class="text-gray-600 dark:text-gray-300 text-sm font-medium">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">Log out</button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                            <p class="font-medium">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                            <p class="font-medium">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
