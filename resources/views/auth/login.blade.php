<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-extrabold text-text tracking-tight">Welcome Back</h2>
        <p class="text-sm text-muted mt-1.5 font-medium">Sign in to your management account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-text mb-1.5">{{ __('Email Address') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-muted group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                </div>
                <input id="email" class="pl-11 block w-full border-border focus:border-primary focus:ring-primary rounded-xl shadow-sm text-text sm:text-sm transition-all duration-200 py-2.5 bg-background focus:bg-surface" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="officer@bgbr.rw" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-text mb-1.5">{{ __('Password') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-muted group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <input id="password" class="pl-11 block w-full border-border focus:border-primary focus:ring-primary rounded-xl shadow-sm text-text sm:text-sm transition-all duration-200 py-2.5 bg-background focus:bg-surface" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-border text-primary shadow-sm focus:ring-primary focus:ring-offset-0 transition-colors w-4 h-4 cursor-pointer" name="remember">
                <span class="ml-2.5 text-sm text-muted group-hover:text-text transition-colors font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-primary hover:text-secondary transition-colors focus:outline-none focus:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-primary hover:bg-[#152280] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                {{ __('Sign In') }}
            </button>
        </div>
    </form>

    <div class="mt-6 pt-5 border-t border-border text-center">
        <p class="text-sm text-muted font-medium">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-primary hover:text-secondary transition-colors ml-1">Register now</a>
        </p>
    </div>
</x-guest-layout>
