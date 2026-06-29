# 📦 Panduan Upload ke GitHub

Panduan step-by-step untuk upload proyek Sistem Nilai Mahasiswa ke GitHub.

---

## ⚡ Quick Start

Jika sudah familiar dengan Git, jalankan command ini:

```bash
git init
git add .
git commit -m "Initial commit: Sistem Nilai Mahasiswa v1.0"
git branch -M main
git remote add origin https://github.com/USERNAME/sistem-nilai-mahasiswa.git
git push -u origin main
```

*(Ganti `USERNAME` dengan username GitHub Anda)*

---

## 📖 Panduan Lengkap

### Langkah 1: Install Git

**Windows:**
1. Download Git dari: https://git-scm.com/download/win
2. Jalankan installer
3. Pilih "Use Git from the Windows Command Prompt"
4. Install dengan setting default

**Cek instalasi:**
```bash
git --version
```

---

### Langkah 2: Konfigurasi Git (Pertama Kali)

```bash
# Set nama
git config --global user.name "Nama Lengkap Anda"

# Set email (pakai email GitHub)
git config --global user.email "email@example.com"

# Cek konfigurasi
git config --list
```

---

### Langkah 3: Buat Repository di GitHub

1. **Login ke GitHub:** https://github.com
2. **Klik tombol "New repository"** (tombol hijau +)
3. **Isi form:**
   - Repository name: `sistem-nilai-mahasiswa`
   - Description: `Aplikasi manajemen nilai mahasiswa dengan PHP Native & MySQL - Tugas Akhir UAS`
   - Public (agar dosen bisa akses)
   - **JANGAN** centang "Initialize with README" (karena sudah ada)
   - **JANGAN** pilih .gitignore atau license
4. **Klik "Create repository"**
5. **Copy URL repository** (contoh: `https://github.com/username/sistem-nilai-mahasiswa.git`)

---

### Langkah 4: Inisialisasi Git di Folder Proyek

Buka **Command Prompt** atau **Git Bash**, lalu:

```bash
# Masuk ke folder proyek
cd C:\xampp\htdocs\Sistem Nilai Mahasiswa

# atau jika pakai PowerShell
cd "C:\xampp\htdocs\Sistem Nilai Mahasiswa"

# Inisialisasi Git
git init

# Konfirmasi
# Akan muncul: "Initialized empty Git repository in ..."
```

---

### Langkah 5: Add File ke Staging

```bash
# Tambahkan semua file
git add .

# Cek status
git status

# Harusnya muncul banyak file berwarna hijau (new file)
```

---

### Langkah 6: Commit

```bash
# Commit dengan message
git commit -m "Initial commit: Sistem Nilai Mahasiswa v1.0"

# Harusnya muncul output seperti:
# [main (root-commit) abc1234] Initial commit: Sistem Nilai Mahasiswa v1.0
# 37 files changed, 3500 insertions(+)
```

---

### Langkah 7: Rename Branch ke Main

```bash
# Rename branch dari master ke main (standar baru GitHub)
git branch -M main
```

---

### Langkah 8: Connect ke GitHub

```bash
# Tambahkan remote origin
git remote add origin https://github.com/USERNAME/sistem-nilai-mahasiswa.git

# Ganti USERNAME dengan username GitHub Anda!

# Cek remote
git remote -v

# Harusnya muncul:
# origin  https://github.com/USERNAME/sistem-nilai-mahasiswa.git (fetch)
# origin  https://github.com/USERNAME/sistem-nilai-mahasiswa.git (push)
```

---

### Langkah 9: Push ke GitHub

```bash
# Push ke GitHub
git push -u origin main

# Jika diminta login:
# - Username: username GitHub Anda
# - Password: BUKAN password akun, tapi Personal Access Token (PAT)
```

**Jika muncul error authentication**, buat Personal Access Token:

1. GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token (classic)
3. Note: `Sistem Nilai Mahasiswa`
4. Expiration: `90 days` atau `No expiration`
5. Centang: `repo` (full control)
6. Generate token
7. **COPY token** (hanya muncul sekali!)
8. Pakai token sebagai password saat `git push`

---

### Langkah 10: Verifikasi

1. **Buka browser:** https://github.com/USERNAME/sistem-nilai-mahasiswa
2. **Cek file:**
   - ✅ README.md
   - ✅ LAPORAN_UAS.md
   - ✅ folder assets, config, database, helpers, includes, modules
   - ✅ Total 37 files
