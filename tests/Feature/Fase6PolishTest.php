<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Fase6PolishTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_status_polling_endpoint_returns_json_and_blocks_other_users(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $order = Order::factory()->for($owner)->create([
            'order_status' => OrderStatus::Ready,
        ]);

        $this->actingAs($owner)
            ->getJson(route('orders.status', $order))
            ->assertStatus(200)
            ->assertJson([
                'order_number' => $order->order_number,
                'order_status' => 'ready',
                'order_status_label' => 'Ready',
            ]);

        $this->actingAs($other)
            ->getJson(route('orders.status', $order))
            ->assertStatus(403);
    }

    public function test_order_history_paginates_after_ten_orders(): void
    {
        $user = User::factory()->create();
        Order::factory()->count(12)->for($user)->create();

        $this->actingAs($user)
            ->get(route('orders.index'))
            ->assertStatus(200);

        $this->actingAs($user)
            ->get(route('orders.index', ['page' => 2]))
            ->assertStatus(200);
    }

    public function test_custom_error_pages_render_for_403_and_404(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertStatus(403)
            ->assertSee('Access Denied');

        $this->get('/non-existent-kantin-page')
            ->assertStatus(404)
            ->assertSee('Page Not Found');
    }
}
