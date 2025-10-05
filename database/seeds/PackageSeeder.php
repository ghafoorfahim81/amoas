<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define common defaults for required, non-nullable columns
        // NOTE: These IDs (1, 1) MUST exist in the 'categories' and 'photos' tables, respectively.
        $default_package_data = [
            'category_id' => 1, 
            'daily_acceptance' => 10,
            'emergency_acceptance' => 5,
            'photo_id' => 1, 
            'duration' => 30, // Example duration in days/minutes/etc.
            'description' => 'A basic service package.',
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        // Ensure all required columns from the migration are present and correct!
        DB::table('packages')->insert([
            array_merge($default_package_data, [
                'id' => 1, 
                'title' => 'Standard Package', // Changed from 'name' to 'title'
                'price' => 50.00, 
            ]),
            array_merge($default_package_data, [
                'id' => 2, 
                'title' => 'Premium Package', // Changed from 'name' to 'title'
                'price' => 100.00, 
            ]),
            array_merge($default_package_data, [
                'id' => 3, 
                'title' => 'Express Package', // Changed from 'name' to 'title'
                'price' => 150.00, 
            ]),
        ]);
    }
}