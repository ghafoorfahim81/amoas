<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $booking = \App\Booking::find(101);
        // $booking->load(['user', 'info', 'package', 'department']);

        // \App\Jobs\FinalizeNewBooking::dispatch($booking);

        $visaForm = \App\Models\Visa\VisaForm::find(1);
        $visaForm->load(['department']);

        \App\Jobs\FinalizeVisaFormRegistration::dispatch($visaForm);
    }
}
