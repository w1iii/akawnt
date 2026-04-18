<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AdminWhitelist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = Admin::factory()->create();
        AdminWhitelist::create(['email' => $admin->email]);
        $this->actingAs($admin, 'admin');
    }

    public function test_can_view_admin_list(): void
    {
        $response = $this->get(route('admin.management.index'));

        $response->assertStatus(200);
        $response->assertSee('Admin Management');
    }

    public function test_can_create_admin(): void
    {
        $adminData = [
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('admin.management.store'), $adminData);

        $response->assertRedirect(route('admin.management.index'));
        $this->assertDatabaseHas('admins', [
            'name' => 'Test Admin',
            'email' => 'test@example.com',
        ]);
    }

    public function test_create_admin_validation_fails_with_invalid_email(): void
    {
        $adminData = [
            'name' => 'Test Admin',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('admin.management.store'), $adminData);

        $response->assertSessionHasErrors('email');
    }

    public function test_create_admin_validation_fails_with_duplicate_email(): void
    {
        Admin::factory()->create(['email' => 'existing@example.com']);

        $adminData = [
            'name' => 'Test Admin',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('admin.management.store'), $adminData);

        $response->assertSessionHasErrors('email');
    }

    public function test_can_view_edit_admin_form(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->get(route('admin.management.edit', $admin));

        $response->assertStatus(200);
        $response->assertSee($admin->name);
        $response->assertSee($admin->email);
    }

    public function test_can_update_admin(): void
    {
        $admin = Admin::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->put(route('admin.management.update', $admin), $updateData);

        $response->assertRedirect(route('admin.management.index'));
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_can_update_admin_with_new_password(): void
    {
        $admin = Admin::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => $admin->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->put(route('admin.management.update', $admin), $updateData);

        $response->assertRedirect(route('admin.management.index'));
        $this->assertTrue(\Hash::check('newpassword123', $admin->fresh()->password));
    }

    public function test_can_delete_admin(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->delete(route('admin.management.destroy', $admin));

        $response->assertRedirect(route('admin.management.index'));
        $this->assertDatabaseMissing('admins', ['id' => $admin->id]);
    }

    public function test_can_search_admins(): void
    {
        Admin::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        Admin::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $response = $this->get(route('admin.management.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('john@example.com');
    }

    public function test_can_filter_admins_by_verified(): void
    {
        Admin::factory()->create(['email_verified_at' => now()]);
        Admin::factory()->create(['email_verified_at' => null]);

        $response = $this->get(route('admin.management.index', ['filter' => 'verified']));

        $response->assertStatus(200);
        $response->assertSee('Verified');
    }

    public function test_can_filter_admins_by_unverified(): void
    {
        Admin::factory()->create(['email_verified_at' => now()]);
        Admin::factory()->create(['email_verified_at' => null]);

        $response = $this->get(route('admin.management.index', ['filter' => 'unverified']));

        $response->assertStatus(200);
        $response->assertSee('Unverified');
    }
}
