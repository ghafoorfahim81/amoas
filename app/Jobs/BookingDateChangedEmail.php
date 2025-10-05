<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BookingDateChangedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $booking;

    public $oldBooking;

    public $authUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking, $oldBooking, $authUser)
    {
        $this->booking = $booking;
        $this->oldBooking = $oldBooking;
        $this->authUser = $authUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->booking->email ?? $this->booking->info->email ?? $this->booking->user->email;
        //        $sender    = env('MAIL_USERNAME');

        \Mail::to($email)->send(new \App\Mail\BookingDateChanged($this->booking, $this->oldBooking, $this->authUser));
    }
}
