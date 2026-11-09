# CHANGELOG: ERP BATIK TULIS MADURA

Format changelog ini mengacu pada standar [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) dan Semantic Versioning.

---

## [v0.2.0] - 2026-11-09 (Minggu 2: Test Planning & Risk Analysis)

### Ditambahkan (Added)
* Dokumen formal **Test Plan berstandar IEEE 829 / ISO/IEC/IEEE 29119** (`docs/week-02/TEST_PLAN_DOCUMENT.md`) yang mencakup estimasi sumber daya, jadwal uji 16 minggu, kriteria masuk/keluar (*Entry & Exit criteria*), kriteria penundaan (*Suspension/Resumption*), dan deliverables pengujian.
* Matriks Analisis Risiko Pengujian Perangkat Lunak (*Test Risk Assessment Matrix*) dengan 5 risiko kritis operasional (pencegahan *race condition* kasir, akurasi pembulatan HPP desimal, sanitasi bobot ANP GSCOR, dan isolasi role RBAC).
* Laporan RPS Minggu 2 komprehensif pada `docs/week-02/README.md`.
* Automated Feature Test Suite baru:
  * `tests/Feature/MasterDataValidationTest.php`: Memvalidasi field wajib produk, keunikan kode SKU motif batik, dan batas rating ramah lingkungan supplier (1-5).
  * `tests/Feature/InventoryBusinessRuleTest.php`: Memvalidasi penolakan transaksi kasir saat jumlah checkout melebihi kuantitas stok fisik gudang, kalkulasi diskon, dan pengurangan stok otomatis.
* Peningkatan jumlah pengujian otomatis menjadi 16 test cases dan 41 assertions dengan tingkat kelulusan 100%.

---

## [v0.1.0] - 2026-11-02 (Minggu 1: Fundamental SQA & Baseline)

### Ditambahkan (Added)
* Inisialisasi struktur proyek web berbasis Laravel 12 dengan arsitektur MVC terstruktur.
* Konfigurasi Tailwind CSS v4 dan Alpine.js untuk desain UI antarmuka web modern & responsif.
* Desain basis data terpadu dengan 10 migrasi skema PostgreSQL (15 tabel relasional lengkap).
* 6 peran pengguna (Role-Based Access Control): Administrator, Pemilik UMKM, Bagian Gudang, Bagian Produksi, Bagian Pembelian, dan Bagian Penjualan.
* Sistem Autentikasi lengkap (Login, Logout, Session Invalidation) dengan tombol pemilih kredensial cepat untuk demo pengujian role.
* Middleware proteksi otorisasi peran (`EnsureUserHasRole` / `role:...`).
* Dashboard interaktif dengan kartu ringkasan omzet, modal pembelian, stok bahan, stok batik, dan aksi cepat (*Quick Actions*).
* Modul Green Supply Chain Management (GSCOR & ANP) dengan 5 pilar (PLAN, SOURCE, MAKE, DELIVER, RETURN), pengaturan bobot ANP dinamis, dan rekalkulasi otomatis.
* 14 modul operasional dan master data ERP: Pengguna, Pemasok, Pelanggan, Produk Batik, Bahan Baku, Pembelian, Persediaan, Produksi Batik, Penjualan POS, Pengiriman Resi, Retur Barang, Keuangan, dan Laporan Terpadu.
* Seeder basis data realistis untuk pengrajin Batik Tulis Madura (Gentongan, Aromanis, Lancor, pewarna alami daun tom/indigofera & kulit tingi).
* 11 unit & feature test cases menggunakan PHPUnit dengan tingkat kelulusan 100%.
* Dokumentasi proyek komprehensif pada `docs/week-01/README.md`, `DATABASE.md`, `PROJECT_PROGRESS.md`.
