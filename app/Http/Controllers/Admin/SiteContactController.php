<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContact;

class SiteContactController extends Controller
{
    public function index()
    {
        $contacts = SiteContact::orderByDesc('created_at')->paginate(20);
        $unreadCount = SiteContact::unread()->count();
        return view('admin.website.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function show(SiteContact $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        return view('admin.website.contacts.show', compact('contact'));
    }

    public function markRead(SiteContact $contact)
    {
        $contact->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function destroy(SiteContact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.website.contacts.index')
            ->with('success', 'Message deleted successfully.');
    }
}
