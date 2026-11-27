<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_cart_redirects_from_checkout_review_and_payment(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('checkout.review'))->assertRedirect(route('cart.index'));
        $this->actingAs($user)->get(route('checkout.payment'))->assertRedirect(route('cart.index'));
    }

    public function test_checkout_creates_order_items_payment_calculates_tax_and_decrements_stock(): void
    {
        $user = User::factory()->create();
        $menuA = Menu::factory()->create(['name' => 'Nasi Ayam', 'price' => 18000, 'stock' => 5]);
        $menuB = Menu::factory()->create(['name' => 'Es Teh', 'price' => 5000, 'stock' => 10]);

        $this->actingAs($user)->post(route('cart.store', $menuA), ['qty' => 2]); // 36.000
        $this->actingAs($user)->post(route('cart.store', $menuB), ['qty' => 2]); // 10.000

        $this->actingAs($user)->get(route('checkout.review'))->assertStatus(200)->assertSee('Rp 50.600');
        $this->actingAs($user)->get(route('checkout.payment'))->assertStatus(200)->assertSee('Rp 50.600');

        $token = session('checkout_token');
        $this->assertNotEmpty($token);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'checkout_token' => $token,
        ]);

        $order = Order::firstOrFail();
        $response->assertRedirect(route('orders.confirmed', $order));

        $this->assertSame(46000, $order->subtotal);
        $this->assertSame(4600, $order->tax_amount);
        $this->assertSame(50600, $order->total);
        $this->assertSame(PaymentStatus::Pending, $order->payment_status);
        $this->assertSame(OrderStatus::Pending, $order->order_status);
        $this->assertCount(2, $order->items);
        $this->assertNotNull($order->payment);
        $this->assertSame(50600, $order->payment->amount);

        $this->assertSame(3, $menuA->fresh()->stock);
        $this->assertSame(8, $menuB->fresh()->stock);
        $this->assertEmpty(session('cart', []));

        // Snapshot price stays intact even when menu price changes later
        $menuA->update(['price' => 25000]);
        $this->assertSame(18000, $order->items()->where('menu_id', $menuA->id)->first()->unit_price);
    }

    public function test_checkout_fails_when_stock_becomes_insufficient(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create(['price' => 15000, 'stock' => 5]);

        $this->actingAs($user)->post(route('cart.store', $menu), ['qty' => 4]);
        $this->actingAs($user)->get(route('checkout.payment'))->assertStatus(200);
        $token = session('checkout_token');

        // Stock drops after payment page loaded
        $menu->update(['stock' => 2]);

        $this->actingAs($user)
            ->post(route('checkout.store'), ['checkout_token' => $token])
            ->assertSessionHasErrors('cart');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(2, $menu->fresh()->stock);
    }

    public function test_double_submit_with_same_checkout_token_only_creates_one_order(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create(['price' => 15000, 'stock' => 10]);

        $this->actingAs($user)->post(route('cart.store', $menu), ['qty' => 2]);
        $this->actingAs($user)->get(route('checkout.payment'))->assertStatus(200);
        $token = session('checkout_token');

        $this->actingAs($user)->post(route('checkout.store'), ['checkout_token' => $token])
            ->assertRedirect();

        // Second submission with the same token
        $this->actingAs($user)->post(route('checkout.store'), ['checkout_token' => $token])
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseCount('orders', 1);
        $this->assertSame(8, $menu->fresh()->stock);
    }

    public function test_suspended_user_is_blocked_from_checkout(): void
    {
        $user = User::factory()->suspended()->create();

        $this->actingAs($user)
            ->get(route('checkout.review'))
            ->assertRedirect(route('login'));
    }
}
