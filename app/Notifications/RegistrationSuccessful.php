<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationSuccessful extends Notification
{
    use Queueable;

    protected $scheduleDate;
    protected $vaccineCenter;

    /**
     * Create a new notification instance.
     */
    public function __construct($scheduleDate, $vaccineCenter)
    {
        $this->scheduleDate = $scheduleDate;
        $this->vaccineCenter = $vaccineCenter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vaccination Registration Successful')
            ->greeting("Hello {$notifiable->name},")
            ->line('Thank you for registering for vaccination.')
            ->line('Your vaccination is scheduled on ' . $this->scheduleDate->toFormattedDateString() . '.')
            ->line("Vaccine Center: {$this->vaccineCenter}")
            ->line('Please arrive 15 minutes before your scheduled time.')
            ->salutation('Stay Safe!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
