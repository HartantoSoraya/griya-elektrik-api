<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductBrand>
 */
class ProductBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = Str::upper(Str::random(10));
        $name = $this->faker->word;

        return [
            'code' => Str::upper(Str::random(10)),
            'name' => $this->faker->unique()->word,
            'slug' => Str::slug($name.'-'.$code),
        ];
    }
}
