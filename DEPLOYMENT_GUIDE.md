# PANDUAN DEPLOYMENT: ERP BATIK MADURA

Panduan ini mendokumentasikan langkah pemasangan pada lingkungan pengembangan lokal (Localhost) dan server pementasan (Staging VPS Linux).

---

## 1. Persyaratan Sistem
* PHP 8.2 atau lebih tinggi (dengan ekstensi `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `curl`, `zip`)
* PostgreSQL 14+ (atau SQLite untuk uji coba lokal tanpa server db)
* Node.js v18+ dan NPM
* Composer 2.x

---

## 2. Pemasangan di Lingkungan Lokal (Windows / macOS / Linux)

1. **Clone dan Pasang Dependensi:**
   ```bash
   git clone <url-repository>
   cd batik
   composer install
   npm install
   npm run build
   ```

2. **Pengaturan Berkas `.env`:**
   Salin `.env.example` ke `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   *Untuk menggunakan PostgreSQL lokal:*
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=erp_batik_madura
   DB_USERNAME=postgres
   DB_PASSWORD=password
   ```

3. **Inisialisasi Database:**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Jalankan Aplikasi:**
   ```bash
   php artisan serve --port=8000
   ```
   Buka peramban: `http://localhost:8000`

---

## 3. Konfigurasi Docker & PostgreSQL (Opsional)
Disediakan berkas `docker-compose.yml` untuk menjalankan PostgreSQL secara terisolasi tanpa perlu menginstal PostgreSQL secara native di sistem operasi induk.

---

## 4. Kredensial Pengujian Bawaan
* **Admin:** `admin@batikmadura.id` / `password`
* **Pemilik:** `pemilik@batikmadura.id` / `password`
* **Gudang:** `gudang@batikmadura.id` / `password`
* **Produksi:** `produksi@batikmadura.id` / `password`
* **Pembelian:** `pembelian@batikmadura.id` / `password`
* **Penjualan:** `penjualan@batikmadura.id` / `password`
