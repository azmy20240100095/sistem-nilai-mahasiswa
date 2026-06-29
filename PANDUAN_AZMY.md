# 🚀 PANDUAN PUSH KE GITHUB - AZMY HANIF ABDURRAHMAN

Panduan khusus untuk Azmy step-by-step dari NOL!

---

## ✅ CHECKLIST SEBELUM MULAI

- [ ] XAMPP sudah terinstall
- [ ] Folder proyek ada di: `C:\xampp\htdocs\Sistem Nilai Mahasiswa`
- [ ] Sudah punya akun GitHub (kalau belum, daftar dulu di github.com)
- [ ] Tahu email yang dipake di akun GitHub

---

## STEP 1: Install Git (Kalau Belum)

### Download Git:
1. Buka: **https://git-scm.com/download/win**
2. Download yang **64-bit Git for Windows Setup**
3. Install dengan setting default (Next terus aja)
4. **Selesai install, RESTART Command Prompt!**

### Test Git:
```bash
# Buka Command Prompt baru
git --version
```

Kalau muncul: `git version 2.xx.x` → **BERHASIL!** ✅

---

## STEP 2: Konfigurasi Git

Buka **Command Prompt**, copy-paste ini:

```bash
# Set nama
git config --global user.name "Azmy Hanif Abdurrahman"

# Set email (GANTI dengan email GitHub kamu!)
git config --global user.email "emailkamu@gmail.com"
```

**⚠️ PENTING:** Ganti `emailkamu@gmail.com` dengan email yang kamu pakai di GitHub!

### Cek Konfigurasi:
```bash
git config --list
```

Harus muncul nama dan email kamu ✅

---

## STEP 3: Bikin Repository di GitHub

### A. Login GitHub
1. Buka: **https://github.com**
2. Sign in dengan akun kamu
3. Kalau belum punya akun → Sign up dulu

### B. Buat Repository Baru
1. Klik tombol **"+"** di pojok kanan atas
2. Pilih **"New repository"**
3. **Isi form:**
   - Repository name: `sistem-nilai-mahasiswa`
   - Description: `Aplikasi Manajemen Nilai Mahasiswa - Tugas Akhir UAS`
   - Pilih **Public** ✅
   - **JANGAN centang** "Add a README file" ❌
   - **JANGAN pilih** .gitignore ❌
   - **JANGAN pilih** license ❌
4. Klik **"Create repository"**

### C. Copy URL Repository
Setelah repository dibuat, akan muncul URL seperti ini:
```
https://github.com/USERNAME-KAMU/sistem-nilai-mahasiswa.git
```

**⚠️ COPY & SIMPAN URL ini!** Nanti dipakai di Step 4.

**Contoh:** Kalau username GitHub kamu `azmyhanif`, URL-nya jadi:
```
https://github.com/azmyhanif/sistem-nilai-mahasiswa.git
```

---

## STEP 4: Push Proyek ke GitHub

### A. Buka Command Prompt di Folder Proyek

**Cara Gampang (Recommended):**
1. Buka **Windows Explorer**
2. Masuk ke folder: `C:\xampp\htdocs\Sistem Nilai Mahasiswa`
3. Klik di **address bar** (bagian atas yang nunjukin path)
4. Ketik: `cmd` → tekan Enter
5. Command Prompt langsung kebuka di folder ini! ✅

### B. Jalankan Command Git

Copy-paste command ini **SATU PER SATU**:

#### 1️⃣ Initialize Git
```bash
git init
```
✅ Muncul: `Initialized empty Git repository...`

#### 2️⃣ Add Semua File
```bash
git add .
```
✅ Tunggu sebentar... Done!

#### 3️⃣ Commit
```bash
git commit -m "Initial commit: Sistem Nilai Mahasiswa - Azmy Hanif Abdurrahman"
```
✅ Muncul: `37 files changed, 3500+ insertions...`

#### 4️⃣ Rename Branch
```bash
git branch -M main
```
✅ Done!

#### 5️⃣ Add Remote (GANTI URL!)
```bash
git remote add origin https://github.com/USERNAME-KAMU/sistem-nilai-mahasiswa.git
```

