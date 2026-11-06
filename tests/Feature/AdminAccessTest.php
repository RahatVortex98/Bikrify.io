<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true, 'password' => 'existing-password']);
    }

    public function test_guests_are_redirected_to_login_for_all_admin_pages(): void
    {
        foreach (['/admin', '/admin/leads', '/admin/prospects', '/admin/customers', '/admin/customers/new', '/admin/blog/posts', '/admin/blog/posts/create', '/admin/homepage/what-we-build', '/admin/homepage/what-we-build/create', '/admin/users', '/admin/users/create'] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }
        $this->get('/admin/login')->assertOk()->assertSee('Admin sign in');
    }

    public function test_admin_can_login_and_logout_with_a_browser_session(): void
    {
        $admin = $this->admin();
        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'existing-password'])->assertRedirect('/admin/leads');
        $this->assertAuthenticatedAs($admin);
        $this->get('/admin/users')->assertOk()->assertSee($admin->email);
        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
        $this->get('/admin/users')->assertRedirect('/admin/login');
    }

    public function test_invalid_credentials_and_non_admins_cannot_login(): void
    {
        $admin = $this->admin();
        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $user = User::factory()->create(['password' => 'existing-password']);
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'existing-password'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->actingAs($user)->get('/admin/users')->assertForbidden();
        $this->actingAs($user)->post('/admin/users', [])->assertForbidden();
    }

    public function test_admin_can_create_an_admin_and_change_their_password(): void
    {
        $this->actingAs($this->admin())->post('/admin/users', [
            'name' => 'Second admin', 'email' => 'second@example.com',
            'password' => 'new-admin-password', 'password_confirmation' => 'new-admin-password',
        ])->assertRedirect('/admin/users');
        $user = User::where('email', 'second@example.com')->firstOrFail();
        $this->assertTrue($user->is_admin);
        $this->assertTrue(Hash::check('new-admin-password', $user->password));
        $this->put('/admin/users/'.$user->id, [
            'name' => $user->name, 'email' => $user->email,
            'password' => 'changed-admin-password', 'password_confirmation' => 'changed-admin-password',
        ])->assertRedirect('/admin/users');
        $this->assertTrue(Hash::check('changed-admin-password', $user->fresh()->password));
        $this->assertFalse(Hash::check('new-admin-password', $user->fresh()->password));
        $this->post('/admin/logout');
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'changed-admin-password'])->assertRedirect('/admin/leads');
        $this->assertAuthenticatedAs($user);
    }

    public function test_blank_password_keeps_existing_hash_and_validation_rejects_bad_input(): void
    {
        $admin = $this->admin();
        $hash = $admin->password;
        $this->actingAs($admin)->put('/admin/users/'.$admin->id, ['name' => 'Updated', 'email' => $admin->email, 'password' => ''])->assertRedirect('/admin/users');
        $this->assertSame($hash, $admin->fresh()->password);
        $this->post('/admin/users', ['name' => 'Duplicate', 'email' => $admin->email, 'password' => 'short', 'password_confirmation' => 'mismatch'])->assertSessionHasErrors(['email', 'password']);
    }
}
