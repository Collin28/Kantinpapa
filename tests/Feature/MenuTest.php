<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_catalog_displays_menus_and_sold_out_state(): void
    {
        $category = Category::factory()->create(['name' => 'Rice Bowls', 'slug' => 'rice-bowls']);
        Menu::factory()->create([
            'category_id' => $category->id,
            'name' => 'Nasi Ayam Bakar',
            'price' => 18000,
            'stock' => 12,
            'is_available' => true,
        ]);
        Menu::factory()->outOfStock()->create([
            'category_id' => $category->id,
            'name' => 'Soto Ayam',
            'price' => 15000,
        ]);

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $response->assertSee('Nasi Ayam Bakar');
        $response->assertSee('Rp 18.000');
        $response->assertSee('12 left');
        $response->assertSee('Soto Ayam');
        $response->assertSee('Sold Out');
    }

    public function test_customer_catalog_supports_search_and_category_filter(): void
    {
        $rice = Category::factory()->create(['name' => 'Rice Bowls', 'slug' => 'rice-bowls']);
        $drinks = Category::factory()->create(['name' => 'Drinks', 'slug' => 'drinks']);

        Menu::factory()->create(['category_id' => $rice->id, 'name' => 'Nasi Goreng']);
        Menu::factory()->create(['category_id' => $drinks->id, 'name' => 'Es Teh Manis']);

        $this->get(route('menu.index', ['q' => 'Nasi']))
            ->assertStatus(200)
            ->assertSee('Nasi Goreng')
            ->assertDontSee('Es Teh Manis');

        $this->get(route('menu.index', ['category' => 'drinks']))
            ->assertStatus(200)
            ->assertSee('Es Teh Manis')
            ->assertDontSee('Nasi Goreng');
    }

    public function test_admin_can_crud_and_toggle_menu_items(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Snacks', 'slug' => 'snacks']);

        // Create
        $file = UploadedFile::fake()->image('pisang.jpg');
        $this->actingAs($admin)
            ->post(route('admin.menus.store'), [
                'category_id' => $category->id,
                'name' => 'Pisang Goreng Keju',
                'description' => 'Crispy fried banana',
                'price' => 10000,
                'stock' => 20,
                'is_available' => '1',
                'image' => $file,
            ])
            ->assertRedirect(route('admin.menus.index'));

        $menu = Menu::where('name', 'Pisang Goreng Keju')->firstOrFail();
        $this->assertTrue($menu->is_available);
        $this->assertSame(20, $menu->stock);
        Storage::disk('public')->assertExists($menu->img_url);

        // Update
        $this->actingAs($admin)
            ->put(route('admin.menus.update', $menu), [
                'category_id' => $category->id,
                'name' => 'Pisang Goreng Coklat',
                'description' => 'Updated',
                'price' => 12000,
                'stock' => 15,
                'is_available' => '1',
            ])
            ->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'Pisang Goreng Coklat',
            'stock' => 15,
        ]);

        // Toggle
        $this->actingAs($admin)
            ->patch(route('admin.menus.toggle', $menu))
            ->assertRedirect();

        $this->assertFalse($menu->fresh()->is_available);

        // Delete
        $this->actingAs($admin)
            ->delete(route('admin.menus.destroy', $menu))
            ->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_non_admin_cannot_access_admin_menu_endpoints(): void
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.menus.index'))
            ->assertStatus(403);

        $this->actingAs($user)
            ->patch(route('admin.menus.toggle', $menu))
            ->assertStatus(403);
    }
}
