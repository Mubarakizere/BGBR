<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Announcement;

class AnnouncementPendingApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Announcement $announcement)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Announcement Pending Approval: ' . $this->announcement->title)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new announcement has been created by ' . $this->announcement->creator->name . ' and requires your approval.')
                    ->line('Title: ' . $this->announcement->title)
                    ->action('Review Announcement', route('announcements.show', $this->announcement))
                    ->line('Please review and approve this announcement to publish it.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Announcement Requires Approval',
            'content_excerpt' => $this->announcement->title . ' was created by ' . $this->announcement->creator->name,
            'url' => route('announcements.show', $this->announcement),
        ];
    }
}
