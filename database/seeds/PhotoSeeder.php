<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photos')->insert([
            [
                'id' => 1, 
                'file' => 'placeholder.jpg', // Assuming a mandatory 'file' column
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}