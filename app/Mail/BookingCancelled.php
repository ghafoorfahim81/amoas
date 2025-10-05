<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $user)
    {
        $this->booking = $booking;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Your appointment has been cancelled at '.$this->booking->department->name_en);

        if ($this->user == 'admin') {
            return $this->view('emails.booking-cancelled-by-admin');
        }

        return $this->view('emails.booking-cancelled');
    }
}
