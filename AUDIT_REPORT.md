# LAPORAN AUDIT PROYEK - SISTEM NILAI MAHASISWA

**Mata Kuliah:** Pengembangan Aplikasi Basis Data  
**Tanggal Audit:** 28 Juni 2026  
**Auditor:** Dosen Pengampu

---

## PENDAHULUAN

Saya telah melakukan pemeriksaan menyeluruh terhadap proyek Sistem Nilai Mahasiswa yang saudara kembangkan. Audit ini dilakukan dengan standar penilaian tugas akhir mata kuliah, mencakup aspek analisis, database, implementasi, UI/UX, dan dokumentasi.

Saya akan memberikan penilaian yang objektif - memuji yang memang baik, dan mengkritik yang masih kurang. Tujuannya agar saudara paham kekuatan dan kelemahan proyek ini.

---

## 1. ANALISIS KEBUTUHAN

### Yang Sudah Baik

Latar belakang masalah di LAPORAN_UAS.md cukup bagus. Saudara berhasil mengidentifikasi 5 masalah konkret dari sistem manual: pencatatan tidak efisien, kesulitan pencarian data, perhitungan grade manual, validasi lemah, dan pelaporan sulit. Ini menunjukkan saudara memahami permasalahan yang akan diselesaikan.

Struktur aplikasi dengan 3 entitas utama (Mahasiswa, Mata Kuliah, Nilai) sudah tepat untuk sistem akademik sederhana. Fitur CRUD lengkap untuk ketiga modul juga sudah ada.

### Kritik & Masalah

Yang bikin saya heran, kenapa tidak ada sistem login sama sekali? Ini aplikasi akademik yang harusnya menyimpan data sensitif. Sekarang siapa aja bisa akses dan ubah-ubah data. Bahkan untuk tugas akhir, minimal ada login admin sederhana.

Tidak ada role management juga. Padahal dalam sistem nilai yang proper, harusnya ada pembedaan: admin bisa CRUD semua, dosen hanya input nilai mata kuliahnya, mahasiswa cuma lihat nilainya sendiri.

Fitur export ke PDF atau Excel juga tidak ada. Dosen mana yang mau lihat nilai di browser terus? Biasanya kan butuh print transkrip atau laporan.

**Kesimpulan Analisis:** Analisis cukup bagus tapi implementasinya kurang lengkap untuk aplikasi yang benar-benar bisa dipakai.

---

## 2. STRUKTUR FOLDER

### Yang Sudah Baik

Ini salah satu aspek terkuat dari proyek saudara. Struktur foldernya rapi dan mengikuti best practice:

```
assets/ → CSS, JS, gambar terpisah rapi
config/ → Konfigurasi database
database/ → SQL file
helpers/ → Function-function bantuan
includes/ → Komponen template (header, footer, dll)
modules/ → Tiap fitur punya foldernya sendiri
```

Separation of concerns-nya jelas. Modular. Kalau nanti mau tambah modul baru, tinggal bikin folder di modules/, gampang.

Naming convention juga konsisten. Tidak ada yang aneh-aneh.

### Kekurangan

Tidak ada folder untuk logging error. Kalau terjadi bug di production, gimana trace-nya?

Tidak ada folder uploads/ untuk foto mahasiswa (kalau mau dikembangkan).

Tidak ada folder exports/ untuk menyimpan file laporan yang di-generate.

Tapi ini minor sih, untuk skala tugas akhir sudah lebih dari cukup.

---

## 3. DATABASE

### Entity Relationship Diagram

ERD-nya simpel tapi tepat:
- Mahasiswa (1) → (N) Nilai
- Mata Kuliah (1) → (N) Nilai

Relasi one-to-many sudah benar. Tabel nilai sebagai junction table juga proper. Tidak ada yang berlebihan, tidak ada yang kurang.

### Primary Key & Foreign Key

Semua tabel punya primary key (id INT AUTO_INCREMENT). Bagus.

