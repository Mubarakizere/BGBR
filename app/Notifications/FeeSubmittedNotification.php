<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RegistrationFee;

class FeeSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public RegistrationFee $fee)
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
                    ->subject('Registration Fee Submitted: ' . $this->fee->user->name)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new registration fee payment has been submitted by ' . $this->fee->user->name . '.')
                    ->line('Amount: ' . number_format($this->fee->amount) . ' RWF')
                    ->action('Review Payment', route('admin.fees.index'))
                    ->line('Please review and approve or reject the payment.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Fee Payment Submitted',
            'content_excerpt' => $this->fee->user->name . ' submitted ' . number_format($this->fee->amount) . ' RWF',
            'url' => route('admin.fees.index'),
        ];
    }
}