3. **README akan otomatis ditampilkan di homepage repository**

---

## 🔄 Update Kode (Setelah Push Pertama)

Setelah push pertama berhasil, untuk update kode:

```bash
# Cek perubahan
git status

# Add file yang berubah
git add .

# Commit dengan message
git commit -m "Fix: SQL injection di ORDER BY + tambah CSRF protection"

# Push
git push
```

---

## 📝 Best Practices Commit Message

**Format:**
```
<type>: <description>

[optional body]
```

**Type:**
- `feat`: Fitur baru
- `fix`: Bug fix
- `docs`: Update dokumentasi
- `style`: Format kode (tidak mengubah logic)
- `refactor`: Refactor kode
- `test`: Tambah/update test
- `chore`: Maintenance (update dependencies, dll)

**Contoh:**
```bash
git commit -m "feat: tambah sistem login"
git commit -m "fix: SQL injection di ORDER BY clause"
git commit -m "docs: update README dengan link GitHub"
git commit -m "refactor: pisahkan validation functions"
```

---

## 🎯 Update README & LAPORAN

Setelah push ke GitHub, **update link** di file:

### README.md
```markdown
## 🔗 Link Repository

**GitHub:** [https://github.com/USERNAME/sistem-nilai-mahasiswa](https://github.com/USERNAME/sistem-nilai-mahasiswa)
```

### LAPORAN_UAS.md
```markdown
## 7. LINK APLIKASI

### 7.1 Repository GitHub

**Link Repository:** [https://github.com/USERNAME/sistem-nilai-mahasiswa](https://github.com/USERNAME/sistem-nilai-mahasiswa)
```

**Ganti `USERNAME` dengan username GitHub Anda!**

Kemudian commit dan push lagi:
```bash
git add README.md LAPORAN_UAS.md
git commit -m "docs: update link GitHub dengan username actual"
git push
```

---

## ✅ Checklist Sebelum Submit ke Dosen

- [ ] Semua file sudah di-push ke GitHub
- [ ] Link GitHub sudah di-update di README.md
- [ ] Link GitHub sudah di-update di LAPORAN_UAS.md
- [ ] Screenshot sudah di-insert ke LAPORAN_UAS.md
- [ ] Repository setting **Public** (bukan Private)
- [ ] README.md informatif dan lengkap
- [ ] File database SQL sudah ada di folder `database/`
- [ ] Dokumentasi lengkap (README, LAPORAN_UAS, INSTALLATION)

---

## 🚨 Troubleshooting

### Error: "failed to push some refs"
```bash
# Pull dulu, baru push
git pull origin main --allow-unrelated-histories
git push
```

### Error: "Permission denied (publickey)"
```bash
# Pakai HTTPS, bukan SSH
git remote set-url origin https://github.com/USERNAME/sistem-nilai-mahasiswa.git
```

### Error: "Authentication failed"
```bash
# Pakai Personal Access Token, bukan password akun
# Generate di: GitHub → Settings → Developer settings → Personal access tokens
```

### Lupa URL Repository
```bash
# Cek remote URL
git remote -v
```

### Reset ke Commit Sebelumnya
```bash
# Lihat history
git log --oneline

# Reset ke commit tertentu (HATI-HATI!)
git reset --hard <commit-hash>

# Force push
git push -f origin main
```

---

## 📧 Share ke Dosen

Setelah push berhasil, share link repository ke dosen:

**Template Email:**

```
Subject: [Submission] Tugas Akhir UAS - Sistem Nilai Mahasiswa

Kepada Yth.
Bapak/Ibu [Nama Dosen]

Dengan hormat,

Saya [Nama], NIM [NIM], Kelas [Kelas], telah menyelesaikan 
Tugas Akhir UAS Mata Kuliah Pengembangan Aplikasi Basis Data.

Judul Proyek: Sistem Nilai Mahasiswa
Link GitHub: https://github.com/USERNAME/sistem-nilai-mahasiswa

Dokumentasi lengkap ada di:
- README.md
- LAPORAN_UAS.md
- INSTALLATION.md

Terima kasih atas perhatiannya.

Hormat saya,
[Nama]
[NIM]
```

---

**Good luck!** 🚀

Jika ada pertanyaan, buka issue di repository atau tanya di forum diskusi.
