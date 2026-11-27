<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_orders(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user)->get(route('admin.orders.index'))->assertStatus(403);
        $this->actingAs($user)
            ->patch(route('admin.orders.update-status', $order), ['status' => 'paid'])
            ->assertStatus(403);
    }

    public function test_admin_can_filter_orders_by_status(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create(['name' => 'Budi Santoso']);

        $pending = Order::factory()->for($customer)->create(['order_number' => 'KTG-100001']);
        $paid = Order::factory()->for($customer)->paid()->create(['order_number' => 'KTG-100002']);

        $this->actingAs($admin)
            ->get(route('admin.orders.index', ['status' => 'pending']))
            ->assertStatus(200)
            ->assertSee($pending->order_number)
            ->assertDontSee($paid->order_number);
    }

    public function test_admin_can_advance_order_through_valid_status_lifecycle(): void
    {
        $admin = User::factory()->admin()->create();
        $order = Order::factory()->create();
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => 'qris',
            'amount' => $order->total,
            'status' => PaymentStatus::Pending,
        ]);

        // pending -> paid
        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $order), ['status' => 'paid'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $order->refresh();
        $payment->refresh();
        $this->assertSame(OrderStatus::Paid, $order->order_status);
        $this->assertSame(PaymentStatus::Paid, $order->payment_status);
        $this->assertNotNull($order->paid_at);
        $this->assertSame(PaymentStatus::Paid, $payment->status);
        $this->assertNotNull($payment->paid_at);

        // paid -> preparing -> ready -> completed
        foreach (['preparing', 'ready', 'completed'] as $next) {
            $this->actingAs($admin)
                ->patch(route('admin.orders.update-status', $order), ['status' => $next])
                ->assertRedirect()
                ->assertSessionHas('success');

            $this->assertSame(OrderStatus::from($next), $order->fresh()->order_status);
        }
    }

    public function test_invalid_status_transitions_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $pending = Order::factory()->create();
        $completed = Order::factory()->completed()->create();

        // pending cannot jump straight to ready
        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $pending), ['status' => 'ready'])
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertSame(OrderStatus::Pending, $pending->fresh()->order_status);

        // completed is final
        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $completed), ['status' => 'cancelled'])
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertSame(OrderStatus::Completed, $completed->fresh()->order_status);
    }

    public function test_cancelling_order_restores_stock_once_and_is_idempotent(): void
    {
        $admin = User::factory()->admin()->create();
        $menu = Menu::factory()->create(['stock' => 4]);
        $order = Order::factory()->create();
        OrderItem::factory()->for($order)->for($menu)->create([
            'menu_name' => $menu->name,
            'qty' => 3,
            'unit_price' => 10000,
            'line_total' => 30000,
        ]);

        // Cancel once -> stock goes from 4 to 7
        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $order), ['status' => 'cancelled'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame(OrderStatus::Cancelled, $order->fresh()->order_status);
        $this->assertSame(7, $menu->fresh()->stock);

        // Second cancel attempt -> rejected, stock remains 7
        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $order), ['status' => 'cancelled'])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame(7, $menu->fresh()->stock);
    }
}
