<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Barber;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Truncate tables.
         */
        DB::table('users')->truncate();
        DB::table('barbers')->truncate();

        /**
         * Create a specific user with admin role.
         */
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'federicogildemuro@gmail.com',
            'role' => 'admin',
        ]);

        /**
         * Create a specific user with user role.
         */
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'fgildemuro@hotmail.com',
        ]);

        /**
         * Create 10 random users with user role.
         */
        User::factory(10)->create();

        /**
         * Create 10 random barbers.
         */
        Barber::factory(10)->create();
    }
}
