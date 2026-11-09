<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MasterDataValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);

        $this->adminUser = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);
    }

    public function test_product_creation_requires_mandatory_fields(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('products.store'), []);

        $response->assertSessionHasErrors(['code', 'name', 'motif_type', 'cost_price', 'selling_price', 'stock']);
    }

    public function test_product_code_must_be_unique(): void
    {
        Product::create([
            'code' => 'BTK-TEST-01',
            'name' => 'Batik Gentongan Asli',
            'motif_type' => 'Gentongan',
            'size' => '200 x 115 cm',
            'cost_price' => 500000,
            'selling_price' => 1000000,
            'stock' => 5,
            'min_stock' => 2,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->adminUser)->post(route('products.store'), [
            'code' => 'BTK-TEST-01', // Duplicate code
            'name' => 'Batik Duplikat',
            'motif_type' => 'Gentongan',
            'size' => '200 x 115 cm',
            'cost_price' => 400000,
            'selling_price' => 800000,
            'stock' => 3,
            'min_stock' => 1,
        ]);

        $response->assertSessionHasErrors(['code']);
    }

    public function test_supplier_creation_validates_eco_rating(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('suppliers.store'), [
            'code' => 'SUP-INVALID',
            'name' => 'Vendor Test',
            'eco_rating' => 10, // Must be between 1 and 5
        ]);

        $response->assertSessionHasErrors(['eco_rating']);
    }
}
