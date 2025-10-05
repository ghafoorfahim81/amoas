<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingDateChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public $oldBooking;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $oldBooking, $user)
    {
        $this->booking = $booking;
        $this->oldBooking = $oldBooking;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Your appointment date has been changed in '.$this->booking->department->name_en);

        return $this->view('emails.booking-date-changed');
    }
}
