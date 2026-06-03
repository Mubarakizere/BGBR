<x-app-layout>
    <x-slot name="header">{{ isset($page) ? 'Edit Page Section' : 'New Page Section' }}</x-slot>
    <div class="p-6">
        <div class="max-w-3xl">
            <a href="{{ route('admin.website.pages.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back to Pages
            </a>
            <div class="bg-surface rounded-2xl border border-border p-6">
                <form method="POST" action="{{ isset($page) ? route('admin.website.pages.update', $page) : route('admin.website.pages.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($page)) @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-text uppercase tracking-wide mb-1">Slug *</label>
                            <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm" placeholder="e.g. hero, mission, about">
                            @error('slug') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text uppercase tracking-wide mb-1">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">
                            @error('title') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-text uppercase tracking-wide mb-1">Content</label>
                        <textarea name="content" rows="8" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">{{ old('content', $page->content ?? '') }}</textarea>
                        @error('content') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-text uppercase tracking-wide mb-1">Meta Description</label>
                        <input type="text" name="meta_description" value="{{ old('meta_description', $page->meta_description ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm" maxlength="255">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-text uppercase tracking-wide mb-1">Image</label>
                        @if(isset($page) && $page->image_path)
                            <img src="{{ asset('storage/' . $page->image_path) }}" class="w-32 h-20 object-cover rounded-lg mb-2">
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-text uppercase tracking-wide mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order ?? 0) }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary">
                                <span class="text-sm font-semibold text-text">Active</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm">
                        {{ isset($page) ? 'Update Section' : 'Create Section' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
