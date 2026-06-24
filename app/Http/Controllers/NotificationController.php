<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a specific notification as read and redirect to the announcement.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // If the notification has an announcement_id, redirect there
        if (isset($notification->data['announcement_id'])) {
            return redirect()->route('announcements.show', $notification->data['announcement_id']);
        }

        // If the notification has an activity_id, redirect there
        if (isset($notification->data['activity_id'])) {
            return redirect()->route('activities.show', $notification->data['activity_id']);
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
