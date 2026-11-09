# PROJECT PROGRESS: ERP BATIK MADURA (16 WEEKS ROADMAP)

Status Proyek: **Minggu 2 Selesai** (Siap Menuju Minggu 3 & 4)

| Minggu | Materi RPS | Status | Tanggal Penyelesaian | Deliverables Utama |
| :---: | :--- | :---: | :---: | :--- |
| **01** | **Fundamental Software Quality Assurance** | **SELESAI** | 2026-11-02 | Inisialisasi Laravel 12, PostgreSQL Schema, 6 Role, Auth, 15 Modul UI, GSCOR Analytics, Unit Testing |
| **02** | **Test Planning & Risk Analysis** | **SELESAI** | 2026-11-09 | Dokumen Test Plan IEEE 829 (`TEST_PLAN_DOCUMENT.md`), Entry/Exit criteria, Matriks Risiko, 16 Test Cases Passed |
| **03** | Black-Box Testing (EP & BVA) | Menunggu Perintah | - | Test Case EP & BVA pada modul Form Master Data & Transaksi |
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

## 📝 Catatan Audit Perkembangan Terakhir (Minggu 2)
* Dokumen formal **Test Plan IEEE 829** (`docs/week-02/TEST_PLAN_DOCUMENT.md`) telah disahkan sebagai acuan mutu SQA.
* Suite pengujian otomatis bertambah menjadi 16 test cases (41 assertions) dengan tingkat kelulusan 100%.
* Seluruh kode dan laporan tersinkronisasi pada remote repository GitHub `origin/main`.
