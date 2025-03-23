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
            'email' => 'federicogildemuro@gmail.com',
            'role' => 'admin',
        ]);

        // Create a specific user with user role.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'fgildemuro@hotmail.com',
        ]);

        // Create 50 random users.
        User::factory(50)->create();

        // Create 2 random barbers.
        Barber::factory(2)->create();

        // Create 100 random appointments.
        Appointment::factory(100)->create();
    }
}
