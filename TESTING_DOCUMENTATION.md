# DOKUMENTASI PENGUJIAN PERANGKAT LUNAK (SQA TESTING)

Dokumentasi ini merangkum strategi pengujian, konfigurasi test runner, dan riwayat eksekusi pengujian otomatis pada ERP Batik Madura.

---

## 1. Strategi Pengujian (Berdasarkan V-Model)
* **Unit Testing (PHPUnit/Pest):** Menguji logika perhitungan matematika diskon, penyesuaian stok, serta rumus normalisasi skor Snorm De Boer pada Green SCOR.
* **Feature & Integration Testing:** Menguji pengalihan rute (middleware otorisasi peran), interaksi form request, dan integritas transaksi database (ACID).
* **Automated Regression Suite:** Dijalankan secara otomatis sebelum setiap commit dan merge ke branch utama.

---

## 2. Cara Menjalankan Automated Test Suite

Untuk menjalankan seluruh pengujian otomatis:
```bash
php artisan test
```

Untuk menjalankan file pengujian tertentu:
```bash
php artisan test tests/Feature/AuthenticationTest.php
php artisan test tests/Feature/RoleAuthorizationTest.php
php artisan test tests/Feature/GreenScorCalculationTest.php
```

---

## 3. Matriks Hasil Pengujian (Baseline Minggu 1)

| Suite Uji | Nama Uji | Jenis | Assertions | Status |
| :--- | :--- | :---: | :---: | :---: |
| `ExampleTest` | `test_that_true_is_true` | Unit | 1 | **PASSED** |
| `ExampleTest` | `test_guest_is_redirected_to_login` | Feature | 1 | **PASSED** |
| `AuthenticationTest` | `test_login_screen_can_be_rendered` | Feature | 2 | **PASSED** |
| `AuthenticationTest` | `test_users_can_authenticate_using_the_login_screen` | Feature | 2 | **PASSED** |
| `AuthenticationTest` | `test_users_can_not_authenticate_with_invalid_password` | Feature | 1 | **PASSED** |
| `AuthenticationTest` | `test_users_can_logout` | Feature | 2 | **PASSED** |
| `RoleAuthorizationTest` | `test_admin_can_access_user_management` | Feature | 2 | **PASSED** |
| `RoleAuthorizationTest` | `test_cashier_is_forbidden_from_user_management` | Feature | 1 | **PASSED** |
| `RoleAuthorizationTest` | `test_authenticated_user_can_access_dashboard` | Feature | 2 | **PASSED** |
| `GreenScorCalculationTest` | `test_green_scor_metric_can_be_updated_and_normalized` | Feature | 2 | **PASSED** |
| `GreenScorCalculationTest` | `test_recalculate_generates_new_evaluation_result` | Feature | 2 | **PASSED** |

**Total:** 11 Passed (23 assertions) &bull; Durasi: ~1.7 detik &bull; Success Rate: 100%.
