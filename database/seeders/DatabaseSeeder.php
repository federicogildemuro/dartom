<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Barber;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate tables.       
        DB::table('users')->truncate();
        DB::table('barbers')->truncate();
        DB::table('appointments')->truncate();
        // Enable foreign key checks.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create a specific user with admin role.
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
        ]);

        // Create 50 random users.
        User::factory(50)->create();

        // Create 5 random barbers.
        Barber::factory(5)->create();

        // Create 100 random appointments.
        Appointment::factory(100)->create();
    }
}
