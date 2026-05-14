<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Member') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('members.index') }}" class="w-10 h-10 rounded-xl bg-surface border border-border flex items-center justify-center text-muted hover:text-primary hover:border-primary/30 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold text-text tracking-tight">Edit Member</h1>
                    <p class="text-sm text-muted mt-0.5">Editing profile for <span class="font-semibold text-primary">{{ $member->name }}</span></p>
                </div>
            </div>

            {{-- Form Card --}}
            <form method="POST" action="{{ route('members.update', $member) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Personal Information --}}
                <div class="bg-surface rounded-2xl border border-border shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-text">Personal Information</h3>
                            <p class="text-xs text-muted">Basic identity details of the member</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-text mb-1.5">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Enter full name">
                            @error('name') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="rank" class="block text-sm font-semibold text-text mb-1.5">Rank <span class="text-danger">*</span></label>
                            <input type="text" name="rank" id="rank" value="{{ old('rank', $member->rank) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="e.g. Sergeant, Captain">
                            @error('rank') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Assignment & Details --}}
                <div class="bg-surface rounded-2xl border border-border shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-lg bg-success/10 flex items-center justify-center text-success">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-text">Assignment & Details</h3>
                            <p class="text-xs text-muted">Company assignment and service information</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="company_id" class="block text-sm font-semibold text-text mb-1.5">Company <span class="text-danger">*</span></label>
                            <select id="company_id" name="company_id" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                <option value="" disabled>Select a Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $member->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tenure" class="block text-sm font-semibold text-text mb-1.5">Tenure (Years)</label>
                            <input type="number" name="tenure" id="tenure" value="{{ old('tenure', $member->tenure) }}" min="0"
                                   class="w-full px-4 py-2.5 rounded-xl border border-border bg-background text-text text-sm placeholder:text-muted/50 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="0">
                            @error('tenure') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Additional Information --}}
                <div class="bg-surface rounded-2xl border border-border shadow-sm p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-text">Additional Information</h3>
                            <p class="text-xs text-muted">Photo upload and payment status</p>
                        </div>
                    </div>

                    {{-- Current Photo + Upload --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-text mb-2">Profile Photo</label>

                        @if($member->photo_path)
                            <div class="flex items-center gap-4 mb-4 p-3 bg-background rounded-xl border border-border">
                                <img src="{{ asset('storage/' . $member->photo_path) }}" alt="Current Photo" class="w-16 h-16 rounded-xl object-cover ring-2 ring-border">
                                <div>
                                    <p class="text-sm font-medium text-text">Current Photo</p>
                                    <p class="text-xs text-muted">Upload a new file below to replace it</p>
                                </div>
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-border rounded-xl p-8 text-center hover:border-primary/40 hover:bg-primary/[0.02] transition-all cursor-pointer" onclick="document.getElementById('photo').click()">
                            <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-semibold text-primary mb-1">Click to upload a new photo</p>
                            <p class="text-xs text-muted">PNG, JPG, JPEG up to 2MB</p>
                            <input id="photo" name="photo" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg">
                        </div>
                        @error('photo') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                    </div>

                    {{-- Registration Fee Checkbox --}}
                    <div class="bg-background rounded-xl border border-border p-4 flex items-start gap-3">
                        <div class="flex items-center h-5 pt-0.5">
                            <input id="registration_fee_paid" name="registration_fee_paid" type="checkbox" value="1" {{ old('registration_fee_paid', $member->registration_fee_paid) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-border rounded focus:ring-primary/30 focus:ring-2 transition">
                        </div>
                        <div>
                            <label for="registration_fee_paid" class="text-sm font-semibold text-text cursor-pointer">Registration Fee Paid</label>
                            <p class="text-xs text-muted mt-0.5">Mark this member as having paid their initial registration fee.</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('members.index') }}"
                       class="px-5 py-2.5 rounded-xl border border-border bg-surface text-sm font-semibold text-muted hover:text-text hover:border-text/20 transition-all shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-bold shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-200">
                        Update Member
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
