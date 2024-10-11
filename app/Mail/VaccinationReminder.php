<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VaccinationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $vaccinationDate;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $vaccinationDate)
    {
        $this->user = $user;
        $this->vaccinationDate = $vaccinationDate;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Upcoming Vaccination Reminder')
            ->markdown('emails.vaccination.reminder');
    }
}
