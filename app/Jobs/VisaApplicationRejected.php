<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SMTPValidateEmail\Validator as SmtpEmailValidator;

class VisaApplicationRejected implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $visaForm;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($visaForm)
    {
        $this->visaForm = $visaForm;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->visaForm->email;
        $sender = env('MAIL_USERNAME');
        // $validator = new SmtpEmailValidator($email, $sender);

        // If debug mode is turned on, logged data is printed as it happens:
        // $results   = $validator->validate();

        // if (!array_key_exists($email, $results) || $results[$email] == false)
        // return 'The email provided was not a real email.';

        \Mail::to($email)->send(new \App\Mail\VisaApplicationRejected($this->visaForm));
    }
}
