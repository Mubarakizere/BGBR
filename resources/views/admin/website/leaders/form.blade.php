<x-app-layout>
    <x-slot name="header">{{ isset($leader) ? 'Edit Leader' : 'Add Leader' }}</x-slot>
    <div class="p-6"><div class="max-w-2xl">
        <a href="{{ route('admin.website.leaders.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back</a>
        <div class="bg-surface rounded-2xl border border-border p-6">
            <form method="POST" action="{{ isset($leader) ? route('admin.website.leaders.update', $leader) : route('admin.website.leaders.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($leader)) @method('PUT') @endif
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Name *</label><input type="text" name="name" value="{{ old('name', $leader->name ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">@error('name')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Title/Position *</label><input type="text" name="title" value="{{ old('title', $leader->title ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">@error('title')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                </div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Bio</label><textarea name="bio" rows="4" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">{{ old('bio', $leader->bio ?? '') }}</textarea></div>
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wide mb-1">Photo</label>
                    @if(isset($leader) && $leader->photo_path)<img src="{{ asset('storage/' . $leader->photo_path) }}" class="w-20 h-20 object-cover rounded-xl mb-2">@endif
                    <input type="file" name="photo" accept="image/*" class="w-full text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $leader->sort_order ?? 0) }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                    <div class="flex items-end"><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $leader->is_active ?? true) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary"><span class="text-sm font-semibold">Active</span></label></div>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">{{ isset($leader) ? 'Update' : 'Add Leader' }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
