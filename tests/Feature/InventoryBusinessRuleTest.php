<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InventoryBusinessRuleTest extends TestCase
{
    use RefreshDatabase;

    protected User $cashierUser;
    protected Customer $customer;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $cashierRole = Role::create([
            'name' => 'penjualan',
            'display_name' => 'Kasir Penjualan',
        ]);

        $this->cashierUser = User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $cashierRole->id,
            'is_active' => true,
        ]);

        $this->customer = Customer::create([
            'code' => 'CUST-001',
            'name' => 'Pelanggan Uji',
            'customer_type' => 'retail',
        ]);

        $this->product = Product::create([
            'code' => 'BTK-UJI-01',
            'name' => 'Batik Sekar Jagat',
            'motif_type' => 'Sekar Jagat',
            'size' => '200 x 115 cm',
            'cost_price' => 300000,
            'selling_price' => 600000,
            'stock' => 5, // Hanya ada 5 lembar
            'min_stock' => 2,
            'is_active' => true,
        ]);
    }

    public function test_sale_cannot_exceed_available_product_stock(): void
    {
        $response = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 10, // Melebihi stok yang ada (5)
            'payment_method' => 'cash',
        ]);

        // Harus gagal dan menampilkan error notifikasi
        $response->assertSessionHas('error');
        $this->assertEquals(5, $this->product->fresh()->stock); // Stok tidak boleh berkurang
    }

    public function test_sale_successfully_reduces_product_stock_and_calculates_total(): void
    {
        $response = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 2, // 2 lembar * 600.000 = 1.200.000
            'payment_method' => 'qris',
            'discount_amount' => 50000, // Diskon 50.000 -> Grand Total = 1.150.000
        ]);

        $response->assertRedirect(route('sales.index'));
        $response->assertSessionHas('success');

        // Verifikasi stok berkurang menjadi 3
        $this->assertEquals(3, $this->product->fresh()->stock);

        // Verifikasi data penjualan tercatat di database
        $this->assertDatabaseHas('sales', [
            'customer_id' => $this->customer->id,
            'total_amount' => 1200000,
            'discount_amount' => 50000,
            'grand_total' => 1150000,
            'payment_method' => 'qris',
        ]);
    }
}
