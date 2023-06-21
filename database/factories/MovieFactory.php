<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MovieFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'release_date' => $this->faker->date(),
            'director' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
