# LAPORAN PROYEK AKHIR
## PENGEMBANGAN APLIKASI BASIS DATA

---

**Mata Kuliah:** Pengembangan Aplikasi Basis Data  
**Judul Proyek:** Sistem Nilai Mahasiswa  
**Nama Mahasiswa:** Azmy Hanif Abdurrahman 
**NIM:**  20240100095
**Kelas:**  A
**Dosen Pengampu:**  Ibu Latifa Iriani 
**Tanggal:**  27 Juni 2026

---

## DAFTAR ISI

1. [Latar Belakang Masalah](#1-latar-belakang-masalah)
2. [Rancangan Database](#2-rancangan-database)
3. [Alur Sistem (Level 0)](#3-alur-sistem-level-0)
4. [Rancangan Antarmuka](#4-rancangan-antarmuka)
5. [Implementasi Antarmuka](#5-implementasi-antarmuka)
6. [Implementasi Kode Pemrograman](#6-implementasi-kode-pemrograman)
7. [Link Aplikasi](#7-link-aplikasi)

---

## 1. LATAR BELAKANG MASALAH

### 1.1 Konteks Masalah

Dalam era digital saat ini, pengelolaan data akademik secara manual menghadapi berbagai tantangan seperti kesulitan dalam pencatatan, pencarian data, dan pembuatan laporan. Banyak institusi pendidikan masih menggunakan sistem pencatatan nilai secara manual menggunakan buku atau spreadsheet yang rentan terhadap kesalahan input dan kehilangan data.

### 1.2 Identifikasi Masalah

Berdasarkan observasi, ditemukan beberapa permasalahan dalam pengelolaan nilai mahasiswa:

1. **Pencatatan Manual yang Tidak Efisien**
   - Memakan waktu lama untuk input data
   - Rentan terhadap kesalahan tulis (human error)
   - Sulit untuk melakukan backup data

2. **Kesulitan Pencarian Data**
   - Mencari data mahasiswa tertentu memerlukan waktu
   - Tidak ada fitur filter atau sorting
   - Data tersebar di berbagai file

3. **Perhitungan Grade Manual**
   - Konversi nilai angka ke huruf dilakukan manual
   - Berpotensi terjadi kesalahan konversi
   - Tidak konsisten antar pengajar

4. **Validasi Data yang Lemah**
   - Data duplikat bisa terjadi
   - Tidak ada validasi format input
   - Integritas data tidak terjaga

5. **Pelaporan yang Sulit**
   - Membuat statistik nilai memerlukan kalkulasi manual
   - Tidak ada visualisasi data
   - Sulit melacak perkembangan mahasiswa

### 1.3 Tujuan Proyek

Proyek ini bertujuan untuk:

1. **Mengembangkan Sistem Informasi**
   - Membuat aplikasi web untuk manajemen nilai mahasiswa
   - Mengimplementasikan konsep basis data relasional
   - Menerapkan operasi CRUD (Create, Read, Update, Delete)

2. **Meningkatkan Efisiensi**
   - Mempercepat proses input dan pencarian data
   - Otomasi perhitungan grade
   - Validasi data secara otomatis

3. **Menjamin Integritas Data**
   - Menggunakan foreign key constraint
   - Validasi input di server-side
   - Mencegah data duplikat

4. **Menyediakan Informasi Real-time**
   - Dashboard statistik
   - Pencarian dan sorting data
   - Laporan nilai per mahasiswa

### 1.4 Manfaat Proyek

**Manfaat Praktis:**
- Mempermudah pengelolaan data mahasiswa, mata kuliah, dan nilai
- Mengurangi kesalahan input data
- Menghemat waktu dalam pencarian dan pelaporan data

**Manfaat Akademis:**
- Implementasi konsep basis data relasional
- Penerapan best practices dalam pengembangan web
- Pembelajaran keamanan aplikasi web (SQL Injection, XSS)

**Manfaat Pengembangan:**
- Dapat dikembangkan lebih lanjut dengan fitur tambahan
- Menjadi portfolio dalam pengembangan aplikasi
- Referensi untuk proyek sejenis

### 1.5 Batasan Masalah

Untuk fokus pengembangan, proyek ini memiliki batasan:

1. Aplikasi hanya untuk satu institusi/kampus
2. Satu role pengguna (Admin), tanpa sistem login
3. Tidak ada fitur export ke PDF/Excel
4. Tidak ada notifikasi email atau SMS
5. Tidak ada fitur backup otomatis
6. Fokus pada operasi CRUD dan relasi database


---

## 2. RANCANGAN DATABASE

### 2.1 Entity Relationship Diagram (ERD)

```
┌─────────────────────────────────┐
│         MAHASISWA               │
├─────────────────────────────────┤
│ • id (PK)                       │
│   nim (UNIQUE, NOT NULL)        │
│   nama (NOT NULL)               │
│   jurusan (NOT NULL)            │
│   angkatan (NOT NULL)           │
│   created_at (TIMESTAMP)        │
│   updated_at (TIMESTAMP)        │
└──────────┬──────────────────────┘
           │
           │ 1
           │
           │
           │ N
           │
┌──────────▼──────────────────────┐         ┌─────────────────────────────────┐
│           NILAI                 │         │       MATA_KULIAH               │
├─────────────────────────────────┤         ├─────────────────────────────────┤
│ • id (PK)                       │    N    │ • id (PK)                       │
│ • mahasiswa_id (FK) ────────────┼─────────│   kode_mk (UNIQUE, NOT NULL)    │
│ • mata_kuliah_id (FK)           │    1    │   nama_mk (NOT NULL)            │
│   nilai (0-100, NOT NULL)       │◄────────┤   sks (NOT NULL)                │
│   grade (NOT NULL)              │         │   created_at (TIMESTAMP)        │
│   created_at (TIMESTAMP)        │         │   updated_at (TIMESTAMP)        │
│   updated_at (TIMESTAMP)        │         │                                 │
│                                 │         └─────────────────────────────────┘
│ UNIQUE(mahasiswa_id,            │
│        mata_kuliah_id)          │
└─────────────────────────────────┘
```

**Penjelasan Relasi:**
- Mahasiswa memiliki relasi **One-to-Many** dengan Nilai (satu mahasiswa bisa memiliki banyak nilai)
- Mata Kuliah memiliki relasi **One-to-Many** dengan Nilai (satu mata kuliah bisa dinilai oleh banyak mahasiswa)
- Nilai sebagai tabel penghubung dengan composite unique constraint untuk mencegah duplikasi

### 2.2 Struktur Tabel

#### Tabel: mahasiswa

| Kolom      | Tipe Data    | Constraint                    | Deskripsi                |
|------------|--------------|-------------------------------|--------------------------|
| id         | INT(11)      | PRIMARY KEY, AUTO_INCREMENT   | ID unik mahasiswa        |
| nim        | VARCHAR(20)  | UNIQUE, NOT NULL              | Nomor Induk Mahasiswa    |
| nama       | VARCHAR(100) | NOT NULL                      | Nama lengkap mahasiswa   |
| jurusan    | VARCHAR(50)  | NOT NULL                      | Program studi            |
| angkatan   | INT(11)      | NOT NULL                      | Tahun angkatan           |
| created_at | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP     | Waktu pembuatan record   |
| updated_at | TIMESTAMP    | ON UPDATE CURRENT_TIMESTAMP   | Waktu update record      |

**Index:**
- PRIMARY KEY: `id`
- UNIQUE KEY: `nim`
- INDEX: `angkatan`, `jurusan`

#### Tabel: mata_kuliah

| Kolom      | Tipe Data    | Constraint                    | Deskripsi                |
|------------|--------------|-------------------------------|--------------------------|
| id         | INT(11)      | PRIMARY KEY, AUTO_INCREMENT   | ID unik mata kuliah      |
| kode_mk    | VARCHAR(10)  | UNIQUE, NOT NULL              | Kode mata kuliah         |
| nama_mk    | VARCHAR(100) | NOT NULL                      | Nama mata kuliah         |
| sks        | INT(11)      | NOT NULL                      | Jumlah SKS (1-6)         |
| created_at | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP     | Waktu pembuatan record   |
| updated_at | TIMESTAMP    | ON UPDATE CURRENT_TIMESTAMP   | Waktu update record      |

**Index:**
- PRIMARY KEY: `id`
- UNIQUE KEY: `kode_mk`
- INDEX: `sks`


#### Tabel: nilai

| Kolom           | Tipe Data     | Constraint                        | Deskripsi                    |
|-----------------|---------------|-----------------------------------|------------------------------|
| id              | INT(11)       | PRIMARY KEY, AUTO_INCREMENT       | ID unik nilai                |
| mahasiswa_id    | INT(11)       | FOREIGN KEY, NOT NULL             | Referensi ke mahasiswa       |
| mata_kuliah_id  | INT(11)       | FOREIGN KEY, NOT NULL             | Referensi ke mata_kuliah     |
| nilai           | DECIMAL(5,2)  | NOT NULL, CHECK (0-100)           | Nilai numerik (0-100)        |
| grade           | VARCHAR(2)    | NOT NULL                          | Grade huruf (A, B+, C, dll)  |
| created_at      | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP         | Waktu pembuatan record       |
| updated_at      | TIMESTAMP     | ON UPDATE CURRENT_TIMESTAMP       | Waktu update record          |

**Index & Constraint:**
- PRIMARY KEY: `id`
- FOREIGN KEY: `mahasiswa_id` → `mahasiswa(id)` ON DELETE RESTRICT ON UPDATE CASCADE
- FOREIGN KEY: `mata_kuliah_id` → `mata_kuliah(id)` ON DELETE RESTRICT ON UPDATE CASCADE
- UNIQUE KEY: `(mahasiswa_id, mata_kuliah_id)` - Mencegah duplikasi nilai
- CHECK: `nilai BETWEEN 0 AND 100`
- INDEX: `grade`

### 2.3 Normalisasi Database

#### Bentuk Normal 1 (1NF)
✅ **Terpenuhi:**
- Setiap kolom berisi nilai atomic (tidak ada array atau list)
- Tidak ada repeating groups
- Setiap tabel memiliki primary key
- Setiap cell berisi satu nilai

#### Bentuk Normal 2 (2NF)
✅ **Terpenuhi:**
- Sudah dalam 1NF
- Tidak ada partial dependency
- Setiap non-key attribute fully dependent pada primary key
- Contoh: Pada tabel nilai, `nilai` dan `grade` fully dependent pada `id`

#### Bentuk Normal 3 (3NF)
✅ **Terpenuhi:**
- Sudah dalam 2NF
- Tidak ada transitive dependency
- Non-key attributes tidak bergantung pada non-key lainnya
- Contoh: `nama_mk` tidak bergantung pada `sks`, keduanya independent

**Kesimpulan:** Database sudah ternormalisasi hingga 3NF, memastikan:
- Tidak ada redundansi data
- Update anomaly diminimalisir
- Delete anomaly tidak terjadi
- Insert anomaly tidak ada

### 2.4 Sistem Perhitungan Grade

| Grade | Range Nilai  | Deskripsi        |
|-------|--------------|------------------|
| A     | 85 - 100     | Sangat Baik      |
| A-    | 80 - 84      | Baik Sekali      |
| B+    | 75 - 79      | Lebih dari Baik  |
| B     | 70 - 74      | Baik             |
| B-    | 65 - 69      | Cukup Baik       |
| C+    | 60 - 64      | Lebih dari Cukup |
| C     | 55 - 59      | Cukup            |
| D     | 40 - 54      | Kurang           |
| E     | 0 - 39       | Gagal            |

**Implementasi:** Grade dihitung otomatis menggunakan fungsi `calculate_grade()` saat input atau update nilai.


---

## 3. ALUR SISTEM (LEVEL 0)

### 3.1 Data Flow Diagram (DFD) Level 0

```
                           ┌─────────────────────────────────┐
                           │                                 │
                           │    SISTEM NILAI MAHASISWA       │
                           │                                 │
                           └─────────────────────────────────┘
                                      ▲         │
                                      │         │
                    ┌─────────────────┴─┐   ┌──▼─────────────────┐
                    │                   │   │                    │
        Input Data  │   Dashboard Info  │   │   Data Reports     │
        Mahasiswa   │   Statistik       │   │   Search Results   │
        Mata Kuliah │                   │   │                    │
        Nilai       │                   │   │                    │
                    │                   │   │                    │
                    │                   │   │                    │
              ┌─────▼─────┐       ┌────┴───▼────┐
              │           │       │              │
              │   ADMIN   │       │   DATABASE   │
              │           │       │  sistem_nilai│
              └───────────┘       └──────────────┘
```

### 3.2 Proses Bisnis Utama

#### 3.2.1 Proses Manajemen Mahasiswa

```
START
  │
  ├─→ Admin Membuka "Data Mahasiswa"
  │
  ├─→ Sistem Menampilkan List Mahasiswa dari Database
  │
  ├─→ Admin Memilih Aksi:
  │   ├─→ [TAMBAH]
  │   │   ├─→ Buka Form Input
  │   │   ├─→ Validasi Input (NIM unique, field required)
  │   │   ├─→ Simpan ke Database
  │   │   └─→ Tampilkan Notifikasi Sukses
  │   │
  │   ├─→ [EDIT]
  │   │   ├─→ Load Data Existing
  │   │   ├─→ Update Form
  │   │   ├─→ Validasi Input
  │   │   ├─→ Update Database
  │   │   └─→ Tampilkan Notifikasi Sukses
  │   │
  │   ├─→ [HAPUS]
  │   │   ├─→ Cek Relasi (Apakah punya nilai?)
  │   │   ├─→ [Ya] → Error "Tidak bisa dihapus"
  │   │   ├─→ [Tidak] → Delete dari Database
  │   │   └─→ Tampilkan Notifikasi Sukses
  │   │
  │   └─→ [SEARCH/SORT]
  │       ├─→ Input Keyword
  │       ├─→ Query Database dengan Filter
  │       └─→ Tampilkan Hasil
  │
END
```

#### 3.2.2 Proses Input Nilai

```
START
  │
  ├─→ Admin Membuka "Data Nilai" → "Tambah Nilai"
  │
  ├─→ Sistem Load Dropdown Mahasiswa & Mata Kuliah
  │
  ├─→ Admin Memilih:
  │   ├─→ Mahasiswa (dari dropdown)
  │   ├─→ Mata Kuliah (dari dropdown)
  │   └─→ Input Nilai (0-100)
  │
  ├─→ Sistem Validasi:
  │   ├─→ Nilai harus 0-100? [Tidak] → Error
  │   ├─→ Kombinasi Mahasiswa+Matkul sudah ada? [Ya] → Error
  │   └─→ [Semua Valid] → Lanjut
  │
  ├─→ Sistem Hitung Grade Otomatis
  │   └─→ calculate_grade(nilai) → return grade
  │
  ├─→ Simpan ke Database (mahasiswa_id, mata_kuliah_id, nilai, grade)
  │
  ├─→ Tampilkan Notifikasi Sukses
  │
END
```


#### 3.2.3 Alur Dashboard

```
START
  │
  ├─→ Admin Akses Dashboard (index.php)
  │
  ├─→ Sistem Query Database:
  │   ├─→ COUNT(*) FROM mahasiswa → Total Mahasiswa
  │   ├─→ COUNT(*) FROM mata_kuliah → Total Mata Kuliah
  │   ├─→ COUNT(*) FROM nilai → Total Data Nilai
  │   └─→ AVG(nilai) FROM nilai → Rata-rata Nilai
  │
  ├─→ Sistem Render Dashboard:
  │   ├─→ 4 Statistik Cards (dengan gradient)
  │   └─→ 3 Quick Access Cards (link ke modul)
  │
  ├─→ Admin Dapat:
  │   ├─→ Lihat statistik real-time
  │   └─→ Akses cepat ke setiap modul
  │
END
```

### 3.3 Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────┐
│                   PRESENTATION LAYER                    │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │   HTML5      │  │   Bootstrap  │  │  JavaScript  │  │
│  │   Semantic   │  │   CSS3       │  │   Vanilla    │  │
│  └──────────────┘  └──────────────┘  └──────────────┘  │
└─────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────┐
│                   BUSINESS LOGIC LAYER                  │
│  ┌──────────────────────────────────────────────────┐   │
│  │  PHP Native 7.4+                                 │   │
│  │  - CRUD Operations                               │   │
│  │  - Validation Functions                          │   │
│  │  - Helper Functions                              │   │
│  │  - Grade Calculation                             │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────┐
│                   DATA ACCESS LAYER                     │
│  ┌──────────────────────────────────────────────────┐   │
│  │  MySQLi with Prepared Statements                 │   │
│  │  - SQL Injection Prevention                      │   │
│  │  - Connection Management                         │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────┐
│                   DATABASE LAYER                        │
│  ┌──────────────────────────────────────────────────┐   │
│  │  MySQL 5.7+ / MariaDB                            │   │
│  │  - InnoDB Engine                                 │   │
│  │  - Foreign Key Constraints                       │   │
│  │  - Transaction Support                           │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

### 3.4 Flow Interaksi User-System

```
USER (Admin)  →  REQUEST  →  PHP PROCESSOR  →  DATABASE
     │                             │                │
     │                             │                │
     │                       [Validation]           │
     │                       [Sanitization]         │
     │                       [Business Logic]       │
     │                             │                │
     │                             ├──[SELECT]──────►
     │                             ◄──[RESULT]──────┤
     │                             │                │
     │                       [Process Data]         │
     │                       [Calculate Grade]      │
     │                       [Format Output]        │
     │                             │                │
     ◄───────  RESPONSE  ──────────┤                │
     (HTML + Data)
```


---

## 4. RANCANGAN ANTARMUKA

### 4.1 Halaman Dashboard (Index)

#### 4.1.1 Wireframe Dashboard

```
┌─────────────────────────────────────────────────────────────────┐
│  NAVBAR: [Logo] Sistem Nilai Mahasiswa              [Dashboard] │
├─────────────────────────────────────────────────────────────────┤
│ SIDE │  MAIN CONTENT AREA                                       │
│ BAR  │  ┌──────────────────────────────────────────────────┐    │
│      │  │  📊 Dashboard                                    │    │
│ 📊   │  │  Selamat datang di Sistem Nilai Mahasiswa        │    │
│ Dash │  └──────────────────────────────────────────────────┘    │
│      │                                                           │
│ 👥   │  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐           │
│ Data │  │ Total  │ │ Total  │ │ Total  │ │ Rata2  │           │
│ Mhs  │  │ Mhs: 8 │ │ MK: 8  │ │ Nilai  │ │ Nilai  │           │
│      │  │ 👥     │ │ 📚     │ │ 21 📊  │ │ 75.5📈 │           │
│ 📚   │  └────────┘ └────────┘ └────────┘ └────────┘           │
│ Data │                                                           │
│ MK   │  Quick Access:                                           │
│      │  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐    │
│ 📊   │  │ 👥           │ │ 📚           │ │ 📊           │    │
│ Data │  │ Data         │ │ Data Mata    │ │ Data         │    │
│ Nilai│  │ Mahasiswa    │ │ Kuliah       │ │ Nilai        │    │
│      │  │              │ │              │ │              │    │
│      │  │ [Kelola →]   │ │ [Kelola →]   │ │ [Kelola →]   │    │
│      │  └──────────────┘ └──────────────┘ └──────────────┘    │
└──────┴───────────────────────────────────────────────────────────┘
│ FOOTER: © 2026 Sistem Nilai Mahasiswa                           │
└──────────────────────────────────────────────────────────────────┘
```

#### 4.1.2 Deskripsi Komponen Dashboard

**1. Navbar (Navigation Bar)**
- **Posisi:** Top, full-width
- **Background:** Gradient biru (primary color)
- **Konten:**
  - Logo + Brand name "Sistem Nilai Mahasiswa"
  - Link "Dashboard"
  - Indicator "Admin"
- **Fungsi:** Navigasi global, identitas aplikasi

**2. Sidebar (Side Navigation)**
- **Posisi:** Left side, fixed
- **Background:** White dengan shadow
- **Konten:**
  - Menu items:
    - 📊 Dashboard (active state)
    - 👥 Data Mahasiswa
    - 📚 Data Mata Kuliah
    - 📊 Data Nilai
- **Fungsi:** Navigasi antar modul
- **Interaksi:** Hover effect, active state highlighting

**3. Statistik Cards (4 Cards)**
- **Layout:** Grid 4 kolom (responsive)
- **Style:** 
  - Gradient background berbeda tiap card
  - Shadow untuk depth
  - Icon besar di kanan atas
- **Konten:**
  - Card 1: Total Mahasiswa (gradient ungu)
  - Card 2: Total Mata Kuliah (gradient pink)
  - Card 3: Total Data Nilai (gradient biru)
  - Card 4: Rata-rata Nilai (gradient kuning)
- **Fungsi:** Menampilkan statistik real-time
- **Data Source:** Query COUNT() dan AVG() dari database

**4. Quick Access Cards (3 Cards)**
- **Layout:** Grid 3 kolom (responsive)
- **Style:**
  - White background
  - Icon besar dengan warna sesuai modul
  - Button dengan gradient
- **Konten:**
  - Card 1: Data Mahasiswa (icon people, button primary)
  - Card 2: Data Mata Kuliah (icon book, button success)
  - Card 3: Data Nilai (icon clipboard, button info)
- **Fungsi:** Shortcut ke setiap modul CRUD
- **Interaksi:** Hover scale effect

**5. Footer**
- **Posisi:** Bottom, full-width
- **Background:** Light gray
- **Konten:** Copyright text
- **Fungsi:** Informasi copyright


#### 4.1.3 Color Palette & Typography

**Color Scheme:**
- **Primary:** `#6366f1` (Indigo) - Navbar, buttons
- **Success:** `#10b981` (Green) - Success messages, mata kuliah
- **Info:** `#06b6d4` (Cyan) - Data nilai
- **Warning:** `#f59e0b` (Amber) - Rata-rata nilai
- **Danger:** `#ef4444` (Red) - Delete buttons, errors
- **Gray Scale:** `#f5f7fa` (Background), `#1f2937` (Text)

**Typography:**
- **Font Family:** Inter (Google Fonts) - Modern, readable
- **Heading:** Font-weight 700 (Bold)
- **Body:** Font-weight 400 (Regular)
- **Sizes:**
  - h1: 2rem (Dashboard title)
  - h2: 2.75rem (Stat numbers)
  - h3: 1.25rem (Card titles)
  - Body: 1rem (Normal text)

**Responsive Breakpoints:**
- Mobile: < 576px
- Tablet: 576px - 991px
- Desktop: ≥ 992px

#### 4.1.4 User Experience (UX) Design

**Principles Applied:**
1. **Simplicity:** Clean layout, minimal clutter
2. **Consistency:** Same design pattern di semua halaman
3. **Feedback:** Alert notifications untuk setiap action
4. **Accessibility:** WCAG 2.1 AA compliant
5. **Responsiveness:** Mobile-first approach

**Interaction Design:**
- **Hover States:** Button elevate, sidebar items slide
- **Active States:** Sidebar menu highlighted
- **Loading States:** Smooth transitions
- **Error States:** Red alerts dengan icon
- **Success States:** Green alerts dengan icon

---

## 5. IMPLEMENTASI ANTARMUKA

### 5.1 Halaman Dashboard - Implementasi Lengkap

Berikut adalah implementasi dashboard yang telah dibangun:

#### 5.1.1 Screenshot Dashboard

```
[CATATAN: Pada saat submit laporan, insert screenshot dashboard di sini]

Lokasi file screenshot yang perlu diambil:
- Dashboard view desktop (1920x1080)
- Dashboard view mobile (375x667)
- Statistik cards close-up
- Quick access cards
```

#### 5.1.2 HTML Structure (Semantic HTML5)

```html
<!-- Main Container -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar (Semantic HTML) -->
        <aside class="col-md-2 p-0" role="complementary">
            <nav aria-label="Sidebar navigation">
                <!-- Menu items with proper ARIA -->
            </nav>
        </aside>
        
        <!-- Main Content (Semantic HTML) -->
        <main class="col-md-10 content" role="main" id="main-content">
            <!-- Content Header -->
            <header class="content-header">
                <h1>📊 Dashboard</h1>
                <p>Selamat datang di Sistem Nilai Mahasiswa</p>
            </header>
            
            <!-- Statistics Section -->
            <section aria-labelledby="statistics-heading">
                <h2 class="visually-hidden">Statistik Data</h2>
                <!-- 4 Stat Cards -->
            </section>
            
            <!-- Quick Access Section -->
            <section aria-labelledby="quick-access-heading">
                <h2 class="visually-hidden">Quick Access</h2>
                <!-- 3 Quick Access Cards -->
            </section>
        </main>
    </div>
</div>
```

**Semantic Elements Used:**
- `<main>` untuk konten utama
- `<aside>` untuk sidebar
- `<nav>` untuk navigasi
- `<header>` untuk page header
- `<section>` untuk grouping konten
- `<article>` untuk stat cards
- `<footer>` untuk copyright



---

## 6. IMPLEMENTASI KODE PEMROGRAMAN

### 6.1 Fungsi CRUD Mahasiswa

Implementasi CRUD (Create, Read, Update, Delete) untuk modul mahasiswa menggunakan prepared statement dan validasi lengkap.

#### Create (Tambah Data)
```php
// Validasi CSRF token
if (!validate_csrf_token($_POST['csrf_token'])) {
    set_alert('danger', 'Invalid CSRF token');
    redirect('create.php');
}

// Sanitasi input
$nim = clean($_POST['nim']);
$nama = clean($_POST['nama']);
$jurusan = clean($_POST['jurusan']);
$angkatan = clean($_POST['angkatan']);

// Validasi
validate_required($nim, 'NIM');
validate_nim_unique($conn, $nim);

// Insert dengan prepared statement
$stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nim, $nama, $jurusan, $angkatan);
$stmt->execute();
```

#### Read (Tampil Data)
```php
// Whitelist ORDER BY untuk mencegah SQL injection
$allowed_orders = ['nim', 'nama', 'jurusan', 'angkatan'];
$order = in_array($_GET['order'], $allowed_orders) ? $_GET['order'] : 'nim';

$allowed_sorts = ['ASC', 'DESC'];
$sort = in_array($_GET['sort'], $allowed_sorts) ? $_GET['sort'] : 'ASC';

// Query dengan prepared statement
$sql = "SELECT * FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ? ORDER BY $order $sort";
$search_param = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
```

#### Update (Edit Data)
```php
// Validasi CSRF
validate_csrf_token($_POST['csrf_token']);

// Update dengan prepared statement
$stmt = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, angkatan = ? WHERE id = ?");
$stmt->bind_param("sssii", $nim, $nama, $jurusan, $angkatan, $id);
$stmt->execute();
```

#### Delete (Hapus Data)
```php
// Cek relasi dengan tabel lain
if (check_mahasiswa_has_nilai($conn, $id)) {
    set_alert('danger', 'Tidak dapat menghapus mahasiswa yang memiliki nilai!');
    redirect('index.php');
}

// Delete dengan prepared statement
$stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
```

### 6.2 Fungsi Grade Calculation

```php
function calculate_grade($nilai) {
    if ($nilai >= 85) return 'A';
    if ($nilai >= 80) return 'A-';
    if ($nilai >= 75) return 'B+';
    if ($nilai >= 70) return 'B';
    if ($nilai >= 65) return 'B-';
    if ($nilai >= 60) return 'C+';
    if ($nilai >= 55) return 'C';
    if ($nilai >= 40) return 'D';
    return 'E';
}
```

### 6.3 Fitur Keamanan

**Prepared Statement (SQL Injection Prevention)**
```php
// ✓ Aman dari SQL Injection
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$stmt->bind_param("s", $nim);
```

**XSS Prevention**
```php
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
```

**CSRF Protection**
```php
// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Validasi CSRF token
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
}
```

**Session Security**
```php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
```

---

## 7. LINK APLIKASI

### 7.1 Repository GitHub

**Link Repository:** https://github.com/azmy20240100095/sistem-nilai-mahasiswa

*(Ganti `username` dengan username GitHub Anda)*

**Struktur Repository:**
```
sistem-nilai-mahasiswa/
├── assets/           # CSS, JavaScript, Images
├── config/           # Database configuration
├── database/         # SQL file
├── helpers/          # Helper & validation functions
├── includes/         # Template components
├── modules/          # CRUD modules
│   ├── mahasiswa/
│   ├── mata-kuliah/
│   └── nilai/
├── README.md
├── LAPORAN_UAS.md
└── index.php
```

### 7.2 Cara Clone & Install

```bash
# Clone repository
git clone https://github.com/username/sistem-nilai-mahasiswa.git

# Masuk ke folder
cd sistem-nilai-mahasiswa

# Copy ke htdocs
cp -r . /xampp/htdocs/sistem-nilai-mahasiswa

# Import database
# Buka phpMyAdmin → Import → database/sistem_nilai.sql

# Akses aplikasi
# http://localhost/sistem-nilai-mahasiswa
```

Panduan lengkap ada di [INSTALLATION.md](INSTALLATION.md)

### 7.3 Demo Online

Jika aplikasi sudah di-deploy:
- **URL:** (belum di-deploy)
- **Server:** (opsional - jika ada)

---

## 8. KESIMPULAN

Sistem Nilai Mahasiswa telah berhasil diimplementasikan dengan fitur-fitur berikut:

### 8.1 Fitur yang Telah Diimplementasi

✅ **Database Design**
- ERD dengan 3 tabel (Mahasiswa, Mata Kuliah, Nilai)
- Normalisasi hingga 3NF
- Foreign key constraints
- Unique constraints
- CHECK constraints untuk validasi data

✅ **CRUD Operations**
- Create: Form input dengan validasi lengkap
- Read: List data dengan search dan sorting
- Update: Form edit dengan validasi
- Delete: Dengan pengecekan relasi

✅ **Security Features**
- Prepared statement untuk semua query
- Input sanitization (XSS prevention)
- CSRF protection
- Session security configuration
- SQL injection prevention dengan whitelist ORDER BY

✅ **User Interface**
- Responsive design (mobile, tablet, desktop)
- Modern UI dengan gradient effects
- Dashboard dengan statistik real-time
- Accessibility compliant (WCAG 2.1 AA)

✅ **Business Logic**
- Grade calculation otomatis
- Validasi duplikasi data
- Relational integrity check
- Flash message system

### 8.2 Teknologi yang Digunakan

- **Backend:** PHP 7.4+ (Native)
- **Database:** MySQL 5.7+ / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript ES6+
- **Framework CSS:** Bootstrap 5.3.0
- **Icons:** Bootstrap Icons
- **Fonts:** Inter (Google Fonts)

### 8.3 Best Practices yang Diterapkan

1. **Separation of Concerns** - Config, helpers, modules terpisah
2. **DRY Principle** - Reusable functions
3. **Prepared Statement** - Security first
4. **Input Validation** - Server-side dan client-side
5. **Responsive Design** - Mobile-first approach
6. **Clean Code** - Naming convention konsisten
7. **Documentation** - Lengkap dan terstruktur

### 8.4 Pembelajaran yang Didapat

Dari proyek ini, telah dipelajari:
- Perancangan database relasional yang baik
- Implementasi operasi CRUD dengan PHP Native
- Security best practices (SQL injection, XSS, CSRF)
- Responsive web design
- Project structure dan documentation

---

## 9. SARAN PENGEMBANGAN

Untuk pengembangan lebih lanjut, dapat ditambahkan:

1. **Sistem Autentikasi**
   - Login/Logout
   - Role management (Admin, Dosen, Mahasiswa)
   - Session management

2. **Fitur Export**
   - Export ke PDF
   - Export ke Excel
   - Print transkrip nilai

3. **Pagination**
   - Limit data per halaman
   - Navigation buttons
   - Entries per page selector

4. **Advanced Features**
   - Upload foto mahasiswa
   - Grafik statistik
   - Laporan per semester
   - Filter berdasarkan jurusan/angkatan

5. **Performance Optimization**
   - Query optimization
   - Caching mechanism
   - Image optimization

---

## 10. REFERENSI

1. **PHP Official Documentation**  
   https://www.php.net/docs.php

2. **MySQL Documentation**  
   https://dev.mysql.com/doc/

3. **Bootstrap 5 Documentation**  
   https://getbootstrap.com/docs/5.3/

4. **OWASP Security Guidelines**  
   https://owasp.org/www-project-web-security-testing-guide/

5. **W3C Web Accessibility Guidelines (WCAG 2.1)**  
   https://www.w3.org/WAI/WCAG21/quickref/

---
