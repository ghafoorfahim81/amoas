<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostalPackageStatusChanged implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->postal->email;
        $sender = env('MAIL_USERNAME');

        if (in_array($this->postal->status, ['Label Created', 'Shipped', 'Delivered', 'Returned', 'Data Entry', 'Waiting'])) {
            \Mail::to($email)->send(new \App\Mail\PostalPackageStatusChanged($this->postal));
        }
    }
}
