<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_their_own_orders_in_history(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $ownOrder = Order::factory()->for($user)->create(['order_number' => 'KTG-111111']);
        $otherOrder = Order::factory()->for($other)->create(['order_number' => 'KTG-222222']);

        $this->actingAs($user)
            ->get(route('orders.index'))
            ->assertStatus(200)
            ->assertSee($ownOrder->order_number)
            ->assertDontSee($otherOrder->order_number);
    }

    public function test_user_cannot_view_confirmed_or_reorder_someone_elses_order(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $otherOrder = Order::factory()->for($other)->create();

        $this->actingAs($user)
            ->get(route('orders.confirmed', $otherOrder))
            ->assertStatus(403);

        $this->actingAs($user)
            ->post(route('orders.reorder', $otherOrder))
            ->assertStatus(403);
    }

    public function test_reorder_adds_available_items_and_reports_skipped_and_adjusted_items(): void
    {
        $user = User::factory()->create();
        $availableMenu = Menu::factory()->create(['name' => 'Mie Goreng', 'stock' => 2]);
        $soldOutMenu = Menu::factory()->outOfStock()->create(['name' => 'Soto Ayam']);

        $order = Order::factory()->for($user)->create();
        OrderItem::factory()->for($order)->for($availableMenu)->create([
            'menu_name' => $availableMenu->name,
            'qty' => 4,
            'unit_price' => 15000,
            'line_total' => 60000,
        ]);
        OrderItem::factory()->for($order)->for($soldOutMenu)->create([
            'menu_name' => $soldOutMenu->name,
            'qty' => 1,
            'unit_price' => 15000,
            'line_total' => 15000,
        ]);

        $response = $this->actingAs($user)->post(route('orders.reorder', $order));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('warning');

        $this->assertSame([$availableMenu->id => 2], session('cart'));
    }
}
