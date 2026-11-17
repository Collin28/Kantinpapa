<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_saves_order_and_ordered_menu_for_order_history(): void
    {
        $category = Category::create(['name' => 'Makanan']);
        $menu = Menu::create([
            'category_id' => $category->id,
            'name' => 'Nasi Ayam',
            'description' => 'Nasi dengan ayam bakar',
            'price' => 20000,
            'img_url' => '',
            'is_available' => true,
        ]);

        $this->get(route('users.home'))->assertOk()->assertSee('Nasi Ayam');
        $this->post(route('users.cart.add', $menu));
        $this->get(route('users.cart'))->assertOk()->assertSee('Nasi Ayam');
        $response = $this->post(route('users.checkout'));

        $order = Order::with('items')->firstOrFail();
        $response->assertRedirect(route('users.orders.confirmation', $order));
        $this->assertSame('pending', $order->status);
        $this->assertSame('Nasi Ayam', $order->items->sole()->menu_name);
        $this->assertSame(1, $order->items->sole()->quantity);
        $this->assertSame('22000.00', $order->total);

        $menu->update(['name' => 'Nama Menu Diubah', 'price' => 25000]);

        $this->get(route('users.orders'))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('Nasi Ayam')
            ->assertDontSee('Nama Menu Diubah')
            ->assertSee('Rp 22.000');
    }

    public function test_checkout_rejects_an_empty_cart(): void
    {
        $this->from(route('users.cart'))
            ->post(route('users.checkout'))
            ->assertRedirect(route('users.cart'))
            ->assertSessionHasErrors('cart');

        $this->assertDatabaseCount('orders', 0);
    }
}
