# 🎓 Sistem Nilai Mahasiswa

Aplikasi web untuk manajemen data nilai mahasiswa yang dibangun dengan **PHP Native**, **MySQL**, dan **Bootstrap 5**.

## 🔗 Link Repository

**GitHub:** [https://github.com/username/sistem-nilai-mahasiswa](https://github.com/username/sistem-nilai-mahasiswa)  


---

## 📋 Deskripsi Proyek

Sistem Nilai Mahasiswa adalah aplikasi berbasis web yang memungkinkan admin untuk mengelola data mahasiswa, mata kuliah, dan nilai secara efisien. Aplikasi ini dibuat sebagai proyek UAS mata kuliah Pengembangan Aplikasi Basis Data.

## ✨ Fitur Utama

### 🏠 Dashboard
- Statistik total mahasiswa
- Statistik total mata kuliah
- Statistik total data nilai
- Rata-rata nilai keseluruhan
- Quick access ke semua modul

### 👥 Manajemen Mahasiswa
- ✅ Tambah data mahasiswa (NIM, Nama, Jurusan, Angkatan)
- ✅ Edit data mahasiswa
- ✅ Hapus data mahasiswa (dengan validasi relasi)
- ✅ Pencarian data mahasiswa
- ✅ Sorting data (NIM, Nama, Jurusan, Angkatan)

### 📚 Manajemen Mata Kuliah
- ✅ Tambah mata kuliah (Kode MK, Nama MK, SKS)
- ✅ Edit mata kuliah
- ✅ Hapus mata kuliah (dengan validasi relasi)
- ✅ Pencarian mata kuliah
- ✅ Sorting data

### 📊 Manajemen Nilai
- ✅ Input nilai mahasiswa
- ✅ Edit nilai
- ✅ Hapus nilai
- ✅ Grade otomatis berdasarkan nilai
- ✅ Validasi duplikasi nilai
- ✅ Pencarian dan sorting data nilai

## 🎯 Grade Calculation

| Grade | Range Nilai |
|-------|-------------|
| A     | 85 - 100    |
| A-    | 80 - 84     |
| B+    | 75 - 79     |
| B     | 70 - 74     |
| B-    | 65 - 69     |
| C+    | 60 - 64     |
| C     | 55 - 59     |
| D     | 40 - 54     |
| E     | < 40        |

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Deskripsi |
|-----------|-------|-----------|
| PHP       | 7.4+  | Backend scripting language |
| MySQL     | 5.7+  | Database management system |
| Bootstrap | 5.3.0 | Frontend CSS framework |
| HTML5     | -     | Markup language |
| CSS3      | -     | Styling |
| JavaScript| ES6+  | Client-side scripting |

## 📁 Struktur Folder

```
sistem-nilai-mahasiswa/
│
├── assets/
│   ├── css/
│   │   └── style.css              # Custom CSS
│   ├── js/
│   │   └── script.js              # Custom JavaScript
│   └── img/                       # Images
│
├── config/
│   └── database.php               # Database configuration
│
├── database/
│   └── sistem_nilai.sql           # Database SQL file
│
├── helpers/
│   ├── helper.php                 # Helper functions
│   └── validation.php             # Validation functions
│
├── includes/
│   ├── header.php                 # Header template
│   ├── navbar.php                 # Navigation bar
│   ├── sidebar.php                # Sidebar menu
│   └── footer.php                 # Footer template
│
├── modules/
│   ├── mahasiswa/                 # Mahasiswa module
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   │
│   ├── mata-kuliah/               # Mata Kuliah module
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   │
│   └── nilai/                     # Nilai module
│       ├── index.php
│       ├── create.php
│       ├── edit.php
│       └── delete.php
│
├── index.php                      # Dashboard (Homepage)
├── README.md                      # Documentation
└── .gitignore                     # Git ignore file
```

## 🚀 Cara Instalasi

### ⚡ Quick Start (5 Menit)
Ingin cepat? Ikuti **[QUICK-START.md](QUICK-START.md)**

### 📖 Detail Instalasi
Butuh panduan lengkap? Ikuti **[INSTALLATION.md](INSTALLATION.md)**

### Prasyarat
- XAMPP (Apache + MySQL + PHP)
- Web Browser (Chrome, Firefox, Edge, dll)
- Text Editor/IDE (VS Code, Sublime, dll)

### Langkah-langkah Instalasi

#### 1. Download & Extract
```bash
# Clone atau download repository
git clone https://github.com/username/sistem-nilai-mahasiswa.git

# Atau extract file ZIP ke folder htdocs
# Lokasi: C:\xampp\htdocs\sistem-nilai-mahasiswa
```

#### 2. Import Database
1. Buka XAMPP Control Panel
2. Start **Apache** dan **MySQL**
3. Buka browser dan akses: `http://localhost/phpmyadmin`
4. Klik tab **Import**
5. Pilih file: `database/sistem_nilai.sql`
6. Klik **Go**
7. Database `sistem_nilai` akan terbuat otomatis dengan sample data

#### 3. Konfigurasi Database (Opsional)
Jika menggunakan credential database yang berbeda, edit file `config/database.php`:

```php
define('DB_HOST', 'localhost');  // Host database
define('DB_USER', 'root');       // Username database
define('DB_PASS', '');           // Password database
define('DB_NAME', 'sistem_nilai'); // Nama database
```

#### 4. Jalankan Aplikasi
1. Buka browser
2. Akses: `http://localhost/sistem-nilai-mahasiswa`
3. Aplikasi siap digunakan!

## 📱 Cara Penggunaan

### Dashboard
- Akses halaman utama untuk melihat statistik keseluruhan
- Klik card untuk akses cepat ke setiap modul

### Manajemen Mahasiswa
1. Klik menu **Data Mahasiswa**
2. Klik **Tambah Mahasiswa** untuk menambah data baru
3. Gunakan fitur **Search** untuk mencari mahasiswa
4. Klik header tabel untuk **sorting** data
5. Klik **Edit** untuk mengubah data
6. Klik **Hapus** untuk menghapus data (akan dicek relasi dengan nilai)

### Manajemen Mata Kuliah
1. Klik menu **Data Mata Kuliah**
2. Klik **Tambah Mata Kuliah** untuk menambah data baru
3. SKS harus antara 1-6
4. Kode MK harus unique

### Manajemen Nilai
1. Klik menu **Data Nilai**
2. Klik **Tambah Nilai**
3. Pilih mahasiswa dan mata kuliah
4. Input nilai (0-100)
5. Grade akan dihitung otomatis
6. Satu mahasiswa tidak bisa memiliki nilai ganda untuk mata kuliah yang sama

## 🔒 Fitur Keamanan

- ✅ **Prepared Statement** - Mencegah SQL Injection
- ✅ **Input Sanitization** - Mencegah XSS Attack
- ✅ **Input Validation** - Validasi data di server-side
- ✅ **Foreign Key Constraint** - Menjaga integritas data
- ✅ **Data Relationship Check** - Validasi sebelum delete

## 🎨 Fitur UI/UX

- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Modern & clean interface
- ✅ Bootstrap 5 components
- ✅ Smooth animations
- ✅ Alert notifications
- ✅ Form validation feedback
- ✅ Grade preview (real-time)
- ✅ Search & sorting functionality

## 📊 Database Schema

### Table: mahasiswa
| Column     | Type         | Constraint |
|------------|--------------|------------|
| id         | INT          | PK, AI     |
| nim        | VARCHAR(20)  | UNIQUE     |
| nama       | VARCHAR(100) | NOT NULL   |
| jurusan    | VARCHAR(50)  | NOT NULL   |
| angkatan   | INT          | NOT NULL   |
| created_at | TIMESTAMP    | DEFAULT    |
| updated_at | TIMESTAMP    | ON UPDATE  |

### Table: mata_kuliah
| Column     | Type         | Constraint |
|------------|--------------|------------|
| id         | INT          | PK, AI     |
| kode_mk    | VARCHAR(10)  | UNIQUE     |
| nama_mk    | VARCHAR(100) | NOT NULL   |
| sks        | INT          | NOT NULL   |
| created_at | TIMESTAMP    | DEFAULT    |
| updated_at | TIMESTAMP    | ON UPDATE  |

### Table: nilai
| Column          | Type         | Constraint |
|-----------------|--------------|------------|
| id              | INT          | PK, AI     |
| mahasiswa_id    | INT          | FK         |
| mata_kuliah_id  | INT          | FK         |
| nilai           | DECIMAL(5,2) | 0-100      |
| grade           | VARCHAR(2)   | NOT NULL   |
| created_at      | TIMESTAMP    | DEFAULT    |
| updated_at      | TIMESTAMP    | ON UPDATE  |

**Relasi:**
- Mahasiswa 1:N Nilai
- Mata Kuliah 1:N Nilai

## 🐛 Troubleshooting

### Error: "Connection failed"
**Solusi:**
- Pastikan Apache dan MySQL di XAMPP sudah running
- Cek kredensial database di `config/database.php`
- Pastikan database `sistem_nilai` sudah diimport

### Error: "Table doesn't exist"
**Solusi:**
- Import ulang file `database/sistem_nilai.sql`
- Pastikan nama database sesuai dengan konfigurasi

### Warning: "Undefined index"
**Solusi:**
- Clear browser cache
- Pastikan menggunakan PHP 7.4 atau lebih baru

### Tampilan berantakan
**Solusi:**
- Clear browser cache (Ctrl + F5)
- Pastikan koneksi internet aktif (untuk load Bootstrap CDN)

## 📝 Best Practices yang Diterapkan

1. **Separation of Concerns** - Pemisahan logic, view, dan config
2. **DRY Principle** - Tidak ada duplikasi kode
3. **Prepared Statement** - Keamanan dari SQL Injection
4. **Input Validation** - Validasi di server dan client side
5. **Responsive Design** - Mobile-first approach
6. **Clean Code** - Naming convention yang konsisten
7. **Modular Structure** - Setiap modul independen
8. **Database Normalization** - Database dalam bentuk normal

## 👨‍💻 Developer

**Nama:** [Nama Anda]  
**NIM:** [NIM Anda]  
**Kelas:** [Kelas Anda]  
**Mata Kuliah:** Pengembangan Aplikasi Basis Data  
**Dosen:** [Nama Dosen]

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik (UAS).

## 📞 Kontak

Jika ada pertanyaan atau issue, silakan hubungi:
- Email: [email@example.com]
- GitHub: [github.com/username]

---

⭐ **Star** repository ini jika bermanfaat!

Made with ❤️ for Academic Purpose
