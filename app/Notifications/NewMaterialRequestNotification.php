<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MaterialsRequest;

class NewMaterialRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public MaterialsRequest $materialRequest)
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
                    ->subject('New Material Request: ' . $this->materialRequest->company->name)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new material request has been submitted by ' . $this->materialRequest->company->name . '.')
                    ->line('Total items requested: ' . $this->materialRequest->items->count())
                    ->action('View Request', route('materials-requests.show', $this->materialRequest))
                    ->line('Please review and process the request.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Material Request',
            'content_excerpt' => 'From ' . $this->materialRequest->company->name,
            'url' => route('materials-requests.show', $this->materialRequest),
        ];
    }
}
