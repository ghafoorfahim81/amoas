<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostalPackageRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $postal;

    public $rejectedReason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postal, $rejectedReason)
    {
        $this->postal = $postal;
        $this->rejectedReason = $rejectedReason;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Your document has been rejected.');

        return $this->view('emails.postal-package-rejected');
    }
}
