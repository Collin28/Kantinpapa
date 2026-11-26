<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');

        $menus = [
            [
                'category_id' => $categories['rice-bowls'],
                'name' => 'Nasi Ayam Bakar',
                'description' => 'Grilled chicken over steamed jasmine rice with sambal, fresh cucumber slices, and fresh shallots.',
                'price' => 18000,
                'img_url' => 'https://images.unsplash.com/photo-1610057099431-d73a1c9d2f2f?w=800&q=80',
                'is_available' => true,
                'stock' => 24,
            ],
            [
                'category_id' => $categories['rice-bowls'],
                'name' => 'Nasi Goreng Kampung',
                'description' => 'Traditional Indonesian fried rice with sunny-side-up egg, chicken, and crispy crackers.',
                'price' => 16500,
                'img_url' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800&q=80',
                'is_available' => true,
                'stock' => 18,
            ],
            [
                'category_id' => $categories['rice-bowls'],
                'name' => 'Soto Ayam',
                'description' => 'Clear turmeric chicken soup with glass noodles, boiled egg, shredded chicken, and fried shallots.',
                'price' => 18000,
                'img_url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800',
                'is_available' => false,
                'stock' => 0,
            ],
            [
                'category_id' => $categories['noodles'],
                'name' => 'Mie Goreng Spesial',
                'description' => 'Wok-tossed egg noodles with shrimp, chicken, egg, vegetables, and house sweet soy sauce.',
                'price' => 16000,
                'img_url' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=800&q=80',
                'is_available' => true,
                'stock' => 15,
            ],
            [
                'category_id' => $categories['noodles'],
                'name' => 'Bakso Sapi',
                'description' => 'Savory beef meatball soup served with yellow noodles, rice vermicelli, and bok choy.',
                'price' => 20000,
                'img_url' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=800&q=80',
                'is_available' => true,
                'stock' => 12,
            ],
            [
                'category_id' => $categories['snacks'],
                'name' => 'Pisang Goreng Keju',
                'description' => 'Crispy fried banana topped with grated cheddar cheese and chocolate sprinkles.',
                'price' => 8800,
                'img_url' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=800&q=80',
                'is_available' => true,
                'stock' => 20,
            ],
            [
                'category_id' => $categories['drinks'],
                'name' => 'Es Teh Manis',
                'description' => 'Refreshing chilled sweet black tea brewed daily.',
                'price' => 5000,
                'img_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&q=80',
                'is_available' => true,
                'stock' => 40,
            ],
            [
                'category_id' => $categories['desserts'],
                'name' => 'Es Campur',
                'description' => 'Shaved ice dessert with coconut, grass jelly, jackfruit, and sweet condensed milk.',
                'price' => 12000,
                'img_url' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?w=800&q=80',
                'is_available' => true,
                'stock' => 14,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['name' => $menu['name']],
                $menu
            );
        }
    }
}
