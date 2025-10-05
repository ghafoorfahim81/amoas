<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisaRegisterationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $visaForm;

    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($visaForm, $name = null)
    {
        $this->visaForm = $visaForm;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('You have successfully submitted Visa Application Form at '.$this->visaForm->department->name_en);

        return $this->view('emails.new-visa-form-submitted-email');

    }
}
