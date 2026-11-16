# RANCANGAN TEST CASE BLACK-BOX TESTING (EP & BVA)
**Mata Kuliah:** Manajemen dan Proyek Sistem Informasi (RPS OBE 2026 - Pekan 3)  
**Modul Uji:** Form Master Produk, Bahan Baku, Kasir Penjualan (POS), & Mutasi Stok Gudang  
**Metode:** Equivalence Partitioning (EP) & Boundary Value Analysis (BVA)  
**Status Eksekusi:** 100% Passed (Terverifikasi Otomatis via PHPUnit)

---

## 1. Modul Kasir Penjualan POS (`sales.store`)

### A. Parameter: Kuantitas Pembelian (`quantity`)
* **Kondisi Batas:** Stok Produk Tersedia = 10 lembar.
* **Tipe Data:** Integer positif ($\ge 1$).

| ID Test Case | Teknik | Nilai Input | Partisi / Nilai Batas | Hasil yang Diharapkan | Hasil Pengujian Aktual | Status |
| :---: | :---: | :---: | :--- | :--- | :--- | :---: |
| **TC-POS-01** | EP | `-5` | Invalid Partition (Bilangan Negatif) | Ditolak validasi form (`min:1`) | Ditolak validasi form dengan pesan error | **PASSED** |
| **TC-POS-02** | BVA | `0` | Invalid Boundary ($\text{Min} - 1$) | Ditolak validasi form (`quantity min:1`) | Ditolak validasi form dengan pesan error | **PASSED** |
| **TC-POS-03** | BVA | `1` | Valid Boundary ($\text{Min}$) | Diterima, stok berkurang dari 10 menjadi 9 | Diterima, redirect sales index, stok = 9 | **PASSED** |
| **TC-POS-04** | EP | `5` | Valid Partition (Nominal) | Diterima, stok berkurang 5 lembar | Diterima, subtotal & stok terpotong benar | **PASSED** |
| **TC-POS-05** | BVA | `10` | Valid Boundary ($\text{Max} = \text{Stok}$) | Diterima, menghabiskan stok pas menjadi 0 | Diterima, stok produk tepat tersisa 0 | **PASSED** |
| **TC-POS-06** | BVA | `11` | Invalid Boundary ($\text{Max} + 1$) | Ditolak logika stok (`Stok tidak mencukupi`) | Ditolak dengan alert error, stok tetap 10 | **PASSED** |

### B. Parameter: Nilai Potongan Diskon (`discount_amount`)
* **Kondisi Batas:** Subtotal Transaksi = Rp 1.000.000 (1 pcs Batik Gentongan).
* **Tipe Data:** Numeric positif ($0 \le \text{diskon} \le \text{subtotal}$).

| ID Test Case | Teknik | Nilai Input | Partisi / Nilai Batas | Hasil yang Diharapkan | Hasil Pengujian Aktual | Status |
| :---: | :---: | :---: | :--- | :--- | :--- | :---: |
| **TC-DISC-01** | BVA | `-1` | Invalid Boundary ($\text{Min} - 1$) | Ditolak validasi form (`min:0`) | Ditolak validasi form | **PASSED** |
| **TC-DISC-02** | BVA | `0` | Valid Boundary ($\text{Min}$) | Diterima, grand total = Rp 1.000.000 | Diterima, total tagihan penuh | **PASSED** |
| **TC-DISC-03** | EP | `100.000` | Valid Partition (Diskon Sebagian) | Diterima, grand total = Rp 900.000 | Diterima, grand total dipotong akurat | **PASSED** |
| **TC-DISC-04** | BVA | `1.000.000` | Valid Boundary ($\text{Max} = \text{Subtotal}$) | Diterima, grand total = Rp 0 | Diterima, grand total tepat bernilai 0 | **PASSED** |
| **TC-DISC-05** | BVA | `1.000.001` | Invalid Boundary ($\text{Max} + 1$) | Ditolak logika bisnis (`Diskon melebihi subtotal`) | Ditolak dengan notifikasi error spesifik | **PASSED** |

---

## 2. Modul Persediaan & Mutasi Stok Gudang (`inventory.adjust`)

### Parameter: Kuantitas Pengurangan Stok Fisik (`quantity`, `movement_type: out/waste`)
* **Kondisi Batas:** Stok Produk Tersedia di Gudang = 10 pcs.
* **Tipe Data:** Numeric positif ($0.01 \le \text{quantity} \le \text{stok}$).

| ID Test Case | Teknik | Nilai Input | Partisi / Nilai Batas | Hasil yang Diharapkan | Hasil Pengujian Aktual | Status |
| :---: | :---: | :---: | :--- | :--- | :--- | :---: |
| **TC-INV-01** | BVA | `0` | Invalid Boundary ($\text{Min} - 0.01$) | Ditolak validasi form (`min:0.01`) | Ditolak validasi form | **PASSED** |
| **TC-INV-02** | BVA | `0.01` | Valid Boundary ($\text{Min}$) | Diterima untuk bahan baku | Diterima, tercatat di log audit kartu stok | **PASSED** |
| **TC-INV-03** | BVA | `10` | Valid Boundary ($\text{Max} = \text{Stok}$) | Diterima, stok gudang menjadi 0 | Diterima, stok terpotong pas menjadi 0 | **PASSED** |
| **TC-INV-04** | BVA | `11` | Invalid Boundary ($\text{Max} + 1$) | Ditolak logika stok (`Stok tidak mencukupi`) | Ditolak dengan notifikasi error, stok tetap 10 | **PASSED** |

---

## 3. Modul Form Master Data Produk Batik (`products.store`)

### Parameter: Harga Jual (`selling_price`) & Stok Awal (`stock`)

| ID Test Case | Parameter | Nilai Input | Karakteristik Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
| :---: | :---: | :---: | :--- | :--- | :--- | :---: |
| **TC-PRD-01** | `selling_price` | `-50.000` | Invalid Partition (Harga Negatif) | Ditolak validasi form (`min:0`) | Ditolak validasi form | **PASSED** |
| **TC-PRD-02** | `selling_price` | `0` | Valid Boundary (Gratis/Sample) | Diterima | Diterima | **PASSED** |
| **TC-PRD-03** | `stock` | `-1` | Invalid Boundary ($\text{Min} - 1$) | Ditolak validasi form (`min:0`) | Ditolak validasi form | **PASSED** |
| **TC-PRD-04** | `stock` | `0` | Valid Boundary ($\text{Min}$) | Diterima (Produk baru belum ada stok) | Diterima, stok = 0 | **PASSED** |
| **TC-PRD-05** | `code` | `DUPLIKAT` | Keunikan SKU Motif Batik | Ditolak aturan unique database | Ditolak error validasi `code unique` | **PASSED** |

---

## 4. Kesimpulan Eksekusi Pengujian
Seluruh 15 skenario pengujian nilai batas (Boundary Value Analysis) dan partisi ekuivalensi (Equivalence Partitioning) di atas telah diotomatisasi pada kelas pengujian `tests/Feature/BlackBoxEpBvaTest.php` dan berstatus **100% PASSED**.
