<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use App\Models\SiteContact;
use App\Models\SiteEvent;
use App\Models\SiteFaq;
use App\Models\SiteGalleryImage;
use App\Models\SiteLeader;
use App\Models\SiteNews;
use App\Models\SitePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicSiteController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        $hero = SitePage::getBySlug('hero');
        $mission = SitePage::getBySlug('mission');
        $featuredEvents = SiteEvent::active()->upcoming()->orderBy('event_date')->take(3)->get();
        $latestNews = SiteNews::published()->latest()->take(3)->get();
        $heroImages = SiteGalleryImage::active()->where('album', 'Hero Slider')->ordered()->get();

        return view('public.home', compact('hero', 'mission', 'featuredEvents', 'latestNews', 'heroImages'));
    }

    /**
     * About Us
     */
    public function about()
    {
        $about = SitePage::getBySlug('about');
        $mission = SitePage::getBySlug('mission');
        $vision = SitePage::getBySlug('vision');
        $history = SitePage::getBySlug('history');
        $values = SitePage::getBySlug('core-values');

        return view('public.about', compact('about', 'mission', 'vision', 'history', 'values'));
    }

    /**
     * Leadership Team
     */
    public function leadership()
    {
        $leaders = SiteLeader::active()->ordered()->get();

        return view('public.leadership', compact('leaders'));
    }

    /**
     * Events
     */
    public function events()
    {
        $upcoming = SiteEvent::active()->upcoming()->orderBy('event_date')->get();
        $past = SiteEvent::active()->past()->orderByDesc('event_date')->take(6)->get();

        return view('public.events', compact('upcoming', 'past'));
    }

    /**
     * News Index
     */
    public function news()
    {
        $articles = SiteNews::published()->latest()->paginate(9);

        return view('public.news.index', compact('articles'));
    }

    /**
     * News Article Detail
     */
    public function newsShow(string $slug)
    {
        $article = SiteNews::where('slug', $slug)->published()->firstOrFail();
        $related = SiteNews::published()
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.news.show', compact('article', 'related'));
    }

    /**
     * Gallery
     */
    public function gallery()
    {
        $images = SiteGalleryImage::active()->ordered()->get();
        $albums = $images->pluck('album')->filter()->unique()->values();

        return view('public.gallery', compact('images', 'albums'));
    }

    /**
     * Contact Page
     */
    public function contact()
    {
        $contactInfo = SitePage::getBySlug('contact-info');

        return view('public.contact', compact('contactInfo'));
    }

    /**
     * Contact Form Submission
     */
    public function contactSubmit(Request $request)
    {
        // Honeypot check — if the hidden field is filled, it's a bot
        if ($request->filled('website_url')) {
            return redirect()->route('site.contact')
                ->with('success', 'Thank you for your message! We will get back to you soon.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = SiteContact::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        // Send email to staff
        try {
            Mail::to(config('site.contact_email'), config('site.contact_name'))
                ->send(new ContactFormSubmission($contact));
        } catch (\Exception $e) {
            // Log error but don't fail the submission
            \Log::error('Contact form email failed: ' . $e->getMessage());
        }

        return redirect()->route('site.contact')
            ->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Donate — Coming Soon
     */
    public function donate()
    {
        return view('public.donate');
    }

    /**
     * FAQ
     */
    public function faq()
    {
        $faqs = SiteFaq::active()->ordered()->get();
        $categories = $faqs->pluck('category')->filter()->unique()->values();

        return view('public.faq', compact('faqs', 'categories'));
    }
}
