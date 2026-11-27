<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = 20000;
        $taxAmount = (int) round($subtotal * 0.10);

        return [
            'order_number' => 'KTG-'.fake()->unique()->numerify('######'),
            'user_id' => User::factory(),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $subtotal + $taxAmount,
            'payment_status' => PaymentStatus::Pending,
            'order_status' => OrderStatus::Pending,
            'paid_at' => null,
            'expires_at' => now()->addMinutes(15),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => PaymentStatus::Paid,
            'order_status' => OrderStatus::Paid,
            'paid_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => PaymentStatus::Paid,
            'order_status' => OrderStatus::Completed,
            'paid_at' => now(),
        ]);
    }
}
