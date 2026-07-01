<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserPendingApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $newUser)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New User Pending Approval: ' . $this->newUser->name)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new user has registered and is awaiting your approval.')
                    ->line('Name: ' . $this->newUser->name)
                    ->line('Email: ' . $this->newUser->email)
                    ->action('Review User', route('users.pending'))
                    ->line('Please review their account details.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New User Registered',
            'content_excerpt' => $this->newUser->name . ' is awaiting approval.',
            'url' => route('users.pending'),
        ];
    }
}
