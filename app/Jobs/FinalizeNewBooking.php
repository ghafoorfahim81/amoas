<?php

namespace App\Jobs;

use App\Mail\NewTimeBooked;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FinalizeNewBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if (! $this->booking->user && ! isset($this->booking->email) && (! isset($this->booking->info) && ! isset($this->booking->info->email))) {
            return 'No email provided.';
        }

        $email = $this->booking->email ?? $this->booking->info->email ?? $this->booking->user->email;

        $pdfContent = (new \App\Services\PDFService)->generateBookingConfirmationPdf($this->booking);
        $pdfName = "booking-confirmation-{$this->booking->serial_no}.pdf";

        $emailTemplate = new NewTimeBooked($this->booking);
        $emailTemplate->attachData($pdfContent, $pdfName, [
            'mime' => 'application/pdf',
        ]);

        \Mail::to($email)->send($emailTemplate);
    }
}
