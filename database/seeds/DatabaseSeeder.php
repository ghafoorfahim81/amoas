<?php

use Illuminate\Database\Seeder;
use Database\Seeders\UserManagementSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PhotoSeeder;    // <-- NEW IMPORT
use Database\Seeders\CategorySeeder; 
use Database\Seeders\PackageSeeder;    
use App\Booking; 
use App\Models\Booking\BookingInfo; 

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Core Users
        $this->call(UserManagementSeeder::class); 
        $this->call(RolePermissionSeeder::class);
        
        // 2. Dependency Seeders (ORDERED by dependency: Photos -> Categories -> Departments/Packages)
        $this->call(PhotoSeeder::class);      // <-- NEW CALL (Must run first)
        $this->call(DepartmentSeeder::class); 
        $this->call(CategorySeeder::class); 
        $this->call(PackageSeeder::class);    
        
        // 3. Original Factory Logic (Bookings)
        // $this->call(booking_times_seeder::class);
        
        Booking::factory(100)->create()->each(function ($booking) {
            $booking->info()->save(BookingInfo::factory()->create(['booking_id' => $booking->id]));
        });
    }
}