Foreign key constraint juga sudah ada:
```sql
nilai.mahasiswa_id → mahasiswa.id (ON DELETE RESTRICT, ON UPDATE CASCADE)
nilai.mata_kuliah_id → mata_kuliah.id (ON DELETE RESTRICT, ON UPDATE CASCADE)
```

`ON DELETE RESTRICT` ini pilihan yang tepat. Jadi kalau ada mahasiswa yang punya nilai, tidak bisa dihapus begitu saja. Data tidak akan jadi orphan.

`ON UPDATE CASCADE` juga masuk akal. Kalau id-nya berubah (walau jarang terjadi), nilai akan ikut ter-update.

### Unique Constraints

Ada tiga unique constraint yang sangat penting:

1. `mahasiswa.nim` → Mencegah NIM duplikat ✓
2. `mata_kuliah.kode_mk` → Mencegah kode MK duplikat ✓
3. `nilai.(mahasiswa_id, mata_kuliah_id)` → Ini yang paling penting!

Yang nomor 3 itu composite unique key. Artinya satu mahasiswa tidak bisa punya dua nilai untuk mata kuliah yang sama. Ini **sangat bagus** karena mencegah kesalahan input yang fatal.

Banyak mahasiswa yang bikin sistem nilai lupa ini, jadi bisa ada mahasiswa dengan 2-3 nilai untuk satu mata kuliah. Saudara sudah antisipasi. Bagus!

### Check Constraints

Ada constraint untuk nilai:
```sql
CHECK (nilai >= 0 AND nilai <= 100)
```

Ini bagus, jadi validasi tidak cuma di aplikasi tapi juga di database level.

**Tapi kenapa SKS tidak ada constraint?** Seharusnya ada `CHECK (sks >= 1 AND sks <= 6)` di database. Begitu juga angkatan, seharusnya `CHECK (angkatan >= 2000)`.

Kalau cuma validasi di PHP, terus ada developer lain yang langsung insert via SQL tanpa lewat aplikasi, bisa kacau datanya.

### Indexes

Index-nya sudah optimal:
```sql
INDEX pada: angkatan, jurusan, sks, grade
INDEX pada foreign key: mahasiswa_id, mata_kuliah_id
```

Bagus. Ini akan bantu query jadi cepat. Foreign key yang di-index juga penting untuk JOIN performance.

### Normalisasi

Saya cek, database sudah dalam bentuk normal ketiga (3NF):
- 1NF: Setiap cell atomic, tidak ada repeating group ✓
- 2NF: Tidak ada partial dependency ✓
- 3NF: Tidak ada transitive dependency ✓

Data tidak redundan. Tidak ada anomali insert/update/delete. Struktur database ini sudah benar secara teori.

### Penamaan

Konsisten pakai lowercase dengan underscore: `mahasiswa`, `mata_kuliah`, `mahasiswa_id`, `nama_mk`.

Timestamps pakai `created_at` dan `updated_at`. Standar.

Character set pakai `utf8mb4_unicode_ci`. Ini bagus, mendukung emoji dan karakter internasional.

Engine pakai `InnoDB`. Perfect, karena ini yang support foreign key dan transaction.

### Catatan Kritis

Satu hal yang kurang: **tidak ada mekanisme soft delete**. Kalau data dihapus, hilang selamanya. Padahal biasanya di aplikasi production, data tidak benar-benar dihapus, cuma di-flag `deleted_at`.

Tapi untuk level tugas akhir, ini acceptable.

**Nilai Database: 92/100**

Pengurangan karena:
- Kurang CHECK constraint untuk sks dan angkatan (-3)
- Tidak ada soft delete mechanism (-5)

---

## 4. IMPLEMENTASI KODE

### Dashboard

Dashboard sudah bagus. Ada 4 statistik card (total mahasiswa, mata kuliah, nilai, rata-rata) plus 3 quick access card.

Tapi ada masalah kecil:

```php
$total_mahasiswa_query = $conn->query("SELECT COUNT(*) as total FROM mahasiswa");
```

