<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        // Get all travel agency users (the ones we created in UserSeeder)
        $agencies = User::where('role', 'user')->get();

        if ($agencies->isEmpty()) {
            $this->command->info('No users found. Run UserSeeder first.');
            return;
        }

        $trips = [
            [
                'title' => 'Discovery of Carthage & Sidi Bou Said',
                'description' => 'Visit the ancient ruins of Carthage, then stroll through the blue-and-white streets of Sidi Bou Said. Includes lunch at a traditional café.',
                'destination' => 'Carthage / Sidi Bou Said',
                'price' => 85.00,
                'date' => Carbon::now()->addDays(10),
                'departure_time' => '08:30',
                'return_time' => '17:00',
                'available_seats' => 15,
                'image' => null,
            ],
            [
                'title' => 'Sahara Desert Overnight – Douz & Ksar Ghilane',
                'description' => 'Experience camel trekking, overnight in a desert camp, traditional dinner, and stargazing. Transfer from Douz included.',
                'destination' => 'Douz / Ksar Ghilane',
                'price' => 180.00,
                'date' => Carbon::now()->addDays(15),
                'departure_time' => '09:00',
                'return_time' => '11:00',  // FIXED: removed "(next day)"
                'available_seats' => 12,
                'image' => null,
            ],
            [
                'title' => 'Medina of Tunis Shopping & Food Tour',
                'description' => 'Explore the historic medina, visit souks, taste local pastries (makroudh, bambalouni), and enjoy a traditional couscous lunch.',
                'destination' => 'Tunis Medina',
                'price' => 55.00,
                'date' => Carbon::now()->addDays(5),
                'departure_time' => '10:00',
                'return_time' => '15:30',
                'available_seats' => 20,
                'image' => null,
            ],
            [
                'title' => 'Hammamet & Nabeul Pottery Day Trip',
                'description' => 'Relax on Hammamet beach, visit the medina, then head to Nabeul to see traditional pottery and buy souvenirs.',
                'destination' => 'Hammamet / Nabeul',
                'price' => 45.00,
                'date' => Carbon::now()->addDays(7),
                'departure_time' => '09:00',
                'return_time' => '18:00',
                'available_seats' => 25,
                'image' => null,
            ],
            [
                'title' => 'El Jem Colosseum & Roman Mosaics',
                'description' => 'Visit the magnificent amphitheater of El Jem (UNESCO), then explore the archaeological museum with stunning mosaics.',
                'destination' => 'El Jem',
                'price' => 65.00,
                'date' => Carbon::now()->addDays(12),
                'departure_time' => '07:30',
                'return_time' => '19:00',
                'available_seats' => 18,
                'image' => null,
            ],
            [
                'title' => 'Djerba Island Explorer',
                'description' => 'Discover Djerba: Guellala Museum, crocodile farm, Houmt Souk market, and a boat trip to Flamingo Island.',
                'destination' => 'Djerba',
                'price' => 120.00,
                'date' => Carbon::now()->addDays(20),
                'departure_time' => '08:00',
                'return_time' => '17:30',
                'available_seats' => 10,
                'image' => null,
            ],
            [
                'title' => 'Star Wars Film Locations – Onk Jemel & Matmata',
                'description' => 'Visit the troglodyte houses of Matmata (Luke Skywalker’s home), then the desert set of Onk Jemel from Star Wars.',
                'destination' => 'Matmata / Onk Jemel',
                'price' => 150.00,
                'date' => Carbon::now()->addDays(25),
                'departure_time' => '07:00',
                'return_time' => '20:00',
                'available_seats' => 14,
                'image' => null,
            ],
            [
                'title' => 'Kairouan – Holy City & Carpets',
                'description' => 'Tour the Great Mosque of Kairouan, visit the Aghlabid Basins, and watch carpet weaving demonstrations.',
                'destination' => 'Kairouan',
                'price' => 70.00,
                'date' => Carbon::now()->addDays(18),
                'departure_time' => '08:00',
                'return_time' => '18:30',
                'available_seats' => 22,
                'image' => null,
            ],
        ];

        foreach ($trips as $tripData) {
            // Assign random agency to each trip
            $tripData['user_id'] = $agencies->random()->id;
            Trip::create($tripData);
        }
    }
}