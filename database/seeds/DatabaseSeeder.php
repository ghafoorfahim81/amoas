<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(booking_times_seeder::class);
        factory(App\Booking::class, 100)->create()->each(function ($booking) {
            $booking->info()->save(factory(App\Models\Booking\BookingInfo::class)->create(['booking_id' => $booking->id]));
        });
    }
}
