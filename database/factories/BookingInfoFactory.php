<?php

namespace Database\Factories;

use App\Models\Booking\BookingInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookingInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // CORRECTED: Using 'full_name' instead of 'first_name' and 'last_name'
            'full_name' => $this->faker->name,
            
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'id_card' => $this->faker->unique()->numerify('##########'), 
            
            'postal' => $this->faker->postcode, 
            'address' => $this->faker->streetAddress,
            
            // Your migration doesn't explicitly show 'city' and 'state', but your BookingInfo model
            // has them in $fillable, so we must assume the columns were added by other migrations
            // (like 2024_09_07_105332_add_city_and_state_to_booking_info_table, which ran successfully).
            'city' => $this->faker->city, 
            'state' => $this->faker->state,
            
            // Removing 'country' as it is not present in your BookingInfo model's $fillable array
        ];
    }
}