Ini tidak pakai prepared statement. Memang untuk kasus ini aman karena tidak ada input dari user, tapi untuk konsistensi seharusnya tetap pakai prepared statement. Biar kodenya uniform.

### CRUD - Yang Sudah Baik

Saya periksa CRUD Mahasiswa, Mata Kuliah, dan Nilai. Semua sudah pakai **prepared statement**. Ini bagus sekali! SQL injection tidak akan bisa masuk.

Contoh:
```php
$stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nim, $nama, $jurusan, $angkatan);
$stmt->execute();
```

Input juga di-sanitize pakai fungsi `clean()` yang isinya `htmlspecialchars()`. XSS attack juga dicegah.

Server-side validation lengkap:
- Required field check ✓
- Numeric validation ✓
- Range validation ✓
- Unique validation ✓

Relational integrity juga dijaga. Sebelum delete mahasiswa, dicek dulu apakah punya nilai. Kalau punya, tidak bisa dihapus. Bagus!

### CRUD - Yang Bermasalah

Ada satu masalah yang cukup serius di bagian sorting:

```php
$order = isset($_GET['order']) ? clean($_GET['order']) : 'nim';
$sort = isset($_GET['sort']) ? clean($_GET['sort']) : 'ASC';

$sql = "SELECT * FROM mahasiswa ... ORDER BY $order $sort";
```

Ini **SQL Injection potential**! Walau sudah pakai `clean()`, tapi `ORDER BY` tidak bisa pakai prepared statement. User bisa inject query lewat parameter `order` dan `sort`.

Harusnya pakai whitelist:

```php
$allowed_orders = ['nim', 'nama', 'jurusan', 'angkatan'];
if (!in_array($order, $allowed_orders)) $order = 'nim';

$allowed_sorts = ['ASC', 'DESC'];
if (!in_array($sort, $allowed_sorts)) $sort = 'ASC';
```

Ini berlaku di semua modul (mahasiswa, mata kuliah, nilai). Harus diperbaiki.

### Helper Functions

File `helper.php` dan `validation.php` sangat bagus. Separation of concerns jelas.

`helper.php`:
- `clean()` → XSS prevention
- `redirect()` → Proper redirect
- `calculate_grade()` → Business logic
- `set_alert()` / `show_alert()` → Flash message

`validation.php`:
- 10 fungsi validasi berbeda
- Semua pakai prepared statement
- Reusable di semua modul

Ini desain yang matang. Bukan asal CRUD.

### Keamanan - Yang Kurang

**CSRF Protection tidak ada sama sekali!** Ini celah keamanan yang besar.

Sekarang orang bisa bikin form di website lain, terus submit ke aplikasi saudara. Karena tidak ada CSRF token, request-nya akan diterima.

Minimal harusnya ada:
```php
// Generate token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Di form
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

// Validasi
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Invalid CSRF token');
}
```

Ini basic security yang seharusnya ada.

Session configuration juga kurang:
```php
// Tidak ada di header.php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
```

Tanpa ini, session bisa di-hijack lewat XSS atau session fixation attack.

### Fitur Nilai - Yang Excellent

CRUD Nilai ini yang paling kompleks dan implementasinya bagus:
- Dropdown mahasiswa dan mata kuliah dari database
- Validasi tidak boleh duplikat (mahasiswa + mata kuliah)
- Grade calculation otomatis
- Display dengan JOIN 3 tabel

JavaScript-nya juga ada grade preview real-time. User input nilai, langsung muncul grade-nya dengan warna badge yang sesuai. Nice touch!

**Nilai Implementasi: 88/100**

Pengurangan karena:
- SQL injection potential di ORDER BY (-2)
- Tidak ada CSRF protection (-10)

---

## 5. USER INTERFACE

### Konsistensi & Struktur

UI konsisten di semua halaman. Navbar, sidebar, footer, card style, button style, form style, table style - semuanya sama. Ini penting untuk UX yang baik.

