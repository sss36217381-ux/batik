<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected User $cashierUser;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);

        $cashierRole = Role::create([
            'name' => 'penjualan',
            'display_name' => 'Kasir Penjualan',
        ]);

        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        $this->cashierUser = User::create([
            'name' => 'Kasir User',
            'email' => 'kasir@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $cashierRole->id,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_access_user_management(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/users');
        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Pengguna');
    }

    public function test_cashier_is_forbidden_from_user_management(): void
    {
        $response = $this->actingAs($this->cashierUser)->get('/users');
        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->cashierUser)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Operasional ERP');
    }
}
