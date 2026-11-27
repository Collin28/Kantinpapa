<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_users_endpoints(): void
    {
        $user = User::factory()->create();
        $target = User::factory()->create();

        $this->actingAs($user)->get(route('admin.users.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.users.edit', $target))->assertStatus(403);
        $this->actingAs($user)->patch(route('admin.users.suspend', $target))->assertStatus(403);
        $this->actingAs($user)->delete(route('admin.users.destroy', $target))->assertStatus(403);
    }

    public function test_admin_can_view_stats_search_and_filter_users(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Admin Utama']);
        $budi = User::factory()->create(['name' => 'Budi Santoso', 'email' => 'budi@campus.ac.id']);
        $dewi = User::factory()->suspended()->create(['name' => 'Dewi Susanti', 'email' => 'dewi@campus.ac.id']);

        Order::factory()->for($budi)->paid()->create(['total' => 45000]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertStatus(200)
            ->assertSee('Budi Santoso')
            ->assertSee('Rp 45.000')
            ->assertSee('Dewi Susanti')
            ->assertSee('Suspended');

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['q' => 'dewi']))
            ->assertStatus(200)
            ->assertSee('Dewi Susanti')
            ->assertDontSee('Budi Santoso');

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['role' => 'admin']))
            ->assertStatus(200)
            ->assertSee('Admin Utama')
            ->assertDontSee('Budi Santoso');
    }

    public function test_admin_can_edit_suspend_and_restore_user(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create(['name' => 'Budi', 'email' => 'budi@campus.ac.id']);

        $this->actingAs($admin)
            ->put(route('admin.users.update', $user), [
                'name' => 'Budi Updated',
                'email' => 'budi.new@campus.ac.id',
                'role' => UserRole::User->value,
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->assertSame('Budi Updated', $user->fresh()->name);

        // Suspend
        $this->actingAs($admin)
            ->patch(route('admin.users.suspend', $user))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame('suspended', $user->fresh()->status);

        // Suspended user loses access immediately
        $this->actingAs($user->fresh())
            ->get(route('cart.index'))
            ->assertRedirect(route('login'));

        // Restore
        $this->actingAs($admin)
            ->patch(route('admin.users.restore', $user))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame('active', $user->fresh()->status);
    }

    public function test_admin_cannot_suspend_demote_or_delete_self(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch(route('admin.users.suspend', $admin))
            ->assertSessionHas('error');
        $this->assertSame('active', $admin->fresh()->status);

        $this->actingAs($admin)
            ->put(route('admin.users.update', $admin), [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => UserRole::User->value,
                'status' => 'active',
            ])
            ->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->isAdmin());

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_cannot_delete_user_with_orders_but_can_delete_user_without_orders(): void
    {
        $admin = User::factory()->admin()->create();
        $userWithOrder = User::factory()->create();
        $userWithoutOrder = User::factory()->create();

        Order::factory()->for($userWithOrder)->create();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $userWithOrder))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $userWithOrder->id]);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $userWithoutOrder))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $userWithoutOrder->id]);
    }
}
