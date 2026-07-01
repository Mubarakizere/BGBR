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

        // If a dynamic url is provided
        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
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

    /**
     * Fetch unread notifications for UI polling.
     */
    public function fetchUnread()
    {
        $notifications = Auth::user()->unreadNotifications()->latest()->take(10)->get();

        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count(),
            'notifications' => $notifications->map(function($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->data['title'] ?? 'New Notification',
                    'content_excerpt' => $notif->data['content_excerpt'] ?? '',
                    'created_at' => $notif->created_at->diffForHumans(),
                    'read_route' => route('notifications.read', $notif->id),
                ];
            })
        ]);
    }
}
