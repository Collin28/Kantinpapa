<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Rice Bowls', 'slug' => 'rice-bowls'],
            ['name' => 'Noodles', 'slug' => 'noodles'],
            ['name' => 'Snacks', 'slug' => 'snacks'],
            ['name' => 'Drinks', 'slug' => 'drinks'],
            ['name' => 'Desserts', 'slug' => 'desserts'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
