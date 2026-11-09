# PROJECT PROGRESS: ERP BATIK MADURA (16 WEEKS ROADMAP)

Status Proyek: **Minggu 1 Selesai** (Siap Menuju Minggu 2)

| Minggu | Materi RPS | Status | Tanggal Penyelesaian | Deliverables Utama |
| :---: | :--- | :---: | :---: | :--- |
| **01** | **Fundamental Software Quality Assurance** | **SELESAI** | 2026-11-02 | Inisialisasi Laravel 12, PostgreSQL Schema, 6 Role, Auth, 15 Modul UI, GSCOR Analytics, Unit Testing |
| **02** | Test Planning & Risk Analysis | Menunggu Perintah | - | Dokumen Test Plan IEEE 829, Entry/Exit criteria, Matriks Risiko |
| **03** | Black-Box Testing (EP & BVA) | Terjadwal | - | Test Case EP & BVA pada modul Form Master Data & Transaksi |
| **04** | Advanced Black-Box Testing | Terjadwal | - | Decision Table, State Transition, Use Case Testing |
| **05** | White-Box Testing & Cyclomatic Complexity | Terjadwal | - | CFG, Basis Path Testing, Cyclomatic Complexity kalkulasi HPP |
| **06** | API & Integration Testing | Terjadwal | - | REST API Collection, Automated Test Postman & Newman CLI |
| **07** | Automated End-to-End Testing & Defect Tracking | Terjadwal | - | Playwright E2E automation, GitHub Issues Defect Log |
| **08** | UTS & Audit Proyek Perangkat Lunak | Terjadwal | - | Audit fitur, penutupan defect log, laporan progress paruh semester |
| **09** | Performance Testing | Terjadwal | - | Apache JMeter Load & Stress Testing (100 concurrent users) |
| **10** | Security Testing (OWASP Top 10) | Terjadwal | - | OWASP ZAP scanning, audit otorisasi peran & sanitasi input |
| **11** | User Acceptance Testing (UAT) | Terjadwal | - | Skenario UAT, kuesioner pengguna, UAT Sign-off document |
| **12** | Implementasi & Strategi Cutover | Terjadwal | - | Analisis komparasi metode transisi (Direct, Parallel, Phased, Pilot) |
| **13** | Data Migration & ETL Scripting | Terjadwal | - | Python & Pandas ETL pipeline, pembersihan data legacy, rollback script |
| **14** | CI/CD & Deployment Automation | Terjadwal | - | GitHub Actions workflow, Docker containerization, staging VPS |
| **15** | Post-Implementation Review (PIR) | Terjadwal | - | Evaluasi PIR, estimasi biaya pemeliharaan berkala |
| **16** | UAS & Simulasi Live Demo | Terjadwal | - | Presentasi akhir, demonstrasi rollback live, laporan final |

---

## 📝 Catatan Audit Perkembangan Terakhir (Minggu 1)
* Seluruh 15 modul aplikasi ERP telah memiliki tabel basis data relasional, model Eloquent, controller, dan tampilan Blade responsif.
* Pengujian otomatis unit & feature pada level framework mencapai 100% kelulusan (11 test cases passed).
* Tidak ada perubahan arsitektur destruktif yang diperbolehkan tanpa persetujuan eksplisit pengguna.

