<?php

namespace Tests\Feature;

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

        foreach (['cart.index', 'cart.empty', 'orders.index', 'orders.confirmed'] as $name) {
            $this->actingAs($user)->get(route($name))->assertStatus(200);
        }
    }

    public function test_admin_routes_render_for_admin_user(): void
    {
        $admin = User::factory()->admin()->create();

        foreach (['admin.dashboard', 'admin.orders.index', 'admin.menus.index', 'admin.users.index'] as $name) {
            $this->actingAs($admin)->get(route($name))->assertStatus(200);
        }
    }
}
