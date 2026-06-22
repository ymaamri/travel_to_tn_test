<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Get the admin user (or any user) as author
        $author = User::where('role', 'admin')->first();
        if (!$author) {
            $author = User::first();
        }
        if (!$author) {
            $this->command->info('No users found. Run UserSeeder first.');
            return;
        }

        $blogs = [
            [
                'title' => 'Top 10 Foods You Must Try in Tunisia',
                'excerpt' => 'From spicy harissa to sweet bambalouni, discover the flavors that define Tunisian cuisine.',
                'content' => "Tunisian food is a delightful mix of Mediterranean, Berber, and Arab influences. Here are 10 dishes you cannot miss:\n\n**1. Couscous** – The national dish, served with lamb, chicken, or vegetables.\n\n**2. Brik** – A crispy pastry filled with egg, tuna, and capers.\n\n**3. Harissa** – A spicy chili paste used in almost every meal.\n\n**4. Lablabi** – A hearty chickpea soup with bread and garlic.\n\n**5. Merguez** – Spicy lamb sausages grilled to perfection.\n\n**6. Ojja** – Eggs cooked in a spicy tomato sauce with merguez.\n\n**7. Makroudh** – Semolina pastries filled with dates and honey.\n\n**8. Bambalouni** – Tunisian-style donuts, a perfect street snack.\n\n**9. Mechouia Salad** – Grilled peppers, tomatoes, and onions mixed with tuna.\n\n**10. Seafood Couscous** – A coastal version with fish and shellfish.\n\nWhere to try them? Visit local markets (souks) and small family-run restaurants for the most authentic experience.",
                'featured_image' => null,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'How to Get Around Tunisia Without a Car',
                'excerpt' => 'Complete guide to trains, louage, taxis, and domestic flights – save money and travel like a local.',
                'content' => "Tunisia has a reliable and affordable public transport network. Here's everything you need to know:\n\n**Trains (SNCFT)** – Best for traveling between major cities like Tunis, Sousse, Sfax, and Gabès. First class is recommended (air conditioning and reserved seats).\n\n**Louage (Shared Taxis)** – White vans that depart when full. They are faster than buses and connect almost every town. Major stations are in every city center.\n\n**Taxis** – Yellow taxis in Tunis and white ones elsewhere. Always ask for the meter (\"compteur\"). Negotiate only if the meter is broken.\n\n**Domestic Flights** – Tunisair and Nouvelair fly to Djerba, Tozeur, and Gabès. Saves time for long distances.\n\n**Ride-hailing** – Bolt operates in Tunis (similar to Uber).\n\n**Pro tip:** Download offline maps (Google Maps) and carry small bills for taxis and louage.",
                'featured_image' => null,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'The Ultimate Sahara Desert Experience',
                'excerpt' => 'What to pack, where to go, and how to plan an unforgettable desert adventure.',
                'content' => "The Sahara desert is Tunisia's most dramatic landscape. Here's how to make the most of your trip:\n\n**Best time to go:** October to April (avoid summer heat).\n\n**Main gateways:** Douz, Tozeur, or Ksar Ghilane.\n\n**Top experiences:**\n- Camel trekking at sunset\n- 4x4 dune bashing\n- Overnight in a Bedouin camp\n- Visit Ksar Ghilane hot springs\n- Star Wars film locations (Onk Jemel)\n\n**What to pack:**\n- Light, breathable clothes (cover arms and legs for sun protection)\n- Warm jacket for cold desert nights\n- Scarf or shemagh for sandstorms\n- Sunscreen, sunglasses, and a hat\n- Refillable water bottle\n\n**Tours:** You can book from Douz or Tozeur. A one-day trip from Douz costs around 80-120 TND per person. Overnight camps range from 150-250 TND including dinner and breakfast.\n\n**Safety:** Always go with a licensed guide. Do not venture into the desert alone.",
                'featured_image' => null,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Visiting Carthage and Sidi Bou Said in One Day',
                'excerpt' => 'Itinerary, tickets, and tips for combining these two iconic sites near Tunis.',
                'content' => "Carthage and Sidi Bou Said are only a few kilometers apart, making them perfect for a day trip from Tunis.\n\n**Morning – Carthage (9am-1pm):**\nStart at the Antonine Baths (the largest Roman baths in Africa), then walk to the Carthage Museum on Byrsa Hill. Next, visit the Roman villas and the Punic ports. A combined ticket for all sites costs 12 TND (adult).\n\n**Lunch – La Goulette:**\nTake a taxi or train to La Goulette port for fresh seafood at a local restaurant.\n\n**Afternoon – Sidi Bou Said (2pm-6pm):**\nExplore the blue-and-white streets, visit the Café des Nattes (where André Gide and Simone de Beauvoir used to sit), and enjoy mint tea. Don't miss the Sidi Bou Said lighthouse for panoramic views.\n\n**Getting there:** TGM train from Tunis Marine station to Carthage (20 min) and then to Sidi Bou Said (5 min). Or taxi (10-15 TND).\n\n**Budget:** Transport ~5 TND, entrance fees ~12 TND, lunch ~20-30 TND.",
                'featured_image' => null,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Beach Guide: Best Coastal Towns in Tunisia',
                'excerpt' => 'Compare Hammamet, Sousse, Monastir, Mahdia, and Djerba for your beach holiday.',
                'content' => "Tunisia has 1,300 km of Mediterranean coastline. Here's which beach town suits you:\n\n**Hammamet** – Lively, family-friendly, lots of hotels and nightlife. Best for first-time visitors.\n\n**Sousse** – Historic medina combined with beaches. Great for culture + beach combo.\n\n**Monastir** – Quieter than Sousse, with a beautiful ribat (fortress). Ideal for couples.\n\n**Mahdia** – Traditional fishing town with turquoise water. More authentic and less crowded.\n\n**Djerba** – Island with palm-fringed beaches, relaxed atmosphere, and unique heritage. Best for longer stays.\n\n**Tabarka** – Coral beaches and rocky coves in the northwest, close to forests. Perfect for nature lovers.\n\n**Tip:** Avoid August (very crowded and hot). June or September offer pleasant weather and fewer tourists.",
                'featured_image' => null,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($blogs as $blogData) {
            $blogData['user_id'] = $author->id;
            $blogData['slug'] = Str::slug($blogData['title']);
            Blog::create($blogData);
        }
    }
}