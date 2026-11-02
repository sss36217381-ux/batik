# 🌿 ERP Batik Tulis Madura (Green Supply Chain Management)

Aplikasi berbasis web **Enterprise Resource Planning (ERP)** yang dirancang khusus untuk memodernisasi kegiatan operasional UMKM Batik Tulis Madura dengan integrasi model **Green Supply Chain Management (GSCOR & ANP)**. 

Dikembangkan secara bertahap mengikuti Rencana Pembelajaran Semester (RPS) 16 Minggu pada mata kuliah **Manajemen dan Proyek Sistem Informasi**.

---

## 🚀 Identitas & Ringkasan Proyek
* **Nama Sistem:** ERP Batik Madura
* **Objek Riset:** UMKM Batik Tulis Madura (Khas Tanjungbumi Bangkalan, Pamekasan, dan Sumenep)
* **Basis Ilmiah:** Mengadaptasi model penelitian *"Penerapan Model Green Supply Chain Management untuk Pengembangan Industri Batik Tulis Madura dengan GSCOR dan ANP"*
* **Konsep Inti:**
  * 5 Pilar Green SCOR: **PLAN**, **SOURCE**, **MAKE**, **DELIVER**, **RETURN**
  * Bobot ANP dinamis yang dapat disesuaikan per UMKM
  * Pengawasan konsumsi air pelorotan, daur ulang lilin malam (*wax recycling*), dan rasio pemasok ramah lingkungan (*green suppliers*)

---

## 🛠️ Tech Stack
* **Backend:** PHP 8.2+, Laravel 12 Framework, Laravel REST API, Eloquent ORM
* **Frontend:** Blade Templating, Tailwind CSS v4, Alpine.js, Responsive Design
* **Database:** PostgreSQL (Mendukung fallback SQLite untuk automated testing & CI)
* **Software Quality Assurance:** PHPUnit / Pest, Postman, Newman CLI, Playwright, Apache JMeter, OWASP ZAP
* **DevOps & Container:** Git, Docker, Docker Compose, GitHub Actions CI/CD, Linux VPS

---

## 📦 15 Modul Utama Sistem ERP
1. **Dashboard:** Ringkasan keuangan, stok bahan baku, stok kain batik, dan banner kinerja Green SCOR.
2. **Manajemen Pengguna:** Multi-role (Admin, Pemilik, Gudang, Produksi, Pembelian, Penjualan).
3. **Data Pemasok:** Master supplier dengan rating dan sertifikasi Green Supplier.
4. **Data Pelanggan:** Database pembeli eceran, butik grosir (*wholesale*), dan reseller.
5. **Data Produk Batik:** Katalog motif legendaris (Gentongan, Aromanis, Sekar Jagat, Lancor).
6. **Manajemen Bahan Baku:** Kain mori primissima, malam tawon, dan pewarna alami (Indigofera & Tingi).
7. **Pembelian (SOURCE):** Transaksi PO ke pemasok dan otomatisasi penambahan stok gudang.
8. **Persediaan & Gudang:** Kartu stok audit trail, mutasi in/out/adjustment, dan penanganan waste.
9. **Produksi (MAKE):** SPK tahapan membatik, monitoring air pelorotan & daur ulang lilin malam.
10. **Penjualan (POS):** Kasir penjualan kain batik, diskon, pembayaran (Cash, Transfer, QRIS), dan pemotongan stok otomatis.
11. **Pengiriman (DELIVER):** Surat jalan ekspedisi dan metrik ketepatan waktu (*On-Time Delivery*).
12. **Retur (RETURN):** Pencatatan produk cacat (luntur/rusak) dan opsi tindakan ganti/perbaiki.
13. **Keuangan:** Laba kotor, pencatatan beban operasional IPAL/pengrajin, dan laba bersih.
14. **Laporan Terpadu:** Valuasi aset produk jadi, rekap omzet kasir, dan volume produksi.
15. **Green Supply Chain Analytics:** Pengukuran indeks GSCOR berbasis pembobotan ANP dinamis.

---

## 🔑 Kredensial Login Bawaan (Demo Dummy Data)
Semua akun menggunakan kata sandi bawaan: `password`

| Role | Email | Deskripsi Hak Akses |
| :--- | :--- | :--- |
| **Admin** | `admin@batikmadura.id` | Akses penuh ke seluruh modul & manajemen pengguna |
| **Pemilik** | `pemilik@batikmadura.id` | Akses dashboard eksekutif, laporan keuangan, dan analitik GSCOR |
| **Gudang** | `gudang@batikmadura.id` | Akses stok gudang, bahan baku, opname, dan retur |
| **Produksi** | `produksi@batikmadura.id` | Akses SPK produksi batik, konsumsi air, dan limbah lilin |
| **Pembelian** | `pembelian@batikmadura.id` | Akses data pemasok dan order pembelian bahan baku |
| **Penjualan** | `penjualan@batikmadura.id` | Akses kasir penjualan (POS), pelanggan, dan pengiriman resi |

---

## 💻 Panduan Menjalankan Aplikasi
1. **Clone repositori / Buka direktori proyek:**
   ```bash
   cd c:\DataQu\batik
   ```
2. **Pastikan ketergantungan PHP dan Node terpasang:**
   ```bash
   composer install
   npm install
   npm run build
   ```
3. **Konfigurasi Lingkungan (`.env`):**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Jalankan Migrasi & Seeder Database:**
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Menjalankan Automated Tests (PHPUnit):**
   ```bash
   php artisan test
   ```
6. **Menjalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Akses aplikasi pada peramban web: `http://127.0.0.1:8000`

---

## 📚 Struktur Dokumentasi RPS Mingguan
Detail perkembangan proyek dari Minggu 1 hingga 16 terdokumentasi pada folder `docs/`:
* [Laporan Minggu 1 - Fundamental SQA & Baseline](docs/week-01/README.md)
* `docs/week-02/` s/d `docs/week-16/` (Akan terus diperbarui setiap minggu secara berkelanjutan)