HTML-nya semantic (pakai `<main>`, `<nav>`, `<aside>`, `<section>`, `<article>`). Bagus untuk SEO dan accessibility.

### Responsive Design

Ini salah satu kekuatan terbesar proyek ini. Responsive-nya **sangat bagus**.

Saya lihat CSS-nya pakai mobile-first approach dengan breakpoints:
- Mobile: < 576px
- Tablet: 576px - 991px
- Desktop: ≥ 992px

Sidebar jadi horizontal menu di mobile. Card stack vertical. Table bisa horizontal scroll. Semua elemen resize dengan proper.

### Visual Design

Color scheme-nya modern: Indigo, Cyan, Green, Amber, Red. Kombinasi yang harmonis.

Gradient effects di stat cards dan buttons bikin tampilan tidak flat, ada depth. Professional.

Typography pakai Inter dari Google Fonts. Font yang bagus untuk web app.

Icons pakai Bootstrap Icons. Setiap menu, button, stat card ada iconnya. Membantu visual recognition.

### Animasi & Interaksi

Hover effects-nya smooth:
- Sidebar menu slide ke kanan sedikit saat hover
- Card lift up saat hover
- Button lift up saat hover
- Table row highlight saat hover

Ada animations:
- Alert slide in dari kiri
- Card fade in saat load
- Smooth transitions (0.3s cubic-bezier)

Scroll to top button juga ada (muncul setelah scroll 300px).

Ini detail-detail kecil yang bikin aplikasi terasa polish.

### Accessibility

File `ACCESSIBILITY.md` menunjukkan saudara perhatikan accessibility. Ada:
- Skip to main content link
- ARIA labels (`role`, `aria-label`, `aria-live`)
- Focus indicators yang jelas
- Keyboard navigation
- Color contrast yang cukup (WCAG AA)

Ini jarang mahasiswa perhatikan. Bagus!

### Yang Kurang

**Tidak ada pagination**. Kalau data mahasiswa sudah 1000, semua akan di-load di satu halaman. Browser bisa lemot.

Seharusnya ada pagination: "Showing 1-10 of 1000" dengan previous/next buttons.

**Tidak ada "entries per page" selector**. User tidak bisa pilih mau lihat 10, 25, 50, atau 100 data per halaman.

**Keyboard shortcuts tidak ada**. Misalnya Ctrl+N untuk tambah data baru, Ctrl+S untuk save, Esc untuk cancel.

Tapi untuk level tugas akhir, ini sudah sangat bagus.

**Nilai UI/UX: 90/100**

Pengurangan karena:
- Kurang pagination (-7)
- Kurang keyboard shortcuts (-3)

---

## 6. DOKUMENTASI

### Yang Excellent

Dokumentasi ini **luar biasa lengkap**. Jarang mahasiswa bikin dokumentasi se-comprehensive ini:

**LAPORAN_UAS.md**: Memenuhi semua requirement dosen
- Latar belakang masalah ✓
- Rancangan database (ERD, struktur tabel, normalisasi) ✓
- DFD Level 0 ✓
- Rancangan antarmuka (wireframe, color palette) ✓
- Implementasi antarmuka ✓
- Implementasi kode ✓

**README.md**: Dokumentasi utama yang lengkap
- Deskripsi proyek ✓
- Fitur-fitur ✓
- Teknologi yang digunakan ✓
- Struktur folder ✓
- Cara instalasi ✓
- Cara penggunaan ✓
- Database schema ✓
- Troubleshooting ✓

**INSTALLATION.md**: Panduan instalasi detail step-by-step untuk Windows, macOS, Linux. Ada troubleshooting untuk masalah umum.

**ACCESSIBILITY.md**: Dokumentasi standar WCAG 2.1, ARIA implementation, testing checklist.

**File tambahan**:
- FAQ.md
- CONTRIBUTING.md
- CHANGELOG.md
- PROJECT_STRUCTURE.txt

Ini level dokumentasi profesional, bukan level mahasiswa.

### Yang Kurang

