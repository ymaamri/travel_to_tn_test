<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Trip;
use App\Models\Destination;
use App\Models\Activity;
use App\Models\Establishment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users (except admin for some variety)
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->info('No users found. Run UserSeeder first.');
            return;
        }

        // Get all reviewable items
        $trips = Trip::all();
        $destinations = Destination::all();
        $activities = Activity::all();
        $establishments = Establishment::all();

        // Helper function to pick random rating (bias towards high for Tunisia)
        $getRating = function () {
            $weights = [5 => 40, 4 => 30, 3 => 20, 2 => 7, 1 => 3]; // 40% chance for 5 stars
            $rand = rand(1, 100);
            $cumulative = 0;
            foreach ($weights as $rating => $weight) {
                $cumulative += $weight;
                if ($rand <= $cumulative)
                    return $rating;
            }
            return 4;
        };

        // Reviews for Trips
        foreach ($trips as $trip) {
            // Each trip gets 2-5 reviews from random users
            $numReviews = rand(2, 5);
            $reviewers = $users->random(min($numReviews, $users->count()));
            foreach ($reviewers as $user) {
                $rating = $getRating();
                Review::create([
                    'user_id' => $user->id,
                    'reviewable_id' => $trip->id,
                    'reviewable_type' => 'App\\Models\\Trip',
                    'rating' => $rating,
                    'title' => $this->getTripReviewTitle($rating),
                    'content' => $this->getTripReviewContent($rating, $trip->destination),
                    'is_verified' => $user->hasVerifiedTravel() || rand(0, 1),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // Reviews for Destinations
        foreach ($destinations as $destination) {
            $numReviews = rand(3, 8);
            $reviewers = $users->random(min($numReviews, $users->count()));
            foreach ($reviewers as $user) {
                $rating = $getRating();
                Review::create([
                    'user_id' => $user->id,
                    'reviewable_id' => $destination->id,
                    'reviewable_type' => 'App\\Models\\Destination',
                    'rating' => $rating,
                    'title' => $this->getDestinationReviewTitle($rating, $destination->name),
                    'content' => $this->getDestinationReviewContent($rating, $destination->name),
                    'is_verified' => $user->hasVerifiedTravel() || rand(0, 1),
                    'created_at' => Carbon::now()->subDays(rand(1, 60)),
                ]);
            }
        }

        // Reviews for Activities
        foreach ($activities as $activity) {
            $numReviews = rand(1, 4);
            $reviewers = $users->random(min($numReviews, $users->count()));
            foreach ($reviewers as $user) {
                $rating = $getRating();
                Review::create([
                    'user_id' => $user->id,
                    'reviewable_id' => $activity->id,
                    'reviewable_type' => 'App\\Models\\Activity',
                    'rating' => $rating,
                    'title' => $this->getActivityReviewTitle($rating, $activity->title),
                    'content' => $this->getActivityReviewContent($rating, $activity->title),
                    'is_verified' => $user->hasVerifiedTravel() || rand(0, 1),
                    'created_at' => Carbon::now()->subDays(rand(1, 45)),
                ]);
            }
        }

        // Reviews for Establishments
        foreach ($establishments as $establishment) {
            $numReviews = rand(2, 6);
            $reviewers = $users->random(min($numReviews, $users->count()));
            foreach ($reviewers as $user) {
                $rating = $getRating();
                Review::create([
                    'user_id' => $user->id,
                    'reviewable_id' => $establishment->id,
                    'reviewable_type' => 'App\\Models\\Establishment',
                    'rating' => $rating,
                    'title' => $this->getEstablishmentReviewTitle($rating, $establishment->name),
                    'content' => $this->getEstablishmentReviewContent($rating, $establishment->name),
                    'is_verified' => $user->hasVerifiedTravel() || rand(0, 1),
                    'created_at' => Carbon::now()->subDays(rand(1, 50)),
                ]);
            }
        }

        $this->command->info('Reviews created successfully!');
    }

    // Helper methods for realistic review texts
    private function getTripReviewTitle($rating)
    {
        $titles = [
            5 => ['Amazing experience!', 'Absolutely perfect!', 'Best trip ever!', 'Unforgettable!'],
            4 => ['Great trip, minor issues', 'Really enjoyable', 'Very good overall'],
            3 => ['Average but okay', 'Not bad', 'Could be better'],
            2 => ['Disappointing', 'Not what we expected'],
            1 => ['Terrible', 'Waste of money'],
        ];
        $choices = $titles[$rating] ?? $titles[3];
        return $choices[array_rand($choices)];
    }

    private function getTripReviewContent($rating, $destination)
    {
        if ($rating >= 4) {
            return "The trip to {$destination} was fantastic! The guide was knowledgeable, the itinerary was well-planned, and we felt safe the entire time. Highly recommend to anyone visiting Tunisia.";
        } elseif ($rating == 3) {
            return "It was okay. Some aspects were good (scenery, transport) but the guide rushed us and lunch was average. Could be improved.";
        } else {
            return "Very disappointed. The bus was late, the guide didn't speak good English, and we missed one of the promised stops. Would not book again.";
        }
    }

    private function getDestinationReviewTitle($rating, $name)
    {
        $titles = [
            5 => ["{$name} is a gem!", "Loved {$name}!", "Incredible place"],
            4 => ["Very nice visit to {$name}", "Good destination"],
            3 => ["{$name} was okay", "Average experience"],
            2 => ["Disappointing", "Overrated"],
            1 => ["Don't bother", "Waste of time"],
        ];
        $choices = $titles[$rating] ?? $titles[3];
        return $choices[array_rand($choices)];
    }

    private function getDestinationReviewContent($rating, $name)
    {
        if ($rating >= 4) {
            return "{$name} exceeded my expectations. The history, the people, the food – all amazing. I spent two days there and wish I had stayed longer. Clean, safe, and beautiful. Will return!";
        } elseif ($rating == 3) {
            return "{$name} has its charms but was a bit crowded and touristy. Still worth a visit if you have time.";
        } else {
            return "I didn't enjoy {$name} much. Too many touts, and the main sites were poorly maintained. Maybe off-season is better.";
        }
    }

    private function getActivityReviewTitle($rating, $activity)
    {
        $short = substr($activity, 0, 20);
        if ($rating >= 4)
            return "Loved this activity!";
        if ($rating == 3)
            return "It was fine";
        return "Not great";
    }

    private function getActivityReviewContent($rating, $activity)
    {
        if ($rating >= 4) {
            return "The {$activity} was a highlight of my trip. Well-organized, fair price, and the staff were wonderful. Definitely recommend booking this.";
        } elseif ($rating == 3) {
            return "The {$activity} was okay but a bit overpriced for what you get. Still, it was a decent experience.";
        } else {
            return "Disappointed with the {$activity}. Not as described and felt rushed. Would not do it again.";
        }
    }

    private function getEstablishmentReviewTitle($rating, $name)
    {
        if ($rating >= 4)
            return "Great place!";
        if ($rating == 3)
            return "Average";
        return "Disappointing";
    }

    private function getEstablishmentReviewContent($rating, $name)
    {
        if ($rating >= 4) {
            return "{$name} was excellent – clean, friendly staff, and good value. Would stay/eat here again without hesitation.";
        } elseif ($rating == 3) {
            return "{$name} was fine but nothing special. Room/food was acceptable but there are better options nearby.";
        } else {
            return "Avoid {$name}. Dirty, unhelpful staff, and overpriced. Much better places in the area.";
        }
    }
}