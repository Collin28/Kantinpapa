<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_is_redirected_to_menu(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@campus.ac.id',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('menu.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'budi@campus.ac.id',
            'role' => UserRole::User->value,
            'status' => 'active',
        ]);
    }

    public function test_register_validates_password_minimum_and_confirmation(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Budi',
            'email' => 'budi@campus.ac.id',
            'password' => '12345',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_user_can_login_and_is_redirected_to_menu(): void
    {
        $user = User::factory()->create([
            'email' => 'budi@campus.ac.id',
            'password' => 'password',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'budi@campus.ac.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('menu.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_login_and_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@kantin.id',
            'password' => 'password',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@kantin.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_suspended_user_cannot_login(): void
    {
        User::factory()->suspended()->create([
            'email' => 'suspended@campus.ac.id',
            'password' => 'password',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'suspended@campus.ac.id',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_suspended_user_is_logged_out_by_active_middleware(): void
    {
        $user = User::factory()->suspended()->create();

        $response = $this->actingAs($user)->get(route('cart.index'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_regular_user_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertStatus(403);
    }

    public function test_guest_is_redirected_to_login_for_protected_routes(): void
    {
        $this->get(route('cart.index'))->assertRedirect(route('login'));
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('menu.index'));
        $this->assertGuest();
    }
}
