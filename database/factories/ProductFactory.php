<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->words(2, true);
        $slug = Str::slug($name);
        $description = $this->faker->sentence(rand(10, 25));
        $price = $this->faker->randomFloat(2, 5, 1000);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'price' => $price
        ];
    }
}
