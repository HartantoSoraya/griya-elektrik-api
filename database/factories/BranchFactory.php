<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::upper(Str::random(10)),
            'name' => $this->faker->unique()->word,
            'map' => $this->faker->word,
            'address' => $this->faker->word,
            'city' => $this->faker->word,
            'email' => $this->faker->email,
            'phone' => $this->faker->word,
            'facebook' => $this->faker->word,
            'instagram' => $this->faker->word,
            'youtube' => $this->faker->word,
            'sort' => $this->faker->randomNumber(0),
            'is_main' => $this->faker->boolean,
            'status' => $this->faker->randomNumber(0),
        ];
    }
}
