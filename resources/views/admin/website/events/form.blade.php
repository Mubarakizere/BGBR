<x-app-layout>
    <x-slot name="header">{{ isset($event) ? 'Edit Event' : 'New Event' }}</x-slot>
    <div class="p-6"><div class="max-w-2xl">
        <a href="{{ route('admin.website.events.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back</a>
        <div class="bg-surface rounded-2xl border border-border p-6">
            <form method="POST" action="{{ isset($event) ? route('admin.website.events.update', $event) : route('admin.website.events.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($event)) @method('PUT') @endif
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Title *</label><input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">@error('title')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Description</label><textarea name="description" rows="4" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">{{ old('description', $event->description ?? '') }}</textarea></div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Event Date *</label><input type="date" name="event_date" value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d') : '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">End Date</label><input type="date" name="end_date" value="{{ old('end_date', isset($event) && $event->end_date ? $event->end_date->format('Y-m-d') : '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                </div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Location</label><input type="text" name="location" value="{{ old('location', $event->location ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wide mb-1">Image</label>
                    @if(isset($event) && $event->image_path)<img src="{{ asset('storage/' . $event->image_path) }}" class="w-32 h-20 object-cover rounded-lg mb-2">@endif
                    <input type="file" name="image" accept="image/*" class="w-full text-sm">
                </div>
                <div class="flex gap-6 mb-6">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_featured" value="0"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary"><span class="text-sm font-semibold">Featured</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active ?? true) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary"><span class="text-sm font-semibold">Active</span></label>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">{{ isset($event) ? 'Update' : 'Create Event' }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
