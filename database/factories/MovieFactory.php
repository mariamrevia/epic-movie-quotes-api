<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class MovieFactory extends Factory
{
    public function definition()
    {
        $faker = \Faker\Factory::create('ka_GE');


        return [

            'name' => [
                'en' => $faker->word(),
                'ka' =>  $faker->realText(10),
            ],

            'director' => [
                'en' => $faker->firstName() . ' ' . $faker->lastName(),
                'ka' =>  $faker->realText(10),
            ],
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),

        ];
    }
}
