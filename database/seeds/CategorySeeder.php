<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserting data into the 'categories' table.
        // NOTE: Column 'name' is replaced with 'title'.
        // NOTE: Mandatory column 'photo_id' is included.
        DB::table('categories')->insert([
            [
                'id' => 1, 
                'title' => 'Default Category', // Changed from 'name' to 'title'
                'photo_id' => 1, // Mandatory non-nullable column
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}