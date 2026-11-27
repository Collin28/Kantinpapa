<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_menu(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('menu.index'));
    }

    public function test_public_routes_render_successfully(): void
    {
        foreach (['menu.index', 'login', 'register'] as $name) {
            $this->get(route($name))->assertStatus(200);
        }
    }

    public function test_customer_routes_render_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();

        $this->actingAs($user)->get(route('cart.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('orders.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('orders.confirmed', $order))->assertStatus(200);
    }

    public function test_admin_routes_render_for_admin_user(): void
    {
        $admin = User::factory()->admin()->create();

        foreach (['admin.dashboard', 'admin.orders.index', 'admin.menus.index', 'admin.users.index'] as $name) {
            $this->actingAs($admin)->get(route($name))->assertStatus(200);
        }
    }
}
