<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_adding_to_cart(): void
    {
        $menu = Menu::factory()->create();

        $this->post(route('cart.store', $menu))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_add_update_and_remove_items_in_cart(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create(['name' => 'Nasi Goreng', 'price' => 15000, 'stock' => 5]);

        $this->actingAs($user)
            ->post(route('cart.store', $menu), ['qty' => 2])
            ->assertRedirect();

        $this->actingAs($user)
            ->get(route('cart.index'))
            ->assertStatus(200)
            ->assertSee('Nasi Goreng')
            ->assertSee('Rp 30.000')
            ->assertSee('Rp 3.000')
            ->assertSee('Rp 33.000');

        // Update qty capped at stock (5)
        $this->actingAs($user)
            ->patch(route('cart.update', $menu), ['qty' => 10])
            ->assertRedirect(route('cart.index'));

        $this->assertSame(5, session('cart')[$menu->id]);

        // Update qty to 0 removes item
        $this->actingAs($user)
            ->patch(route('cart.update', $menu), ['qty' => 0])
            ->assertRedirect(route('cart.index'));

        $this->assertArrayNotHasKey($menu->id, session('cart', []));
    }

    public function test_adding_sold_out_or_unavailable_menu_is_rejected(): void
    {
        $user = User::factory()->create();
        $soldOut = Menu::factory()->outOfStock()->create(['name' => 'Soto Ayam']);
        $unavailable = Menu::factory()->unavailable()->create(['name' => 'Bakso']);

        $this->actingAs($user)
            ->post(route('cart.store', $soldOut))
            ->assertSessionHas('error');

        $this->actingAs($user)
            ->post(route('cart.store', $unavailable))
            ->assertSessionHas('error');

        $this->assertEmpty(session('cart', []));
    }

    public function test_user_can_destroy_cart_item(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create(['stock' => 5]);

        $this->actingAs($user)->post(route('cart.store', $menu));
        $this->actingAs($user)
            ->delete(route('cart.destroy', $menu))
            ->assertRedirect(route('cart.index'));

        $this->assertEmpty(session('cart', []));

        $this->actingAs($user)
            ->get(route('cart.index'))
            ->assertStatus(200)
            ->assertSee('Your Cart Is Empty');
    }

    public function test_cart_sanitizes_deleted_and_stock_reduced_items_and_matches_badge_count(): void
    {
        $user = User::factory()->create();
        $deletedMenu = Menu::factory()->create(['name' => 'Menu Hilang', 'stock' => 5]);
        $limitedMenu = Menu::factory()->create(['name' => 'Menu Terbatas', 'stock' => 4, 'price' => 10000]);

        $this->actingAs($user)->post(route('cart.store', $deletedMenu), ['qty' => 2]);
        $this->actingAs($user)->post(route('cart.store', $limitedMenu), ['qty' => 4]);

        $deletedMenu->delete();
        $limitedMenu->update(['stock' => 2]);

        // Before visiting /cart, navbar count on /menu already reflects sanitized qty (2)
        $response = $this->actingAs($user)->get(route('menu.index'));
        $response->assertStatus(200);
        $this->assertSame(2, app(CartService::class)->count());

        // Visiting /cart sanitizes session and displays warnings
        $this->actingAs($user)
            ->get(route('cart.index'))
            ->assertStatus(200)
            ->assertSee('Menu Hilang was removed because it is no longer available.')
            ->assertSee('Quantity for Menu Terbatas was adjusted to 2 due to limited stock.');

        $this->assertSame([$limitedMenu->id => 2], session('cart'));
    }
}
