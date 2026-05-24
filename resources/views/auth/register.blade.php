<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-text tracking-tight">Create Account</h2>
        <p class="text-sm text-muted mt-2 font-medium">Join the BGBR Rwanda portal</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-text mb-1.5">{{ __('Full Name') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-muted group-focus-within:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <input id="name" class="pl-11 block w-full border-border focus:border-secondary focus:ring-secondary rounded-xl shadow-sm text-text sm:text-sm transition-all duration-200 py-3 bg-background focus:bg-surface" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-text mb-1.5">{{ __('Email Address') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-muted group-focus-within:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <input id="email" class="pl-11 block w-full border-border focus:border-secondary focus:ring-secondary rounded-xl shadow-sm text-text sm:text-sm transition-all duration-200 py-3 bg-background focus:bg-surface" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="officer@bgbr.rw" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-text mb-1.5">{{ __('Password') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-muted group-focus-within:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <input id="password" class="pl-11 block w-full border-border focus:border-secondary focus:ring-secondary rounded-xl shadow-sm text-text sm:text-sm transition-all duration-200 py-3 bg-background focus:bg-surface" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-text mb-1.5">{{ __('Confirm Password') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-muted group-focus-within:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <input id="password_confirmation" class="pl-11 block w-full border-border focus:border-secondary focus:ring-secondary rounded-xl shadow-sm text-text sm:text-sm transition-all duration-200 py-3 bg-background focus:bg-surface" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <div class="mt-4 bg-primary/5 border-l-4 border-primary p-4 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs text-primary font-medium leading-relaxed">Your account will require administrator approval before you can access the dashboard.</p>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-text bg-secondary hover:bg-[#e0b028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                {{ __('Register Account') }}
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-border text-center">
        <p class="text-sm text-muted font-medium">
            Already registered? 
            <a href="{{ route('login') }}" class="font-bold text-primary hover:text-secondary transition-colors ml-1">Sign in here</a>
        </p>
    </div>
</x-guest-layout>
