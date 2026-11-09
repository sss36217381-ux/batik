# LOG PENCATATAN CACAT & DEFECT (BUG REPORT)

Format pencatatan bug mengadopsi standar **GitHub Issues Defect Tracking** untuk mendukung mata kuliah Manajemen & Proyek SI.

---

## 1. Format Template Pelaporan Bug (GitHub Issue Template)

```markdown
### [BUG] Judul Cacat Singkat

**Modul / Halaman Terkait:** (Contoh: Penjualan POS / Green SCOR)
**Tingkat Keparahan (Severity):** [Critical / High / Medium / Low]
**Prioritas (Priority):** [P1 - Urgent / P2 - Normal / P3 - Low]

**Langkah-langkah Reproduksi (Steps to Reproduce):**
1. Buka modul ...
2. Klik tombol ...
3. Masukkan nilai ...

**Hasil yang Diharapkan (Expected Behavior):**
...

**Hasil Aktual (Actual Behavior):**
...

**Tangkapan Layar / Log Error:**
...

**Lingkungan Sistem:**
* OS: Windows / Linux
* Browser: Chrome / Firefox
* Versi PHP: 8.2.12
```

---

## 2. Riwayat Defect yang Ditemukan & Diperbaiki (Minggu 1)

| ID Bug | Deskripsi Masalah | Modul | Severity | Status | Resolusi |
| :--- | :--- | :--- | :---: | :---: | :--- |
| **BUG-001** | Assertion `assertSee('ERP BATIK')` gagal akibat perbedaan case dengan teks view | Testing | Low | **RESOLVED** | Mengubah target string assertion menjadi `ERP Batik Madura`. |
| **BUG-002** | Ekstensi `pdo_pgsql` tidak aktif secara default pada runtime PHP lokal | Database | Medium | **RESOLVED** | Mengaktifkan `extension=pdo_pgsql` dan `extension=pgsql` pada `php.ini`. |
| **BUG-003** | Eksekusi file `npm.ps1` terblokir oleh Windows Execution Policy | Build Script | Medium | **RESOLVED** | Menggunakan wrapper `cmd /c` untuk eksekusi Vite build secara konsisten. |

