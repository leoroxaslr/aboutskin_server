<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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


    public function definition(): array
    {
        
  
        return [
            "name" => fake()->word(),
            "brand" => fake()->word(),
            "description" => fake()->text(20),
            "description_long" => fake()->text(50),
            "price" => fake()->randomFloat(2, 100, 1000),
            "stock" => fake()->randomNumber(3),
            "rating" => fake()->numberBetween(1,5),
            "category_id" => fake()->randomElement(Category::pluck("id")),
            'image' => $this->faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg')

        ];
    }
}

