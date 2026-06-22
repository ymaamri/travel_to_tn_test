<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // IMPORTANT: Seeders run in this order to respect foreign keys
        $this->call([
            UserSeeder::class,           // First: users (agencies, admin, tourists)
            TripSeeder::class,           // Trips depend on users
            DestinationSeeder::class,    // Destinations (admin as creator)
            BlogSeeder::class,           // Blog posts (admin as author)
            ActivitySeeder::class,       // Activities (admin as creator)
            EstablishmentSeeder::class,  // Hotels & restaurants (admin as creator)
            TransportInfoSeeder::class,  // Transportation guides (already exists)
            ReviewSeeder::class,         // Reviews (depend on all previous models)
        ]);
    }
}