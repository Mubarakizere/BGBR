<x-guest-layout>
    <!-- Background styling -->
    <div class="fixed inset-0 bg-bgbr-bg z-[-1] overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 rounded-full bg-bgbr-gold/20 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 rounded-full bg-bgbr-blue/10 blur-3xl"></div>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl rounded-2xl border border-gray-100 relative z-10">
        
        <!-- Logo / Branding Header -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-bgbr-gold text-bgbr-dark flex items-center justify-center rounded-xl shadow-lg mb-4 shadow-bgbr-gold/30 transform hover:scale-105 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-bgbr-dark tracking-tight">Create Account</h2>
            <p class="text-sm text-gray-500 mt-2">Join the BGBR Rwanda portal</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-bgbr-dark mb-1">{{ __('Full Name') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <input id="name" class="pl-10 block w-full border-gray-300 focus:border-bgbr-gold focus:ring-bgbr-gold rounded-lg shadow-sm text-bgbr-dark sm:text-sm transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-bgbr-red" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-bgbr-dark mb-1">{{ __('Email Address') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <input id="email" class="pl-10 block w-full border-gray-300 focus:border-bgbr-gold focus:ring-bgbr-gold rounded-lg shadow-sm text-bgbr-dark sm:text-sm transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="officer@bgbr.rw" />
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
                    <input id="password" class="pl-10 block w-full border-gray-300 focus:border-bgbr-gold focus:ring-bgbr-gold rounded-lg shadow-sm text-bgbr-dark sm:text-sm transition-colors" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-bgbr-red" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-bgbr-dark mb-1">{{ __('Confirm Password') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <input id="password_confirmation" class="pl-10 block w-full border-gray-300 focus:border-bgbr-gold focus:ring-bgbr-gold rounded-lg shadow-sm text-bgbr-dark sm:text-sm transition-colors" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-bgbr-red" />
            </div>

            <div class="mt-2 bg-blue-50 border-l-4 border-bgbr-blue p-3 rounded-r-md">
                <p class="text-xs text-bgbr-blue font-medium">Note: Your account will need to be approved by an administrator before you can access the dashboard.</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-bgbr-dark bg-bgbr-gold hover:bg-[#e0b028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bgbr-gold transition-all duration-200 shadow-bgbr-gold/40 hover:shadow-lg hover:-translate-y-0.5">
                    {{ __('Register Account') }}
                </button>
            </div>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Already registered? 
                <a href="{{ route('login') }}" class="font-semibold text-bgbr-blue hover:text-bgbr-gold transition-colors">Sign in here</a>
            </p>
        </div>
    </div>
</x-guest-layout>
