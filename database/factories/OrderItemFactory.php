<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $unitPrice = 10000;
        $qty = 2;

        return [
            'order_id' => Order::factory(),
            'menu_id' => Menu::factory(),
            'menu_name' => 'Nasi Ayam Bakar',
            'unit_price' => $unitPrice,
            'qty' => $qty,
            'line_total' => $unitPrice * $qty,
        ];
    }
}
