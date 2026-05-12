<x-guest-layout>
    <!-- Background styling -->
    <div class="fixed inset-0 bg-bgbr-bg z-[-1] overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 rounded-full bg-bgbr-blue/10 blur-3xl"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 rounded-full bg-bgbr-gold/20 blur-3xl"></div>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl rounded-2xl border border-gray-100 relative z-10">
        
        <!-- Logo / Branding Header -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-bgbr-blue text-white flex items-center justify-center rounded-xl shadow-lg mb-4 shadow-bgbr-blue/30 transform hover:scale-105 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-bgbr-dark tracking-tight">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-2">Sign in to your BGBR Management Account</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-bgbr-dark mb-1">{{ __('Email Address') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </div>
                    <input id="email" class="pl-10 block w-full border-gray-300 focus:border-bgbr-blue focus:ring-bgbr-blue rounded-lg shadow-sm text-bgbr-dark sm:text-sm transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="officer@bgbr.rw" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-bgbr-red" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-bgbr-dark mb-1">{{ __('Password') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <input id="password" class="pl-10 block w-full border-gray-300 focus:border-bgbr-blue focus:ring-bgbr-blue rounded-lg shadow-sm text-bgbr-dark sm:text-sm transition-colors"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-bgbr-red" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-bgbr-blue shadow-sm focus:ring-bgbr-blue" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-bgbr-blue hover:text-bgbr-gold transition-colors focus:outline-none" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-bgbr-blue hover:bg-[#152280] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bgbr-blue transition-all duration-200 shadow-bgbr-blue/40 hover:shadow-lg hover:-translate-y-0.5">
                    {{ __('Sign In') }}
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-semibold text-bgbr-blue hover:text-bgbr-gold transition-colors">Register now</a>
            </p>
        </div>
    </div>
</x-guest-layout>
