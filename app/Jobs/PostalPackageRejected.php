<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostalPackageRejected implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $postal;

    public $rejectedReason;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($postal, $rejectedReason)
    {
        $this->postal = $postal;
        $this->rejectedReason = $rejectedReason;
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

        \Mail::to($email)->send(new \App\Mail\PostalPackageRejected($this->postal, $this->rejectedReason));
    }
}
