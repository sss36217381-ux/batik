<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BlackBoxEpBvaTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected User $cashierUser;

    protected User $warehouseUser;

    protected Customer $customer;

    protected Product $product;

    protected RawMaterial $rawMaterial;

    protected Supplier $supplier;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $cashierRole = Role::create(['name' => 'penjualan', 'display_name' => 'Kasir']);
        $warehouseRole = Role::create(['name' => 'gudang', 'display_name' => 'Gudang']);

        $this->adminUser = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        $this->cashierUser = User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $cashierRole->id,
            'is_active' => true,
        ]);

        $this->warehouseUser = User::create([
            'name' => 'Gudang Test',
            'email' => 'gudang@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $warehouseRole->id,
            'is_active' => true,
        ]);

        $this->customer = Customer::create([
            'code' => 'CUST-EP-01',
            'name' => 'Galeri Batik Uji',
            'customer_type' => 'retail',
        ]);

        $this->product = Product::create([
            'code' => 'BTK-BVA-01',
            'name' => 'Batik Gentongan Uji',
            'motif_type' => 'Gentongan',
            'size' => '200 x 115 cm',
            'cost_price' => 500000,
            'selling_price' => 1000000,
            'stock' => 10, // Batas stok 10 lembar
            'min_stock' => 2,
            'is_active' => true,
        ]);

        $this->rawMaterial = RawMaterial::create([
            'code' => 'RAW-BVA-01',
            'name' => 'Mori Primissima Uji',
            'category' => 'kain',
            'unit' => 'meter',
            'stock' => 50.00,
            'min_stock' => 10.00,
            'unit_price' => 35000,
            'is_eco_friendly' => true,
        ]);

        $this->supplier = Supplier::create([
            'code' => 'SUP-BVA-01',
            'name' => 'CV Sumber Kain Madura',
            'is_eco_certified' => true,
            'eco_rating' => 4.5,
        ]);
    }

    /**
     * BVA & EP: Pengujian Batas Kuantitas Transaksi Kasir POS (Modul Penjualan)
     * Nilai Batas Stok Produk = 10 lembar
     * Partisi:
     * - Invalid: Q <= 0 (Batas: 0) -> Ditolak validasi form
     * - Valid Minimum: Q = 1 -> Diterima
     * - Valid Nominal: Q = 5 -> Diterima
     * - Valid Maksimum (Batas Atas): Q = 10 (habis pas) -> Diterima
     * - Invalid (Melebihi Stok): Q = 11 (Batas Atas + 1) -> Ditolak aturan stok
     */
    public function test_bva_cashier_quantity_boundaries(): void
    {
        // 1. Uji Batas Bawah Invalid: Quantity = 0 (Batas min - 1)
        $resInvalidZero = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 0,
            'payment_method' => 'cash',
        ]);
        $resInvalidZero->assertSessionHasErrors(['quantity']);

        // 2. Uji Batas Bawah Valid: Quantity = 1 (Batas min)
        $resValidMin = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'payment_method' => 'cash',
        ]);
        $resValidMin->assertRedirect(route('sales.index'));
        $this->assertEquals(9, $this->product->fresh()->stock);

        // 3. Uji Batas Atas Invalid: Quantity = 10 (Stok tersisa 9, jadi 9 + 1 = 10 adalah melebihi stok)
        $resInvalidExceed = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 10,
            'payment_method' => 'cash',
        ]);
        $resInvalidExceed->assertSessionHas('error');
        $this->assertEquals(9, $this->product->fresh()->stock);

        // 4. Uji Batas Atas Valid: Quantity = 9 (Menghabiskan seluruh stok yang tersisa tepat 0)
        $resValidExact = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 9,
            'payment_method' => 'cash',
        ]);
        $resValidExact->assertRedirect(route('sales.index'));
        $this->assertEquals(0, $this->product->fresh()->stock);
    }

    /**
     * BVA & EP: Pengujian Batas Nilai Diskon Kasir POS
     * Subtotal = 1 * 1.000.000 = Rp 1.000.000
     * Partisi:
     * - Invalid: Diskon < 0 (contoh: -1000) -> Ditolak validasi form
     * - Valid Minimum: Diskon = 0 -> Diterima (Harga normal)
     * - Valid Maksimum: Diskon = 1.000.000 (100% diskon, bayar 0) -> Diterima
     * - Invalid (Melebihi Total Belanja): Diskon = 1.000.001 -> Ditolak logika bisnis
     */
    public function test_bva_cashier_discount_boundaries(): void
    {
        // 1. Uji Batas Bawah Invalid: Diskon Negatif (-1)
        $resNeg = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'payment_method' => 'cash',
            'discount_amount' => -1,
        ]);
        $resNeg->assertSessionHasErrors(['discount_amount']);

        // 2. Uji Batas Atas Invalid: Diskon Melebihi Subtotal (Rp 1.000.001 vs Subtotal Rp 1.000.000)
        $resExceed = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'payment_method' => 'cash',
            'discount_amount' => 1000001,
        ]);
        $resExceed->assertSessionHas('error');

        // 3. Uji Batas Atas Valid: Diskon Tepat Sebesar Subtotal (Rp 1.000.000)
        $resFullDisc = $this->actingAs($this->cashierUser)->post(route('sales.store'), [
            'customer_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'payment_method' => 'cash',
            'discount_amount' => 1000000,
        ]);
        $resFullDisc->assertRedirect(route('sales.index'));
        $this->assertDatabaseHas('sales', [
            'total_amount' => 1000000,
            'discount_amount' => 1000000,
            'grand_total' => 0,
        ]);
    }

    /**
     * BVA & EP: Pengujian Batas Mutasi Keluar Gudang (Stock Opname Adjustment)
     * Stok Produk = 10 lembar
     * Partisi:
     * - Invalid: Quantity <= 0 (contoh: 0, -5) -> Ditolak validasi form min:0.01
     * - Valid: Quantity = 10 (mengurangi seluruh stok) -> Diterima
     * - Invalid: Quantity = 11 (melebihi stok gudang) -> Ditolak aturan batas stok
     */
    public function test_bva_inventory_adjustment_boundaries(): void
    {
        // 1. Uji Invalid: Kuantitas 0
        $resZero = $this->actingAs($this->warehouseUser)->post(route('inventory.adjust'), [
            'item_type' => 'product',
            'item_id' => $this->product->id,
            'movement_type' => 'out',
            'quantity' => 0,
            'notes' => 'Uji batas 0',
        ]);
        $resZero->assertSessionHasErrors(['quantity']);

        // 2. Uji Invalid: Kuantitas Melebihi Stok (11 lembar saat stok = 10)
        $resExceed = $this->actingAs($this->warehouseUser)->post(route('inventory.adjust'), [
            'item_type' => 'product',
            'item_id' => $this->product->id,
            'movement_type' => 'out',
            'quantity' => 11,
            'notes' => 'Uji melebihi stok',
        ]);
        $resExceed->assertSessionHas('error');
        $this->assertEquals(10, $this->product->fresh()->stock);

        // 3. Uji Valid: Kuantitas Tepat Sama dengan Stok Fisik (10 lembar)
        $resValid = $this->actingAs($this->warehouseUser)->post(route('inventory.adjust'), [
            'item_type' => 'product',
            'item_id' => $this->product->id,
            'movement_type' => 'out',
            'quantity' => 10,
            'notes' => 'Uji mutasi tepat habis',
        ]);
        $resValid->assertRedirect(route('inventory.index'));
        $this->assertEquals(0, $this->product->fresh()->stock);
    }

    /**
     * BVA & EP: Pengujian Batas Form Master Produk & Bahan Baku
     */
    public function test_bva_master_data_boundaries(): void
    {
        // Harga jual negatif ditolak
        $resNegPrice = $this->actingAs($this->adminUser)->post(route('products.store'), [
            'code' => 'BTK-NEG-01',
            'name' => 'Batik Harga Negatif',
            'motif_type' => 'Aromanis',
            'size' => '200 x 115 cm',
            'cost_price' => 100000,
            'selling_price' => -50000,
            'stock' => 1,
            'min_stock' => 1,
        ]);
        $resNegPrice->assertSessionHasErrors(['selling_price']);

        // Stok negatif ditolak
        $resNegStock = $this->actingAs($this->adminUser)->post(route('products.store'), [
            'code' => 'BTK-NEG-02',
            'name' => 'Batik Stok Negatif',
            'motif_type' => 'Aromanis',
            'size' => '200 x 115 cm',
            'cost_price' => 100000,
            'selling_price' => 200000,
            'stock' => -1,
            'min_stock' => 1,
        ]);
        $resNegStock->assertSessionHasErrors(['stock']);
    }
}
