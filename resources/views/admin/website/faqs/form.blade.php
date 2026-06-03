<x-app-layout>
    <x-slot name="header">{{ isset($faq) ? 'Edit FAQ' : 'New FAQ' }}</x-slot>
    <div class="p-6"><div class="max-w-2xl">
        <a href="{{ route('admin.website.faqs.index') }}" class="inline-flex items-center gap-1 text-sm text-primary font-bold mb-6 hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg> Back</a>
        <div class="bg-surface rounded-2xl border border-border p-6">
            <form method="POST" action="{{ isset($faq) ? route('admin.website.faqs.update', $faq) : route('admin.website.faqs.store') }}">
                @csrf
                @if(isset($faq)) @method('PUT') @endif
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Question *</label><input type="text" name="question" value="{{ old('question', $faq->question ?? '') }}" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">@error('question')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                <div class="mb-4"><label class="block text-xs font-bold uppercase tracking-wide mb-1">Answer *</label><textarea name="answer" rows="6" required class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm">{{ old('answer', $faq->answer ?? '') }}</textarea>@error('answer')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror</div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Category</label><input type="text" name="category" value="{{ old('category', $faq->category ?? '') }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm" placeholder="e.g. General, Membership"></div>
                    <div><label class="block text-xs font-bold uppercase tracking-wide mb-1">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" class="w-full rounded-xl border-border focus:border-primary focus:ring-primary text-sm"></div>
                </div>
                <div class="mb-6"><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }} class="rounded border-border text-primary focus:ring-primary"><span class="text-sm font-semibold">Active</span></label></div>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">{{ isset($faq) ? 'Update' : 'Create FAQ' }}</button>
            </form>
        </div>
    </div></div>
</x-app-layout>
