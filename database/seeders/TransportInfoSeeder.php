<?php

namespace Database\Seeders;

use App\Models\TransportInfo;
use Illuminate\Database\Seeder;

class TransportInfoSeeder extends Seeder
{
    public function run(): void
    {
        $transports = [
            [
                'slug' => 'airports',
                'title' => 'Airports in Tunisia',
                'content' => '<h3>Tunis–Carthage International Airport (TUN)</h3>
<p>The main international gateway. Located 8 km northeast of Tunis city center.</p>
<ul>
<li><strong>Facilities:</strong> Duty-free shops, cafés, currency exchange, car rentals (Europcar, Hertz, Avis), ATMs, free Wi-Fi.</li>
<li><strong>Transport to city:</strong> Taxi (~5-7 TND, 15-20 min), bus (line 635, ~0.800 TND), louage (shared taxi).</li>
<li><strong>Major airlines:</strong> Tunisair, Nouvelair, Air France, Lufthansa, Turkish Airlines, Qatar Airways.</li>
</ul>

<h3>Enfidha–Hammamet International Airport (NBE)</h3>
<p>Serves the tourist resorts of Hammamet and Sousse. Mostly charter flights.</p>
<ul>
<li><strong>Transport:</strong> Taxi to Hammamet (~40 TND, 30 min), to Sousse (~50 TND, 40 min). Buses available for package tours.</li>
</ul>

<h3>Monastir Habib Bourguiba International Airport (MIR)</h3>
<p>Close to Monastir and Sousse. Mainly seasonal charter flights.</p>

<h3>Djerba–Zarzis International Airport (DJE)</h3>
<p>Gateway to Djerba island. Taxis available to Houmt Souk (~10 TND).</p>

<h3>Tozeur–Nefta International Airport (TOE)</h3>
<p>Access to the Sahara desert and Onk Jemel (Star Wars set).</p>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => 'Tunis Airport info: +216 71 754 000',
                'is_published' => true,
                'created_by' => 1,
            ],
            [
                'slug' => 'taxis',
                'title' => 'Taxis in Tunisia',
                'content' => '<h3>Types of Taxis</h3>
<ul>
<li><strong>Yellow taxis</strong> – Tunis, Carthage, Sidi Bou Said, La Marsa (metered).</li>
<li><strong>White with yellow bands</strong> – Other cities (Sousse, Hammamet, Monastir).</li>
</ul>

<h3>Fares (approximate)</h3>
<ul>
<li>Flag drop: 0.500 TND day / 0.750 TND night</li>
<li>Per km: 0.500–0.700 TND</li>
<li>Tunis Airport → city center: ~5-7 TND</li>
<li>Sousse center → Port El Kantaoui: ~6-8 TND</li>
</ul>

<h3>Tips</h3>
<ul>
<li>Always ask for the meter: "Compteur, s\'il vous plaît"</li>
<li>Cash only, small bills appreciated.</li>
<li>Ride-hailing apps: Bolt (Tunis).</li>
</ul>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => null,
                'is_published' => true,
                'created_by' => 1,
            ],
            [
                'slug' => 'louage',
                'title' => 'Louage (Shared Taxis)',
                'content' => '<p>Louage are white vans that depart when full. Fastest way between cities.</p>

<h3>Major Louage Stations</h3>
<ul>
<li>Tunis: Gare de Louage de Bab Alioua</li>
<li>Sousse: next to main bus station</li>
<li>Sfax: Avenue Habib Bourguiba area</li>
</ul>

<h3>Sample Fares</h3>
<ul>
<li>Tunis → Sousse: ~8-10 TND (2h)</li>
<li>Tunis → Hammamet: ~6-7 TND (1h15)</li>
<li>Sousse → Monastir: ~3-4 TND (30 min)</li>
</ul>

<h3>Tips</h3>
<ul>
<li>Buy ticket at counter before boarding.</li>
<li>Arrive early on Fridays and Sundays.</li>
<li>Have destination written in French/Arabic.</li>
</ul>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => null,
                'is_published' => true,
                'created_by' => 1,
            ],
            [
                'slug' => 'trains',
                'title' => 'Trains (SNCFT)',
                'content' => '<h3>Main Lines</h3>
<ul>
<li>North–South: Tunis → Sousse → Sfax → Gabès</li>
<li>Northern: Tunis → Bizerte</li>
<li>Metro du Sahel: Sousse → Monastir → Mahdia</li>
</ul>

<h3>Classes</h3>
<ul>
<li>1st Class: AC, reserved seats (recommended)</li>
<li>2nd Class: cheaper, may be crowded</li>
</ul>

<h3>Sample Fares (1st class)</h3>
<ul>
<li>Tunis → Sousse: ~12-15 TND (2.5-3h)</li>
<li>Tunis → Sfax: ~20-25 TND (4h)</li>
</ul>

<h3>Buy Tickets</h3>
<ul>
<li>At station (30 min before departure)</li>
<li>Online: sncft.com.tn</li>
</ul>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => 'SNCFT customer service: 81 102 102',
                'is_published' => true,
                'created_by' => 1,
            ],
            [
                'slug' => 'car-rental',
                'title' => 'Car Rental in Tunisia',
                'content' => '<h3>Major Companies</h3>
<ul>
<li>International: Europcar, Hertz, Avis, Sixt</li>
<li>Local: Location Voiture Tunisia, Carthage Rent</li>
</ul>

<h3>Requirements</h3>
<ul>
<li>Valid driver\'s license (EU/US/Canadian accepted)</li>
<li>Passport</li>
<li>Credit card for deposit</li>
</ul>

<h3>Daily Rates (low season)</h3>
<ul>
<li>Economy car: 40-60 TND</li>
<li>Compact: 60-80 TND</li>
<li>SUV: 100-150 TND</li>
</ul>

<h3>Fuel & Tolls</h3>
<ul>
<li>Petrol ~2.5 TND/L, Diesel ~2.2 TND/L</li>
<li>Highway A1 tolls: Tunis–Sousse ~10 TND</li>
</ul>

<h3>Driving Tips</h3>
<ul>
<li>Drive on the right</li>
<li>Speed limits: city 50 km/h, highway 110 km/h</li>
<li>Always carry license, passport, rental papers</li>
</ul>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => null,
                'is_published' => true,
                'created_by' => 1,
            ],
            [
                'slug' => 'metro',
                'title' => 'Metro in Tunis (TGM & Light Rail)',
                'content' => '<h3>TGM Line (Tunis–La Marsa)</h3>
<ul>
<li>Tunis Marine → Carthage → Sidi Bou Said → La Marsa</li>
<li>Trains every 10-15 min, travel time ~25 min</li>
</ul>

<h3>Métro Léger (Lines 1-6)</h3>
<ul>
<li>Hub: Place de Barcelone</li>
<li>Serve suburbs: Ariana, Ben Arous, Ezzahra</li>
</ul>

<h3>Fares</h3>
<ul>
<li>Single ticket: 0.500–0.800 TND</li>
<li>Prepaid card available (cheaper)</li>
</ul>

<h3>Operating Hours</h3>
<ul>
<li>Weekdays/Sat: 05:00–23:00</li>
<li>Sunday: 06:00–22:00</li>
</ul>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => 'TGM info: +216 71 333 333',
                'is_published' => true,
                'created_by' => 1,
            ],
            [
                'slug' => 'ferry',
                'title' => 'Ferry Information',
                'content' => '<h3>International Ferries</h3>
<ul>
<li>Tunis (La Goulette) ↔ Genoa, Naples, Palermo, Civitavecchia</li>
<li>Tunis ↔ Marseille</li>
<li>Sousse/Tunis ↔ Valletta (seasonal)</li>
</ul>

<h3>Companies</h3>
<ul>
<li>CTN (Tunisian national company)</li>
<li>Grimaldi Lines, GNV, Corsica Ferries</li>
</ul>

<h3>Sample Fares (passenger, one-way)</h3>
<ul>
<li>Tunis → Palermo: from ~100 TND (10h)</li>
<li>Tunis → Genoa: from ~150 TND (20+h)</li>
<li>Car additional: ~300-500 TND</li>
</ul>

<h3>Domestic Ferries</h3>
<ul>
<li>Djerba: Jorf ↔ Ajim (10 min, ~1 TND passenger)</li>
<li>Kerkennah Islands: from Sfax (1h)</li>
</ul>',
                'featured_image' => null,
                'gallery' => null,
                'map_url' => null,
                'contact_info' => 'CTN (Tunis): +216 71 341 000',
                'is_published' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($transports as $transport) {
            TransportInfo::create($transport);
        }
    }
}