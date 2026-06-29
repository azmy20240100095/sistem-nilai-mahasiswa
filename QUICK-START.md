# 🚀 Quick Start Guide

Panduan cepat untuk menjalankan Sistem Nilai Mahasiswa dalam 5 menit!

---

## ⚡ Prerequisites (Harus Ada)

- ✅ XAMPP installed
- ✅ Apache running (hijau)
- ✅ MySQL running (hijau)
- ✅ Browser (Chrome/Firefox/Edge)

---

## 📥 Step 1: Download & Extract

```bash
# Pastikan folder ada di:
C:\xampp\htdocs\Sistem Nilai Mahasiswa\

# Atau tanpa spasi (recommended):
C:\xampp\htdocs\sistem-nilai-mahasiswa\
```

---

## 🗄️ Step 2: Import Database (2 menit)

### Quick Method:

1. Buka: **http://localhost/phpmyadmin**
2. Klik tab **"Import"**
3. **Choose File** → Pilih `database/sistem_nilai.sql`
4. Klik **"Go"** (bawah)
5. ✅ Done! Database ready.

---

## 🧪 Step 3: Test System (1 menit)

Buka:
```
http://localhost/Sistem%20Nilai%20Mahasiswa/test-system.php
```

Pastikan semua **✅ Success**.

---

## 🌐 Step 4: Run Application

Buka:
```
http://localhost/Sistem%20Nilai%20Mahasiswa/
```

Atau (jika rename tanpa spasi):
```
http://localhost/sistem-nilai-mahasiswa/
```

---

## ✅ Step 5: Verify

Dashboard harus tampil dengan:
- ✅ Total Mahasiswa: **8**
- ✅ Total Mata Kuliah: **8**
- ✅ Total Data Nilai: **21**
- ✅ Rata-rata Nilai: **~75-80**

---

## 🎯 Quick Test Features

### Test 1: View Data
1. Click **"Data Mahasiswa"**
2. Should see 8 students

### Test 2: Add Data
1. Click **"Tambah Mahasiswa"**
2. Fill form
3. Click **"Simpan"**
4. Success!

### Test 3: Search
1. Di halaman Data Mahasiswa
2. Ketik nama di search box
3. Click **"Cari"**

### Test 4: Grade Calculation
1. Click **"Data Nilai"** → **"Tambah Nilai"**
2. Pilih mahasiswa & mata kuliah
3. Input nilai (contoh: 88)
4. Grade otomatis: **A** ✅

---

## 🐛 Troubleshooting Cepat

### ❌ Database Error?
```
1. Buka XAMPP Control Panel
2. Stop MySQL → Start MySQL
3. Import ulang database
```

### ❌ CSS Tidak Muncul?
```
1. Tekan Ctrl + Shift + R (hard refresh)
2. Clear browser cache
3. Cek koneksi internet (untuk Bootstrap CDN)
```

### ❌ 404 Not Found?
```
Pastikan akses URL yang benar:
http://localhost/Sistem%20Nilai%20Mahasiswa/
(perhatikan spasi di-encode jadi %20)
```

---

## 📚 Next Steps

Setelah aplikasi running:

1. **Read Full Documentation**: [README.md](README.md)
2. **Learn Features**: [DOKUMENTASI.md](DOKUMENTASI.md)
3. **Check Accessibility**: [ACCESSIBILITY.md](ACCESSIBILITY.md)
4. **FAQ**: [FAQ.md](FAQ.md)

---

## 🎓 Demo Credentials

**Role**: Admin (no login required)  
**Direct Access**: Dashboard

**Sample Data**:
- Mahasiswa: 8 students
- Mata Kuliah: 8 courses
- Nilai: 21 records

---

## 🔥 Pro Tips

1. **Bookmark Dashboard**
   ```
   http://localhost/Sistem%20Nilai%20Mahasiswa/
   ```

2. **Use Keyboard Shortcuts**
   - Tab: Navigate
   - Enter: Submit/Open
   - Esc: Cancel

3. **Test Responsive**
   - F12 → Toggle Device Toolbar
   - Test mobile view

4. **Clear Cache Before Demo**
   ```
   Ctrl + Shift + Del
   Clear cache
   ```

---

## 📱 Mobile Testing

1. Find your IP:
   ```bash
   # Windows
   ipconfig
   
   # Look for IPv4 Address: 192.168.x.x
   ```

2. Access from phone:
   ```
   http://192.168.x.x/Sistem%20Nilai%20Mahasiswa/
   ```

3. Allow firewall if needed

---

## ⏱️ Total Time: ~5 Minutes

- Download & Extract: 1 min
- Import Database: 2 min
- Test & Verify: 2 min

---

## 🎉 That's It!

You're ready to:
- ✅ Add mahasiswa
- ✅ Add mata kuliah
- ✅ Input nilai
- ✅ Search & sort data
- ✅ View statistics

---

**Need more help?**  
Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md) or [FAQ.md](FAQ.md)

**Ready for presentation?**  
Check [PRESENTATION-GUIDE.md](#) (coming soon)

---

Made with ❤️ for UAS Project
