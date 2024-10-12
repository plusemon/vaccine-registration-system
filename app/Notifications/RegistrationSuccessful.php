<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegistrationSuccessful extends Notification
{
    use Queueable;



    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
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
            ->line('Your vaccination is scheduled on ' . $this->user->scheduled_at->format('D, d M Y h:i A') . '.')
            ->line("Vaccine Center: {$this->user->vaccineCenter->name}.")
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