**Screenshot belum di-insert ke LAPORAN_UAS.md**. Ada placeholder notes "insert screenshot di sini" tapi tidak ada screenshot-nya.

Sebelum submit ke dosen, wajib ambil screenshot:
- Dashboard view (desktop)
- Dashboard view (mobile)
- Form tambah data
- Table data
- Alert notifications

**Link GitHub belum ada!** Ini CRITICAL!

Instruksi dosen jelas: "Link aplikasi (GitHub atau sejenisnya)". Tapi di README dan LAPORAN_UAS tidak ada link GitHub.

Kalau proyek ini belum di-push ke GitHub, maka requirement belum terpenuhi. Ini bisa jadi masalah saat pengumpulan.

**Code comments kurang**. Ada beberapa fungsi kompleks yang tidak ada comment penjelasannya. Misalnya fungsi `base_url()` di helper.php yang logicnya cukup rumit.

**Nilai Dokumentasi: 85/100**

Pengurangan karena:
- Screenshot belum ada (-5)
- Link GitHub belum ada (-10)

---

## 7. PENILAIAN AKHIR

### Breakdown Nilai per Komponen

| Komponen | Nilai | Bobot | Nilai Tertimbang |
|----------|-------|-------|------------------|
| Analisis Kebutuhan | 85/100 | 15% | 12.75 |
| Database | 92/100 | 25% | 23.00 |
| Implementasi Kode | 88/100 | 30% | 26.40 |
| UI/UX | 90/100 | 20% | 18.00 |
| Dokumentasi | 85/100 | 10% | 8.50 |
| **TOTAL** | | **100%** | **88.65** |

### NILAI AKHIR: **88.65 / 100** (A-)

Kalau dibulatkan: **89/100**

---

## 8. KRITIK KONSTRUKTIF

### Kekuatan Proyek

1. **Database design sangat solid**. Normalisasi benar, constraint lengkap, relasi tepat.

2. **Security awareness bagus**. Prepared statement di semua query menunjukkan saudara paham SQL injection.

3. **UI/UX modern dan professional**. Responsive design-nya excellent. Animasi dan interaksi smooth. Tidak terlihat seperti tugas mahasiswa.

4. **Kode terstruktur dengan baik**. Modular, separation of concerns jelas, reusable functions.

5. **Dokumentasi comprehensive**. Ini nilai plus besar. Banyak mahasiswa yang males dokumentasi.

### Kelemahan Kritis

1. **Tidak ada sistem autentikasi**. Ini kelemahan paling fatal. Aplikasi akademik tanpa login itu tidak masuk akal. Siapa aja bisa akses dan modifikasi data.

2. **CSRF protection tidak ada**. Celah keamanan yang serius.

3. **SQL injection potential di ORDER BY**. Harus pakai whitelist.

4. **Link GitHub belum ada**. Requirement dosen belum terpenuhi.

5. **Screenshot belum di-insert**. Laporan belum final.

### Kelemahan Minor

1. Tidak ada pagination
2. Tidak ada export PDF/Excel
3. Tidak ada soft delete
4. CHECK constraint kurang lengkap
5. Session configuration kurang secure
6. Code comments kurang di bagian kompleks

---

## 9. PRIORITAS PERBAIKAN

Kalau mau nilai lebih bagus dan proyek benar-benar siap submit, perbaiki sesuai urutan prioritas:

### Prioritas 1 (WAJIB - Sebelum Submit)

**A. Upload ke GitHub**
- Buat repository baru
- Push semua file
- Buat README yang informatif
- Tambahkan link GitHub di README.md dan LAPORAN_UAS.md

**B. Insert Screenshot ke Laporan**
- Screenshot dashboard desktop
- Screenshot dashboard mobile
- Screenshot form dan table
- Insert ke LAPORAN_UAS.md

**C. Fix SQL Injection di ORDER BY**
```php
// Di semua index.php (mahasiswa, mata kuliah, nilai)
$allowed_orders = ['nim', 'nama', 'jurusan', 'angkatan'];
if (!in_array($order, $allowed_orders)) $order = 'nim';

$allowed_sorts = ['ASC', 'DESC'];
if (!in_array($sort, $allowed_sorts)) $sort = 'ASC';
```

