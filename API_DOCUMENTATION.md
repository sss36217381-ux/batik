# DOKUMENTASI REST API: ERP BATIK MADURA

Dokumentasi ini merangkum *endpoints* utama yang disiapkan untuk modul pengujian API (Postman & Newman CLI pada Minggu 6).

---

## 1. Konvensi Umum
* **Base URL:** `http://localhost:8000/api/v1`
* **Format Request/Response:** `application/json`
* **Autentikasi:** Session Cookie / Laravel Sanctum Bearer Token

---

## 2. Daftar Endpoint Utama

### A. Autentikasi
* `POST /login`
  * Body: `{ "email": "admin@batikmadura.id", "password": "password" }`
  * Response: Session cookie / 302 Redirect to Dashboard
* `POST /logout`

### B. Master Data Produk Batik
* `GET /products`: Daftar seluruh kain batik siap jual.
* `POST /products`: Tambah motif batik baru.
  * Fields: `code`, `name`, `motif_type`, `size`, `cost_price`, `selling_price`, `stock`, `min_stock`
* `DELETE /products/{id}`: Hapus produk batik.

### C. Manajemen Bahan Baku
* `GET /raw-materials`: Daftar stok kain mori, malam, dan pewarna.
* `POST /raw-materials`: Tambah bahan baku.
  * Fields: `code`, `name`, `category`, `unit`, `stock`, `min_stock`, `unit_price`, `is_eco_friendly`

### D. Pengadaan & Pembelian (SOURCE)
* `GET /purchases`: Riwayat pembelian PO.
* `POST /purchases`: Rekam pembelian bahan baku ke pemasok dan otomatisasi stok.

### E. Produksi Batik (MAKE)
* `GET /production`: Log SPK produksi membatik.
* `POST /production`: Terbitkan SPK dengan parameter konsumsi air & target daur ulang malam.

### F. Kasir Penjualan (POS / DELIVER)
* `GET /sales`: Riwayat transaksi penjualan.
* `POST /sales`: Checkout kasir, perhitungan diskon, dan pengurangan stok.

### G. Green Supply Chain Management (GSCOR & ANP)
* `GET /green-supply-chain`: Ambil seluruh indikator 5 pilar GSCOR dan riwayat evaluasi.
* `PATCH /green-supply-chain/{id}`: Perbarui nilai riil aktual dan bobot dinamis ANP indikator.
* `POST /green-supply-chain/recalculate`: Picu kalkulasi ulang indeks total Green SCOR.
