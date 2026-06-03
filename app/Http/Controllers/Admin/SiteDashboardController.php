<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContact;
use App\Models\SiteEvent;
use App\Models\SiteFaq;
use App\Models\SiteGalleryImage;
use App\Models\SiteLeader;
use App\Models\SiteNews;
use App\Models\SitePage;

class SiteDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => SitePage::count(),
            'leaders' => SiteLeader::count(),
            'events' => SiteEvent::count(),
            'news' => SiteNews::count(),
            'gallery' => SiteGalleryImage::count(),
            'faqs' => SiteFaq::count(),
            'unread_contacts' => SiteContact::unread()->count(),
            'total_contacts' => SiteContact::count(),
        ];

        $recentContacts = SiteContact::latest()->take(5)->get();

        return view('admin.website.dashboard', compact('stats', 'recentContacts'));
    }
}