**⚠️ GANTI `USERNAME-KAMU` dengan username GitHub kamu!**

**Contoh:** Kalau username kamu `azmyhanif`:
```bash
git remote add origin https://github.com/azmyhanif/sistem-nilai-mahasiswa.git
```

#### 6️⃣ Cek Remote
```bash
git remote -v
```
✅ Harus muncul 2 baris (fetch & push) dengan URL yang benar!

#### 7️⃣ PUSH! 🚀
```bash
git push -u origin main
```

---

## STEP 5: Authentication

Saat push, GitHub akan minta login. Ada 2 cara:

### ⭐ CARA 1: GitHub Desktop (PALING GAMPANG!)

1. Download: **https://desktop.github.com/**
2. Install
3. Login dengan akun GitHub kamu
4. Selesai! ✅

Kalau pakai cara ini, **ULANGI dari Step 4** (git init, add, commit, push).
Push akan otomatis tanpa ribet! 🎉

---

### 🔐 CARA 2: Personal Access Token (Manual)

Kalau muncul window/error minta password:

#### A. Buat Token di GitHub:
1. GitHub → **Settings** (klik foto profil pojok kanan)
2. Scroll bawah → **Developer settings**
3. **Personal access tokens** → **Tokens (classic)**
4. **Generate new token** → **Generate new token (classic)**
5. Isi:
   - Note: `Sistem Nilai Mahasiswa - Azmy`
   - Expiration: `90 days` atau `No expiration`
   - Centang: **repo** ✅
6. **Generate token**
7. **COPY TOKEN!** (contoh: `ghp_xxxxxxxxxxxx`)

⚠️ **PENTING:** Token cuma muncul SEKALI! Kalau hilang harus bikin baru!

#### B. Pakai Token Saat Push:
Saat diminta:
- **Username:** username GitHub kamu
- **Password:** PASTE token (BUKAN password akun!)

Token akan kesimpan, jadi next time ga perlu login lagi ✅

---

## STEP 6: Verifikasi Berhasil

1. **Buka browser**
2. **Refresh halaman repository** di GitHub
3. **Cek file:**
   - ✅ README.md
   - ✅ LAPORAN_UAS.md
   - ✅ AUDIT_REPORT.md
   - ✅ folder: assets, config, database, helpers, includes, modules
   - ✅ Total: 40+ files

4. **README.md otomatis muncul** di homepage repository ✅

**Kalau semua file sudah muncul → BERHASIL!** 🎉

---

## STEP 7: Update Link GitHub

Sekarang kamu tahu username GitHub kamu, update dokumentasi:

### A. Edit README.md

File: `C:\xampp\htdocs\Sistem Nilai Mahasiswa\README.md`

Cari baris:
```markdown
**GitHub:** [https://github.com/username/sistem-nilai-mahasiswa]
```

Ganti jadi (sesuaikan username):
```markdown
**GitHub:** [https://github.com/azmyhanif/sistem-nilai-mahasiswa](https://github.com/azmyhanif/sistem-nilai-mahasiswa)
```

### B. Edit LAPORAN_UAS.md

File: `C:\xampp\htdocs\Sistem Nilai Mahasiswa\LAPORAN_UAS.md`

Cari:
```markdown
[https://github.com/username/sistem-nilai-mahasiswa]
```

Ganti dengan username GitHub kamu yang sebenarnya.

Juga isi bagian:
```markdown
**Nama Mahasiswa:** Azmy Hanif Abdurrahman
**NIM:** [ISI NIM KAMU]
**Kelas:** [ISI KELAS KAMU]
**Dosen Pengampu:** [ISI NAMA DOSEN]
```

### C. Push Update

Buka Command Prompt lagi di folder proyek:

```bash
# Add file yang diubah
git add README.md LAPORAN_UAS.md

# Commit
git commit -m "docs: update informasi pribadi dan link GitHub"

# Push
git push
```

✅ **DONE!** Dokumentasi sudah lengkap!

---

