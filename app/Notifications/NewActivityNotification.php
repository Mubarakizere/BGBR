<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public \App\Models\Activity $activity)
    {
        //
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
        $mail = (new MailMessage)
            ->subject('New Activity: ' . $this->activity->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new activity has been published:')
            ->line('**' . $this->activity->title . '**');

        if ($this->activity->date) {
            $mail->line('📅 Date: ' . $this->activity->date->format('F d, Y'));
        }

        if ($this->activity->location) {
            $mail->line('📍 Location: ' . $this->activity->location);
        }

        if ($this->activity->participation_fee > 0) {
            $mail->line('💰 Participation Fee: ' . number_format($this->activity->participation_fee, 0) . ' RWF');
        }

        if ($this->activity->description) {
            $mail->line(\Illuminate\Support\Str::limit(strip_tags($this->activity->description), 150));
        }

        $mail->action('View Activity', route('activities.show', $this->activity));

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'activity_id' => $this->activity->id,
            'title' => $this->activity->title,
            'date' => $this->activity->date?->format('M d, Y'),
            'target_audience' => $this->activity->target_audience,
        ];
    }
}
