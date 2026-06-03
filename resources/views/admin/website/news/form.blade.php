<x-app-layout>
    <x-slot name="header">{{ isset($article) ? 'Edit Article' : 'New Article' }}</x-slot>
    <div class="p-6"><div class="max-w-3xl">
        <a href="{{ route('admin.website.news.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back</a>
        <div class="bg-surface rounded-2xl border border-border p-6">
            <form method="POST" action="{{ isset($article) ? route('admin.website.news.update', $article) : route('admin.website.news.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($article)) @method('PUT') @endif
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Title *</label><input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">@error('title')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Slug (auto-generated if empty)</label><input type="text" name="slug" value="{{ old('slug', $article->slug ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm font-mono" placeholder="auto-generated-from-title"></div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Excerpt</label><input type="text" name="excerpt" value="{{ old('excerpt', $article->excerpt ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm" maxlength="500" placeholder="Short summary..."></div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Content *</label><textarea name="content" rows="12" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">{{ old('content', $article->content ?? '') }}</textarea>@error('content')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Author Name</label><input type="text" name="author_name" value="{{ old('author_name', $article->author_name ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide mb-1">Featured Image</label>
                        @if(isset($article) && $article->image_path)<img src="{{ asset('storage/' . $article->image_path) }}" class="w-24 h-16 object-cover rounded-lg mb-2">@endif
                        <input type="file" name="image" accept="image/*" class="w-full text-sm">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_published" value="0"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary"><span class="text-sm font-semibold">Publish (visible on public website)</span></label>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">{{ isset($article) ? 'Update' : 'Create Article' }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