### Prioritas 2 (Penting - Untuk Nilai Lebih Baik)

**D. Tambah CSRF Protection**
```php
// Di header.php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Di setiap form
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

// Di setiap POST handler
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Invalid CSRF token');
}
```

**E. Tambah Sistem Login Sederhana**

Minimal ada:
- Tabel `users` dengan username dan password
- Halaman login
- Session check di setiap page
- Logout functionality

Tidak perlu role management yang kompleks. Admin sederhana sudah cukup.

**F. Tambah CHECK Constraint di Database**
```sql
ALTER TABLE mata_kuliah ADD CONSTRAINT chk_sks CHECK (sks >= 1 AND sks <= 6);
ALTER TABLE mahasiswa ADD CONSTRAINT chk_angkatan CHECK (angkatan >= 2000 AND angkatan <= YEAR(CURDATE()) + 1);
```

### Prioritas 3 (Opsional - Bonus)

**G. Pagination**
- Tambah LIMIT dan OFFSET di query
- Buat navigation buttons (Previous/Next)
- Tampilkan "Showing 1-10 of 100"

**H. Export ke PDF/Excel**
- Pakai library TCPDF atau mPDF
- Button "Export PDF" di setiap index page
- Generate laporan sederhana

**I. Session Security**
```php
// Di header.php sebelum session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Jika pakai HTTPS
ini_set('session.use_strict_mode', 1);
```

---

## 10. KESIMPULAN

### Apakah Proyek Ini LAYAK DIKUMPULKAN?

**JAWABAN: BELUM LAYAK DIKUMPULKAN SEKARANG**

**Alasan:**

1. **Link GitHub belum ada** → Ini requirement wajib dari dosen yang belum terpenuhi.

2. **Screenshot belum di-insert** → Laporan UAS belum final.

3. **SQL Injection potential di ORDER BY** → Ini bug yang harus diperbaiki, bukan cuma minor issue.

Kalau saudara submit sekarang, kemungkinan besar akan diminta revisi atau nilai dikurangi.

### Apa yang Harus Dilakukan?

**Minimal perbaiki Prioritas 1** (GitHub, Screenshot, SQL Injection fix). Itu paling penting.

Kalau sudah, baru proyek ini **LAYAK DIKUMPULKAN**.

Dengan perbaikan Prioritas 1, saya perkirakan nilai bisa naik jadi **91-92/100** (A).

Kalau sampai Prioritas 2 juga dikerjakan (CSRF, Login, CHECK constraint), nilai bisa **94-95/100** (A).

### Pesan Penutup

Secara keseluruhan, ini proyek yang **sangat bagus untuk level mahasiswa**. Database solid, kode terstruktur, UI modern, dokumentasi lengkap.

Kelemahan utamanya di security (no login, no CSRF) dan kelengkapan (no pagination, no export).

Tapi dengan sedikit perbaikan di Prioritas 1 dan 2, ini bisa jadi proyek yang excellent.

Saya lihat saudara punya pemahaman yang baik tentang development process: analisis, design, implementation, testing, documentation. Ini foundation yang kuat.

Yang perlu ditingkatkan adalah awareness terhadap security dan production-readiness. Aplikasi yang baik bukan cuma functional, tapi juga secure dan complete.

Good luck dengan perbaikannya!

---

**Catatan Tambahan:**

Kalau ada pertanyaan tentang perbaikan atau butuh klarifikasi tentang aspek tertentu, silakan tanya. Saya bisa jelaskan lebih detail.

Jangan langsung defensive kalau dapat kritik. Kritik ini justru untuk membantu saudara jadi developer yang lebih baik.

Sekian audit saya. Semoga bermanfaat.

---

**Dosen Pengampu**  
Mata Kuliah: Pengembangan Aplikasi Basis Data  
28 Juni 2026
