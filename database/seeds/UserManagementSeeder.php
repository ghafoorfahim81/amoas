<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User; 
use Spatie\Permission\Models\Role; 

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Default Roles (If using Spatie Permission)
        // Check if the roles table exists to avoid errors if the migration failed
        if (DB::getSchemaBuilder()->hasTable('roles')) {
            $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
            $userRole  = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);
            $guestRole = Role::firstOrCreate(['name' => 'Guest', 'guard_name' => 'web']);
            
            // Note: Since you have 'role_id' in your users table,
            // we will primarily use the role_id column for the App\Models\User
            // and sync the Spatie roles for permission checks.
        }

        // 2. Create Default Admin User
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@amoas.com'
            ],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'phone_number' => '555-1234',
                'password' => Hash::make('password'), // You can change this to a stronger password later!
                'role_id' => 1, // Assuming role_id 1 is 'Admin' based on common conventions
                'postal_code' => 10001,
                'is_active' => 1,
                'email_verified_at' => now(),
                'remember_token' => \Illuminate\Support\Str::random(10),
            ]
        );

        // 3. Assign Spatie Role (if Spatie is used)
        if (isset($adminRole)) {
            $admin->assignRole($adminRole);
        }

        $this->command->info('Default Admin User created: admin@amoas.com / password');


        // 4. Create a regular User
        $user = User::firstOrCreate(
            [
                'email' => 'user@amoas.com'
            ],
            [
                'first_name' => 'Regular',
                'last_name' => 'User',
                'phone_number' => '555-5678',
                'password' => Hash::make('password'),
                'role_id' => 2, // Assuming role_id 2 is 'User'
                'postal_code' => 10002,
                'is_active' => 1,
                'email_verified_at' => now(),
                'remember_token' => \Illuminate\Support\Str::random(10),
            ]
        );

        // 5. Assign Spatie Role (if Spatie is used)
        if (isset($userRole)) {
            $user->assignRole($userRole);
        }

        $this->command->info('Default Regular User created: user@amoas.com / password');
    }
}
