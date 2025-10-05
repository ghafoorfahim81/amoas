<?php

namespace Database\Factories;

use App\Booking; // Make sure this is the correct namespace for your Booking model
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'department_id' => 96,
            'serial_no' => 'CBONN-1234421-2134',
            'user_id' => 1565,
            'package_id' => $this->faker->randomElement([1, 2, 3]),
            'booking_date' => $this->faker->dateTimeBetween('2019-11-02', '2019-11-30'),
            'booking_time' => $this->faker->randomElement(['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM']),
            'google_calendar_event_id' => 1,
            'status' => 'On Process',
        ];
    }
}