## 🎯 LANGKAH TERAKHIR

### 1. Screenshot untuk Laporan

Ambil screenshot:
1. **Dashboard desktop** (browser fullscreen)
2. **Dashboard mobile** (F12 → toggle device mode)
3. **Form tambah mahasiswa**
4. **Tabel data**

Simpan di: `C:\xampp\htdocs\Sistem Nilai Mahasiswa\assets\img\screenshots\`

Insert ke `LAPORAN_UAS.md` bagian "5.1.1 Screenshot Dashboard"

---

### 2. Import Database Baru

Database sudah diupdate dengan CHECK constraints.

**Di phpMyAdmin:**
1. Buka: `http://localhost/phpmyadmin`
2. Klik database `sistem_nilai`
3. Tab **Operations** → **Drop the database**
4. Buat database baru: `sistem_nilai`
5. **Import** → Pilih `database/sistem_nilai.sql` → Go

✅ Database updated!

---

### 3. Test Aplikasi

Buka: `http://localhost/sistem-nilai-mahasiswa`

Test:
- ✅ Dashboard muncul
- ✅ Tambah mahasiswa
- ✅ Edit & hapus
- ✅ Search & sort
- ✅ Tambah nilai (grade otomatis)

---

### 4. Submit ke Dosen

**Email Template:**

```
Subject: [Submission] Tugas Akhir UAS - Sistem Nilai Mahasiswa

Kepada Yth. Bapak/Ibu [Nama Dosen]

Dengan hormat,

Saya Azmy Hanif Abdurrahman, NIM [NIM], Kelas [Kelas],
telah menyelesaikan Tugas Akhir UAS Mata Kuliah 
Pengembangan Aplikasi Basis Data.

Judul Proyek: Sistem Nilai Mahasiswa
Link GitHub: https://github.com/[username-kamu]/sistem-nilai-mahasiswa

Dokumentasi lengkap tersedia di repository:
- README.md (panduan penggunaan)
- LAPORAN_UAS.md (laporan lengkap sesuai instruksi)
- INSTALLATION.md (panduan instalasi)
- AUDIT_REPORT.md (hasil audit)

Terima kasih atas bimbingan dan perhatiannya.

Hormat saya,
Azmy Hanif Abdurrahman
NIM: [NIM]
```

---

## 🆘 TROUBLESHOOTING

### ❌ Error: "failed to push"
```bash
git pull origin main --allow-unrelated-histories
git push
```

### ❌ Error: "Permission denied"
```bash
git remote set-url origin https://github.com/USERNAME-KAMU/sistem-nilai-mahasiswa.git
git push
```

### ❌ Error: "Authentication failed"
- Jangan pakai password akun!
- Pakai **Personal Access Token** atau install **GitHub Desktop**

### ❌ Lupa URL repository
```bash
git remote -v
```

---

## ✅ CHECKLIST AKHIR

- [ ] Git terinstall
- [ ] Git config sudah di-set
- [ ] Repository dibuat di GitHub (Public)
- [ ] File sudah di-push (cek di GitHub)
- [ ] README & LAPORAN_UAS sudah diupdate dengan info pribadi
- [ ] Screenshot sudah diambil & di-insert
- [ ] Database diimport ulang
- [ ] Aplikasi di-test dan jalan normal
- [ ] Siap submit ke dosen!

---

## 📊 Estimasi Nilai

Dengan semua perbaikan & dokumentasi lengkap:

**Target Nilai:** 93-95/100 (A) 🎉

---

## 💪 MOTIVASI

Azmy, proyekmu udah **sangat bagus**! Tinggal:
1. ✅ Push ke GitHub (ikuti panduan ini)
2. ✅ Screenshot
3. ✅ Update info pribadi
4. ✅ Submit

**Kamu pasti bisa!** 🚀

---

**Dibuat khusus untuk:** Azmy Hanif Abdurrahman  
**Tanggal:** 28 Juni 2026  
**Status:** ✅ Ready to Push & Submit

---

**Kalau ada yang bingung, tanya aja! Good luck, Azmy! 💪**
