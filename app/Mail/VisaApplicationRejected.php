<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisaApplicationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $visaForm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($visaForm)
    {
        $this->visaForm = $visaForm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Afghanistan Online Visa Application Form result anouncement.');

        return $this->view('emails.visa-form-rejected', compact('visaForm'));
    }
}
