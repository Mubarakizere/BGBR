<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteFaq;
use Illuminate\Http\Request;

class SiteFaqController extends Controller
{
    public function index()
    {
        $faqs = SiteFaq::ordered()->get();
        return view('admin.website.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.website.faqs.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        SiteFaq::create($validated);

        return redirect()->route('admin.website.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function edit(SiteFaq $faq)
    {
        return view('admin.website.faqs.form', compact('faq'));
    }

    public function update(Request $request, SiteFaq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.website.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroy(SiteFaq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.website.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }
}
