<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\GreenScorMetric;
use App\Models\GreenScorResult;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator Sistem',
                'description' => 'Mengelola konfigurasi sistem, hak akses pengguna, dan audit trail data.',
            ],
            [
                'name' => 'pemilik',
                'display_name' => 'Pemilik UMKM (Owner)',
                'description' => 'Melihat seluruh laporan keuangan, performa Green SCOR, dan tren penjualan.',
            ],
            [
                'name' => 'gudang',
                'display_name' => 'Bagian Gudang & Persediaan',
                'description' => 'Mengelola stok bahan baku, stok kain batik jadi, dan mutasi barang.',
            ],
            [
                'name' => 'produksi',
                'display_name' => 'Bagian Produksi Batik',
                'description' => 'Mengelola tahapan membatik, pencatatan limbah malam, dan konsumsi air.',
            ],
            [
                'name' => 'pembelian',
                'display_name' => 'Bagian Pembelian / Pengadaan',
                'description' => 'Mengelola order pembelian bahan baku ke pemasok dan verifikasi green supplier.',
            ],
            [
                'name' => 'penjualan',
                'display_name' => 'Bagian Penjualan & Kasir',
                'description' => 'Melayani transaksi pesanan batik, penagihan, dan pengiriman barang ke pelanggan.',
            ],
        ];

        $roleModels = [];
        foreach ($roles as $roleData) {
            $roleModels[$roleData['name']] = Role::create($roleData);
        }

        // 2. Default Users for each role
        $defaultPassword = Hash::make('password');

        $users = [
            [
                'name' => 'Ahmad Fauzi (Admin)',
                'email' => 'admin@batikmadura.id',
                'role_id' => $roleModels['admin']->id,
                'phone' => '081234567890',
            ],
            [
                'name' => 'Hj. Siti Aminah (Pemilik)',
                'email' => 'pemilik@batikmadura.id',
                'role_id' => $roleModels['pemilik']->id,
                'phone' => '081234567891',
            ],
            [
                'name' => 'Budi Santoso (Gudang)',
                'email' => 'gudang@batikmadura.id',
                'role_id' => $roleModels['gudang']->id,
                'phone' => '081234567892',
            ],
            [
                'name' => 'Pak Slamet (Kepala Produksi)',
                'email' => 'produksi@batikmadura.id',
                'role_id' => $roleModels['produksi']->id,
                'phone' => '081234567893',
            ],
            [
                'name' => 'Rina Kartika (Pembelian)',
                'email' => 'pembelian@batikmadura.id',
                'role_id' => $roleModels['pembelian']->id,
                'phone' => '081234567894',
            ],
            [
                'name' => 'Dewi Safitri (Penjualan)',
                'email' => 'penjualan@batikmadura.id',
                'role_id' => $roleModels['penjualan']->id,
                'phone' => '081234567895',
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $defaultPassword,
                'role_id' => $userData['role_id'],
                'phone' => $userData['phone'],
                'is_active' => true,
            ]);
        }

        // 3. Suppliers (Dummy data realistis untuk UMKM Batik Madura)
        $suppliers = [
            [
                'code' => 'SUP-001',
                'name' => 'CV Sumber Sutra Primissima',
                'contact_person' => 'H. Munir',
                'phone' => '081399887711',
                'email' => 'kontak@sumbersutra.co.id',
                'address' => 'Jl. Industri Tekstil No. 12, Surabaya',
                'is_eco_certified' => true,
                'eco_rating' => 4.80,
            ],
            [
                'code' => 'SUP-002',
                'name' => 'Koperasi Tani Indigofera Tanjungbumi',
                'contact_person' => 'Ust. Mahmud',
                'phone' => '087755663322',
                'email' => 'tanjungbumi.indigo@gmail.com',
                'address' => 'Desa Tanjungbumi, Bangkalan, Madura',
                'is_eco_certified' => true,
                'eco_rating' => 5.00,
            ],
            [
                'code' => 'SUP-003',
                'name' => 'UD Lilin Malam Lancor',
                'contact_person' => 'Cak Rozaq',
                'phone' => '085233445566',
                'email' => 'malamlancor@yahoo.com',
                'address' => 'Jl. Trunojoyo No. 45, Pamekasan, Madura',
                'is_eco_certified' => false,
                'eco_rating' => 3.20,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // 4. Customers
        $customers = [
            [
                'code' => 'CUST-001',
                'name' => 'Galeri Batik Nusantara Surabaya',
                'phone' => '081122334455',
                'email' => 'order@galerinusantara.com',
                'address' => 'Jl. Basuki Rahmat No. 88, Surabaya',
                'customer_type' => 'wholesale',
            ],
            [
                'code' => 'CUST-002',
                'name' => 'Butik Etnik Madura Grand Indonesia',
                'phone' => '081299001122',
                'email' => 'butik@etnikmadura.id',
                'address' => 'Grand Indonesia Skybridge Lt. 2, Jakarta Pusat',
                'customer_type' => 'reseller',
            ],
            [
                'code' => 'CUST-003',
                'name' => 'Ibu Ratna Dewi (Pelanggan Langsung)',
                'phone' => '087811223344',
                'email' => 'ratnadewi@gmail.com',
                'address' => 'Jl. Pemuda No. 15, Bangkalan, Madura',
                'customer_type' => 'retail',
            ],
        ];

        foreach ($customers as $cust) {
            Customer::create($cust);
        }

        // 5. Raw Materials
        $rawMaterials = [
            [
                'code' => 'RAW-001',
                'name' => 'Kain Mori Primissima Gamelan Mas',
                'category' => 'kain',
                'unit' => 'meter',
                'stock' => 250.00,
                'min_stock' => 50.00,
                'unit_price' => 35000.00,
                'is_eco_friendly' => true,
                'description' => 'Kain katun kualitas tertinggi untuk batik tulis halus gentongan.',
            ],
            [
                'code' => 'RAW-002',
                'name' => 'Malam Klowong Tawon Alami',
                'category' => 'malam',
                'unit' => 'kg',
                'stock' => 85.00,
                'min_stock' => 20.00,
                'unit_price' => 45000.00,
                'is_eco_friendly' => true,
                'description' => 'Lilin malam alami campuran damar dan getah pinus yang mudah dilorot.',
            ],
            [
                'code' => 'RAW-003',
                'name' => 'Ekstrak Pewarna Daun Tom (Indigofera Tinctoria)',
                'category' => 'pewarna_alami',
                'unit' => 'liter',
                'stock' => 40.00,
                'min_stock' => 10.00,
                'unit_price' => 75000.00,
                'is_eco_friendly' => true,
                'description' => 'Pewarna biru alami ramah lingkungan hasil fermentasi daun indigo lokal Madura.',
            ],
            [
                'code' => 'RAW-004',
                'name' => 'Ekstrak Kulit Kayu Tingi (Ceriops Tagal)',
                'category' => 'pewarna_alami',
                'unit' => 'kg',
                'stock' => 30.00,
                'min_stock' => 10.00,
                'unit_price' => 55000.00,
                'is_eco_friendly' => true,
                'description' => 'Pewarna cokelat kemerahan alami khas batik pesisir Madura.',
            ],
            [
                'code' => 'RAW-005',
                'name' => 'Pewarna Sintetis Remazol Merah RB',
                'category' => 'pewarna_sintetis',
                'unit' => 'kg',
                'stock' => 15.00,
                'min_stock' => 5.00,
                'unit_price' => 120000.00,
                'is_eco_friendly' => false,
                'description' => 'Pewarna sintetis reaktif untuk warna merah cerah ceria Madura.',
            ],
        ];

        foreach ($rawMaterials as $mat) {
            RawMaterial::create($mat);
        }

        // 6. Batik Products
        $products = [
            [
                'code' => 'BTK-GT-01',
                'name' => 'Batik Tulis Gentongan Madura Asli',
                'motif_type' => 'Gentongan Tradisional',
                'size' => '220 x 115 cm',
                'cost_price' => 850000.00,
                'selling_price' => 1650000.00,
                'stock' => 12,
                'min_stock' => 3,
                'description' => 'Mahakarya batik tulis gentongan khas Tanjungbumi Bangkalan, direndam gentong tanah liat 6 bulan dengan pewarna alami.',
                'is_active' => true,
            ],
            [
                'code' => 'BTK-AR-02',
                'name' => 'Batik Tulis Aromanis Canting Halus',
                'motif_type' => 'Aromanis Pesona Madura',
                'size' => '200 x 115 cm',
                'cost_price' => 320000.00,
                'selling_price' => 650000.00,
                'stock' => 24,
                'min_stock' => 5,
                'description' => 'Batik tulis kombinasi warna cerah berani khas Madura (merah, kuning, hijau) motif bunga floral lembut.',
                'is_active' => true,
            ],
            [
                'code' => 'BTK-SJ-03',
                'name' => 'Batik Tulis Sekar Jagat Madura',
                'motif_type' => 'Sekar Jagat Pesisiran',
                'size' => '210 x 115 cm',
                'cost_price' => 450000.00,
                'selling_price' => 900000.00,
                'stock' => 18,
                'min_stock' => 4,
                'description' => 'Motif keragaman pulau Madura yang melambangkan keindahan dan kemakmuran pesisir selat Madura.',
                'is_active' => true,
            ],
            [
                'code' => 'BTK-LC-04',
                'name' => 'Batik Tulis Monumen Lancor Pamekasan',
                'motif_type' => 'Lancor Geometris',
                'size' => '200 x 115 cm',
                'cost_price' => 280000.00,
                'selling_price' => 550000.00,
                'stock' => 8,
                'min_stock' => 5,
                'description' => 'Batik tulis dengan ornamen khas tugu Arek Lancor Pamekasan dengan pewarnaan alami tingi & tegeran.',
                'is_active' => true,
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // 7. Green SCOR Metrics Baseline (GSCOR & ANP Configuration)
        $metrics = [
            [
                'code' => 'PL-01',
                'dimension' => 'PLAN',
                'metric_name' => 'Akurasi Perencanaan Bahan Ramah Lingkungan',
                'description' => 'Persentase kesesuaian rencana pengadaan bahan alami terhadap realisasi produksi.',
                'unit' => '%',
                'target_value' => 85.00,
                'actual_value' => 78.50,
                'weight' => 0.0820,
                'normalized_score' => 76.50,
                'final_score' => 6.27,
            ],
            [
                'code' => 'PL-02',
                'dimension' => 'PLAN',
                'metric_name' => 'Efisiensi Perencanaan Kapasitas Produksi',
                'description' => 'Tingkat utilisasi kapasitas perajin canting tanpa lembur berlebih.',
                'unit' => '%',
                'target_value' => 90.00,
                'actual_value' => 82.00,
                'weight' => 0.0780,
                'normalized_score' => 80.00,
                'final_score' => 6.24,
            ],
            [
                'code' => 'SO-01',
                'dimension' => 'SOURCE',
                'metric_name' => 'Rasio Pemasok Bahan Baku Ramah Lingkungan (Green Supplier)',
                'description' => 'Persentase bahan yang dibeli dari supplier tersertifikasi ramah lingkungan.',
                'unit' => '%',
                'target_value' => 75.00,
                'actual_value' => 66.67,
                'weight' => 0.1150,
                'normalized_score' => 68.00,
                'final_score' => 7.82,
            ],
            [
                'code' => 'SO-02',
                'dimension' => 'SOURCE',
                'metric_name' => 'Tingkat Kualitas Bahan Baku Tanpa Cacat',
                'description' => 'Persentase kain mori dan malam yang lolos uji tanpa cacat tenun/kotoran.',
                'unit' => '%',
                'target_value' => 95.00,
                'actual_value' => 91.20,
                'weight' => 0.1050,
                'normalized_score' => 88.00,
                'final_score' => 9.24,
            ],
            [
                'code' => 'MK-01',
                'dimension' => 'MAKE',
                'metric_name' => 'Efisiensi Konsumsi Air per Potong Kain Batik',
                'description' => 'Volume rata-rata air pelorotan dan pencucian (Target <= 45 Liter/kain).',
                'unit' => 'L/kain',
                'target_value' => 45.00,
                'actual_value' => 48.50,
                'weight' => 0.1420,
                'normalized_score' => 62.00,
                'final_score' => 8.80,
            ],
            [
                'code' => 'MK-02',
                'dimension' => 'MAKE',
                'metric_name' => 'Rasio Daur Ulang Lilin Malam (Wax Recycling)',
                'description' => 'Persentase malam dari air pelorotan yang berhasil disaring dan dicairkan kembali.',
                'unit' => '%',
                'target_value' => 70.00,
                'actual_value' => 62.00,
                'weight' => 0.1380,
                'normalized_score' => 64.00,
                'final_score' => 8.83,
            ],
            [
                'code' => 'MK-03',
                'dimension' => 'MAKE',
                'metric_name' => 'Penggunaan Pewarna Alami Bebas Logam Berat',
                'description' => 'Proporsi pemakaian pewarna daun tom & tingi dibanding sintetis kimia.',
                'unit' => '%',
                'target_value' => 60.00,
                'actual_value' => 52.00,
                'weight' => 0.1200,
                'normalized_score' => 58.50,
                'final_score' => 7.02,
            ],
            [
                'code' => 'DL-01',
                'dimension' => 'DELIVER',
                'metric_name' => 'Ketepatan Waktu Pengiriman Pesanan (On-Time Delivery)',
                'description' => 'Persentase pengiriman pesanan sampai ke butik/pelanggan sesuai jadwal.',
                'unit' => '%',
                'target_value' => 95.00,
                'actual_value' => 88.00,
                'weight' => 0.1200,
                'normalized_score' => 75.00,
                'final_score' => 9.00,
            ],
            [
                'code' => 'RT-01',
                'dimension' => 'RETURN',
                'metric_name' => 'Tingkat Retur Produk Cacat (Low Defect Rate)',
                'description' => 'Persentase retur batik karena luntur atau cacat cantingan (Target <= 2%).',
                'unit' => '%',
                'target_value' => 2.00,
                'actual_value' => 3.20,
                'weight' => 0.1000,
                'normalized_score' => 63.00,
                'final_score' => 6.30,
            ],
        ];

        foreach ($metrics as $metric) {
            GreenScorMetric::create($metric);
        }

        // 8. Baseline GSCOR Evaluation Result (Konteks Artikel: Rata-rata 65.5225 / Average)
        GreenScorResult::create([
            'evaluation_period' => 'Q1-2026 Baseline',
            'evaluation_date' => now()->toDateString(),
            'plan_score' => 12.51,
            'source_score' => 17.06,
            'make_score' => 24.65,
            'deliver_score' => 9.00,
            'return_score' => 6.30,
            'total_index' => 69.52,
            'category' => 'Average',
            'notes' => 'Baseline pengukuran kinerja rantai pasok hijau awal. Konsumsi air pelorotan dan daur ulang malam menjadi area prioritas perbaikan pada modul produksi.',
            'evaluated_by' => 'Tim SQA & System Analyst ERP',
        ]);
    }
}
