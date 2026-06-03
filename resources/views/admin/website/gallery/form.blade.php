<x-app-layout>
    <x-slot name="header">{{ isset($image) ? 'Edit Image' : 'Upload Image' }}</x-slot>
    <div class="p-6"><div class="max-w-2xl">
        <a href="{{ route('admin.website.gallery.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back</a>
        <div class="bg-surface rounded-2xl border border-border p-6">
            <form method="POST" action="{{ isset($image) ? route('admin.website.gallery.update', $image) : route('admin.website.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($image)) @method('PUT') @endif
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wide mb-1">Image {{ isset($image) ? '(leave empty to keep current)' : '*' }}</label>
                    @if(isset($image))<img src="{{ asset('storage/' . $image->image_path) }}" class="w-32 h-32 object-cover rounded-xl mb-2">@endif
                    <input type="file" name="image" accept="image/*" class="w-full text-sm" {{ isset($image) ? '' : 'required' }}>
                    @error('image')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Title</label><input type="text" name="title" value="{{ old('title', $image->title ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                    <div x-data="{ 
                        mode: '{{ old('album', $image->album ?? '') && !in_array(old('album', $image->album ?? ''), ['Hero Slider', 'Events', 'Activities']) ? 'custom' : 'select' }}',
                        albumValue: '{{ old('album', $image->album ?? '') }}'
                    }">
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1">Album</label>
                        
                        <!-- Select Dropdown -->
                        <div x-show="mode === 'select'">
                            <select x-model="albumValue" x-on:change="if(albumValue === 'custom') { mode = 'custom'; albumValue = ''; $nextTick(() => $refs.customInput.focus()); }" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">
                                <option value="">General / None</option>
                                <option value="Hero Slider">Hero Slider (Homepage Hero)</option>
                                <option value="Events">Events</option>
                                <option value="Activities">Activities</option>
                                <option value="custom" class="font-bold text-primary">+ Create New Album...</option>
                            </select>
                        </div>
                        
                        <!-- Custom Input -->
                        <div x-show="mode === 'custom'">
                            <div class="flex gap-2">
                                <input x-ref="customInput" type="text" x-model="albumValue" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm" placeholder="Type new album name...">
                                <button type="button" x-on:click="mode = 'select'; albumValue = ''" class="px-3 bg-background border border-border rounded-xl text-sm hover:bg-border transition" title="Cancel">✕</button>
                            </div>
                        </div>

                        <!-- Hidden actual input to submit -->
                        <input type="hidden" name="album" x-bind:value="albumValue">
                    </div>
                </div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Caption</label><input type="text" name="caption" value="{{ old('caption', $image->caption ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm" maxlength="500"></div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $image->sort_order ?? 0) }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                    <div class="flex items-end"><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $image->is_active ?? true) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary"><span class="text-sm font-semibold">Active</span></label></div>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">{{ isset($image) ? 'Update' : 'Upload Image' }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
