<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_real_aggregated_statistics(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        Menu::factory()->count(2)->create(['is_available' => true, 'stock' => 10]);
        Menu::factory()->outOfStock()->create(['is_available' => true]);

        // Paid completed order today -> counted in Total Revenue, Today Revenue, Total Orders, Completed
        Order::factory()->for($user)->completed()->create([
            'total' => 50000,
            'created_at' => now('Asia/Jakarta'),
        ]);

        // Paid order yesterday -> counted in Total Revenue & Total Orders, NOT Today Revenue
        Order::factory()->for($user)->paid()->create([
            'total' => 30000,
            'created_at' => now('Asia/Jakarta')->subDay(),
        ]);

        // Pending order today -> counted in Pending Orders & Total Orders & today orders count, NOT Revenue
        Order::factory()->for($user)->create([
            'total' => 25000,
            'created_at' => now('Asia/Jakarta'),
        ]);

        // Paid but Cancelled order -> NOT counted in Revenue
        Order::factory()->for($user)->create([
            'total' => 40000,
            'payment_status' => PaymentStatus::Paid,
            'order_status' => OrderStatus::Cancelled,
            'created_at' => now('Asia/Jakarta'),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee('Rp 80.000') // 50.000 + 30.000
            ->assertSee('Rp 50.000') // today's revenue
            ->assertSee('3 orders today')
            ->assertSee('25% success rate')
            ->assertSee('2 available')
            ->assertDontSee('Rp 12.480.000');
    }

    public function test_popular_today_prioritizes_most_ordered_available_menus_today(): void
    {
        $user = User::factory()->create();
        $menuLeast = Menu::factory()->create(['name' => 'Menu Jarang', 'stock' => 10]);
        $menuMost = Menu::factory()->create(['name' => 'Menu Terlaris', 'stock' => 10]);
        $menuCancelled = Menu::factory()->create(['name' => 'Menu Batal', 'stock' => 10]);

        $order = Order::factory()->for($user)->paid()->create([
            'created_at' => now('Asia/Jakarta'),
        ]);
        OrderItem::factory()->for($order)->for($menuMost)->create(['qty' => 7]);
        OrderItem::factory()->for($order)->for($menuLeast)->create(['qty' => 1]);

        $cancelledOrder = Order::factory()->for($user)->create([
            'order_status' => OrderStatus::Cancelled,
            'created_at' => now('Asia/Jakarta'),
        ]);
        OrderItem::factory()->for($cancelledOrder)->for($menuCancelled)->create(['qty' => 20]);

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $popularMenus = $response->viewData('popularMenus');
        $this->assertSame('Menu Terlaris', $popularMenus->first()->name);
    }
}
