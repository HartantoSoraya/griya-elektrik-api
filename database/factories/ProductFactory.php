<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $code = Str::upper(Str::random(10));
        $name = $this->faker->word;

        return [
            'code' => $code,
            'name' => $name,
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 1000),
            'is_featured' => $this->faker->boolean,
            'is_active' => $this->faker->boolean,
            'slug' => Str::slug($name.'-'.$code),
        ];
    }
}
