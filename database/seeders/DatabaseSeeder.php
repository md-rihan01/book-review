<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => bcrypt('password'),
            'role' => 'author',
        ]);

        User::create([
            'name' => 'Subscriber User',
            'email' => 'subscriber@example.com',
            'password' => bcrypt('password'),
            'role' => 'subscriber',
        ]);

        $author = User::where('email', 'author@example.com')->first();

        $subscriber = User::where('email', 'subscriber@example.com')->first();

        Book::factory(33)->create(['author_id' => $author->id])->each(function ($book) use ($subscriber) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->good()->for($book)->create(['user_id' => $subscriber->id]);
        });

        Book::factory(33)->create(['author_id' => $author->id])->each(function ($book) use ($subscriber) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->average()->for($book)->create(['user_id' => $subscriber->id]);
        });

        Book::factory(34)->create(['author_id' => $author->id])->each(function ($book) use ($subscriber) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->bad()->for($book)->create(['user_id' => $subscriber->id]);
        });
    }
}
