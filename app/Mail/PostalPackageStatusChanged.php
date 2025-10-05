<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostalPackageStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $postal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postal)
    {
        $this->postal = $postal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        switch ($this->postal->status) {
            case 'Label Created':
                $this->subject('Your postal package has been registered in our system.');

                return $this->view('emails.postal-package.label-created');
                break;

            case 'Shipped':
                $this->subject('Your documents have been issued.');

                return $this->view('emails.postal-package.shipped');
                break;

            case 'Delivered':
                $this->subject('Your documents successfully sent to your address.');

                return $this->view('emails.postal-package.delivered');
                break;

            case 'Returned':
                $this->subject('Your documents have been returned to this mission due to incorrect address.');

                return $this->view('emails.postal-package.returned');
                break;

            case 'Data Entry':
                $this->subject('Your Passport Application Form was registered in the passport system.');

                return $this->view('emails.postal-package.data-entry');
                break;

            case 'Waiting':
                $this->subject('Your application cannot be processed due to missing documents.');

                return $this->view('emails.postal-package.waiting');
                break;

            default:
                return;
                break;
        }
    }
}
