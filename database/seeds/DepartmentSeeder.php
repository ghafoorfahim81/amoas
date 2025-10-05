<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define common defaults
        $default_department_data = [
            'parent_id' => 0, // Assuming 0 means root/no parent
            'code' => 'DEFAULT_CODE',
            'user_id' => 1564, // Use the Admin ID created in UserManagementSeeder
            'created_at' => now(), 
            'updated_at' => now()
        ];
        
        // Ensure all required, non-nullable columns from the migration are present!
        DB::table('departments')->insert([
            array_merge($default_department_data, [
                'id' => 1, 
                'name_en' => 'General Services', 
            ]),
            array_merge($default_department_data, [
                'id' => 2, 
                'name_en' => 'Visa Processing', 
            ]),
            array_merge($default_department_data, [
                // This is the ID required by your Booking Factory
                'id' => 96, 
                'name_en' => 'Default Booking Dept', 
            ]),
        ]);
    }
}