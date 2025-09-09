<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Place;
use App\Models\Review;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        $users = User::factory(10)->create();

        // Each user creates 3 places
        $users->each(function ($user) {
            Place::factory(3)->create([
                'user_id' => $user->id,
            ]);
        });

        // Get all places
        $places = Place::all();

        // Each user adds 2 reviews to random places
        $users->each(function ($user) use ($places) {
            $places->random(2)->each(function ($place) use ($user) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'place_id' => $place->id,
                ]);
            });
        });

        // Each user uploads 2 photos to random places
        $users->each(function ($user) use ($places) {
            $places->random(2)->each(function ($place) use ($user) {
                Photo::factory()->create([
                    'user_id' => $user->id,
                    'place_id' => $place->id,
                ]);
            });
        });

        // Each user adds 3 random places to their wishlist
        $users->each(function ($user) use ($places) {
            $places->random(3)->each(function ($place) use ($user) {
                Wishlist::factory()->create([
                    'user_id' => $user->id,
                    'place_id' => $place->id,
                ]);
            });
        });
        
        // Each review gets 1 comment from a random user
        $reviews = Review::all();
        $reviews->each(function ($review) use ($users) {
            Comment::factory()->create([
                'user_id' => $users->random()->id,
                'review_id' => $review->id,
            ]);
        });
    }
}