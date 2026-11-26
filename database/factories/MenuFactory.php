<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(5, 35) * 1000,
            'img_url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800',
            'is_available' => true,
            'stock' => fake()->numberBetween(5, 30),
        ];
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}
