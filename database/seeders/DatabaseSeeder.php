<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'username' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Movie::factory(5)->create();
        Genre::factory(5)->create();
        $movies = Movie::all();
        $genres = Genre::all();

        foreach ($movies as $movie) {
            $movie->genres()->attach($genres->random(2));
        }
    }
}
