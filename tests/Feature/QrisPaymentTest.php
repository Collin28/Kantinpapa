<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use App\Services\QrisSimulationGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrisPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_and_simulate_qris_payment(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create(['price' => 15000, 'stock' => 5]);

        $this->actingAs($user)->post(route('cart.store', $menu), ['qty' => 2]);
        $this->actingAs($user)->get(route('checkout.payment'))->assertStatus(200);
        $this->actingAs($user)->post(route('checkout.store'), [
            'checkout_token' => session('checkout_token'),
        ]);

        $order = Order::with('payment')->firstOrFail();
        $this->assertNotNull($order->expires_at);
        $this->assertSame('QRIS-'.$order->order_number, $order->payment->provider_ref);

        $this->actingAs($user)
            ->get(route('orders.pay', $order))
            ->assertStatus(200)
            ->assertSee($order->order_number)
            ->assertSee($order->formattedTotal());

        $this->actingAs($user)
            ->post(route('orders.pay.simulate', $order))
            ->assertRedirect(route('orders.confirmed', $order));

        $this->assertSame(PaymentStatus::Paid, $order->fresh()->payment_status);
        $this->assertSame(OrderStatus::Paid, $order->fresh()->order_status);
        $this->assertNotNull($order->fresh()->paid_at);
    }

    public function test_qris_webhook_verifies_signature_and_is_idempotent(): void
    {
        $order = Order::factory()->create([
            'order_number' => 'KTG-555001',
            'subtotal' => 20000,
            'tax_amount' => 2000,
            'total' => 22000,
        ]);
        Payment::create([
            'order_id' => $order->id,
            'method' => 'qris',
            'provider_ref' => 'QRIS-KTG-555001',
            'amount' => 22000,
            'status' => PaymentStatus::Pending,
        ]);

        $payload = json_encode([
            'order_number' => 'KTG-555001',
            'provider_ref' => 'QRIS-KTG-555001',
            'amount' => 22000,
            'status' => 'paid',
        ]);

        // Invalid signature -> 401
        $this->postJson(route('webhooks.qris'), json_decode($payload, true), [
            'X-Qris-Signature' => 'invalid-signature',
        ])->assertStatus(401);

        $gateway = app(QrisSimulationGateway::class);
        $sig = $gateway->signPayload($payload);

        // Valid signed webhook -> 200 & paid
        $this->call('POST', route('webhooks.qris'), [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_QRIS_SIGNATURE' => $sig,
        ], $payload)->assertStatus(200)->assertJson(['status' => 'paid']);

        $this->assertSame(PaymentStatus::Paid, $order->fresh()->payment_status);
        $this->assertSame(OrderStatus::Paid, $order->fresh()->order_status);

        // Idempotent replay -> 200 already_paid
        $this->call('POST', route('webhooks.qris'), [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_QRIS_SIGNATURE' => $sig,
        ], $payload)->assertStatus(200)->assertJson(['status' => 'already_paid']);
    }

    public function test_overdue_pending_orders_auto_expire_and_restore_stock(): void
    {
        $menu = Menu::factory()->create(['stock' => 3]);
        $order = Order::factory()->create([
            'expires_at' => now()->subMinute(),
        ]);
        OrderItem::factory()->for($order)->for($menu)->create([
            'menu_name' => $menu->name,
            'qty' => 4,
            'unit_price' => 10000,
            'line_total' => 40000,
        ]);
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => 'qris',
            'provider_ref' => 'QRIS-'.$order->order_number,
            'amount' => $order->total,
            'status' => PaymentStatus::Pending,
        ]);

        $this->artisan('orders:expire-pending')->assertExitCode(0);

        $this->assertSame(OrderStatus::Cancelled, $order->fresh()->order_status);
        $this->assertSame(PaymentStatus::Failed, $payment->fresh()->status);
        $this->assertSame(7, $menu->fresh()->stock);

        // Re-running command does not restore stock a second time
        $this->artisan('orders:expire-pending')->assertExitCode(0);
        $this->assertSame(7, $menu->fresh()->stock);
    }
}
