<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div class="flex items-center gap-6" x-data="{ photoName: null, photoPreview: null }">
            <div class="relative shrink-0">
                <!-- Current Profile Photo / Fallback -->
                <template x-if="!photoPreview">
                    @if($user->photo_path)
                        <img src="{{ asset('storage/' . $user->photo_path) }}" alt="{{ $user->name }}" class="h-20 w-20 rounded-2xl object-cover ring-4 ring-primary/10 shadow-md">
                    @else
                        <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-secondary/80 to-secondary flex items-center justify-center text-[#0F1847] font-black text-2xl shadow-md ring-4 ring-primary/10">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </template>
                
                <!-- New Photo Preview -->
                <template x-if="photoPreview">
                    <img :src="photoPreview" alt="Profile photo preview" class="h-20 w-20 rounded-2xl object-cover ring-4 ring-primary/20 shadow-md">
                </template>
            </div>

            <div>
                <x-input-label for="photo" :value="__('Profile Picture')" class="mb-1 text-sm font-bold text-text" />
                
                <input type="file" id="photo" name="photo" class="hidden" x-ref="photo"
                       @change="
                           const file = $event.target.files[0];
                           if (file) {
                               photoName = file.name;
                               const reader = new FileReader();
                               reader.onload = (e) => {
                                   photoPreview = e.target.result;
                               };
                               reader.readAsDataURL(file);
                           }
                       ">

                <button type="button" @click="$refs.photo.click()" 
                        class="bg-background hover:bg-surface text-text font-semibold py-2.5 px-4 border border-border rounded-xl shadow-sm text-sm hover:border-primary/30 transition-all">
                    {{ __('Choose Image') }}
                </button>
                
                <span x-show="photoName" class="text-xs text-muted ml-3 truncate max-w-[200px]" x-text="photoName" style="display: none;"></span>
                <p class="mt-2 text-xs text-muted">Supports PNG, JPG or JPEG. Max size 2MB.</p>
                <x-input-error class="mt-1" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
