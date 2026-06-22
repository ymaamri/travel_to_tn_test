<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Ahmed Ben Ali',
            'email' => 'admin@traveltotunisia.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create 5 travel agencies (regular users who will post trips)
        $agencies = [
            ['name' => 'Tunisia Voyages', 'email' => 'contact@tunisiavoyages.tn'],
            ['name' => 'Sahara Tours', 'email' => 'info@saharato.urs.tn'],
            ['name' => 'Medina Travel', 'email' => 'hello@medinatravel.com'],
            ['name' => 'Djerba Excursions', 'email' => 'booking@djerba-excursions.tn'],
            ['name' => 'North African Adventures', 'email' => 'info@naa.tn'],
        ];

        foreach ($agencies as $agency) {
            User::create([
                'name' => $agency['name'],
                'email' => $agency['email'],
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }

        // Create 3 regular tourists (for reviews and blog comments later)
        $tourists = [
            ['name' => 'Emma Laurent', 'email' => 'emma@example.com'],
            ['name' => 'Carlos Mendez', 'email' => 'carlos@example.com'],
            ['name' => 'Fatima Al Zahra', 'email' => 'fatima@example.com'],
        ];

        foreach ($tourists as $tourist) {
            User::create([
                'name' => $tourist['name'],
                'email' => $tourist['email'],
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
    }
}