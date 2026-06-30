# 🎉 SI-BAGO - Update Fitur Foto Gallery

## 📸 Apa yang Baru?

Project SI-BAGO Anda telah diupdate dengan **Fitur Foto Gallery** yang lengkap!

### ✨ Fitur Baru:
- ✅ Upload multiple foto di admin panel
- ✅ Drag & drop untuk upload
- ✅ Auto resize foto besar
- ✅ Preview foto real-time
- ✅ Delete foto dengan mudah
- ✅ Galeri foto responsive di front-end
- ✅ Lightbox untuk zoom foto

---

## 🚀 QUICK START - 3 Langkah Mudah!

### Langkah 1️⃣: Update Database

Buka phpMyAdmin dan jalankan query ini:

```sql
ALTER TABLE `menu` ADD COLUMN `foto` TEXT NULL AFTER `konten`;
```

**ATAU** import database baru: `database/db_sibago_with_foto.sql`

### Langkah 2️⃣: Set Permission Folder

Via Terminal:
```bash
chmod 777 assets/img/uploads
```

Via cPanel File Manager:
- Klik kanan folder `uploads`
- Change Permissions → **777**

### Langkah 3️⃣: Test Upload!

1. Login admin: `/admin/login.php`
2. Klik **Edit** pada menu manapun
3. Upload foto di bagian "Galeri Foto"
4. Klik **Simpan Perubahan**
5. Buka halaman menu untuk lihat hasil!

**✅ SELESAI! Fitur foto gallery sudah siap digunakan!**

---

## 📁 File-File Baru

```
si-bago/
├── upload.php                         ← Handler upload foto
├── admin/edit.php                     ← UPDATE (fitur upload)
├── menu/view_menu.php                 ← UPDATE (tampil gallery)
├── assets/img/uploads/                ← Folder foto (CHMOD 777!)
├── database/
│   ├── db_sibago_with_foto.sql       ← Database baru
│   └── update_foto_gallery.sql       ← Query update
├── .htaccess                          ← Konfigurasi upload
├── DOKUMENTASI_FOTO_GALLERY.md       ← Dokumentasi lengkap
└── README_FOTO_GALLERY.md            ← File ini
```

---

## 📖 Dokumentasi Lengkap

Baca dokumentasi detail di: **DOKUMENTASI_FOTO_GALLERY.md**

Isi dokumentasi:
- 📋 Instalasi lengkap
- 🎨 Fitur-fitur yang tersedia
- 🐛 Troubleshooting
- 🔧 Konfigurasi & customization
- 🔒 Security features
- 📱 Responsive design
- Dan masih banyak lagi!

---

## 🎯 Cara Menggunakan

### Upload Foto (Admin):

1. Login ke `/admin/login.php`
2. Klik **Edit** pada menu
3. Scroll ke "Galeri Foto"
4. **Cara 1**: Klik "Pilih Foto" → pilih file
5. **Cara 2**: Drag & drop foto ke area upload
6. Tunggu preview muncul
7. Klik **Simpan Perubahan**

### Lihat Galeri (User):

1. Buka halaman menu (misal: `/menu/view_menu.php?slug=identitas`)
2. Scroll ke bawah
3. Lihat galeri foto
4. Klik foto untuk zoom (lightbox)
5. Gunakan arrow atau keyboard untuk navigasi

---

## 🔍 Verifikasi Instalasi

### Cek 1: Database
```sql
DESCRIBE menu;
-- Pastikan ada kolom 'foto'
```

### Cek 2: Folder Permission
```bash
ls -la assets/img/
# Pastikan uploads/ ada dan permission 777
```

### Cek 3: Upload File Exists
```bash
ls -l upload.php
# Pastikan file ada dan readable
```

### Cek 4: Test Upload
1. Login admin
2. Edit menu
3. Upload test foto
4. Lihat di front-end

---

## ⚠️ Troubleshooting Cepat

### ❌ "Foto gagal diupload"
**Fix:** `chmod 777 assets/img/uploads`

### ❌ "Warning: move_uploaded_file()"
**Fix:** Cek permission folder & php.ini settings

### ❌ "Foto tidak tampil"
**Fix:** Cek path foto di database: `SELECT foto FROM menu WHERE id=1;`

### ❌ "Upload file besar gagal"
**Fix:** Edit `.htaccess`, tambah:
```apache
php_value upload_max_filesize 10M
php_value post_max_size 10M
```

---

## 📊 Spesifikasi Teknis

### Upload Limits:
- **Max file size**: 5MB (configurable)
- **Allowed types**: JPG, PNG, GIF, WEBP
- **Auto resize**: 1920x1080px max
- **Multiple upload**: Yes
- **Drag & drop**: Yes

### Database:
- **Table**: `menu`
- **Column**: `foto` (TEXT)
- **Format**: JSON array
- **Example**: `["img_123.jpg", "img_456.png"]`

### Security:
- ✅ Session validation
- ✅ File type validation
- ✅ Size validation
- ✅ Random filename
- ✅ Path traversal protection
- ✅ SQL injection protection
- ✅ XSS protection

---

## 🎨 Customization

### Ubah Max Upload Size:
Edit `upload.php` line 16:
```php
$max_size = 10 * 1024 * 1024; // 10MB
```

### Ubah Grid Columns:
Edit `menu/view_menu.php` line ~50:
```css
.photo-gallery {
    grid-template-columns: repeat(3, 1fr); /* 3 kolom */
}
```

### Ubah Aspect Ratio:
Edit `menu/view_menu.php` line ~70:
```css
.gallery-item {
    aspect-ratio: 16/9; /* widescreen */
}
```

---

## 📞 Butuh Bantuan?

1. **Baca dokumentasi lengkap**: `DOKUMENTASI_FOTO_GALLERY.md`
2. **Cek error log**: Browser console (F12)
3. **Test di browser lain**: Chrome, Firefox, Safari
4. **Cek database**: Pastikan data tersimpan

---

## 🎯 Checklist Instalasi

- [ ] Database sudah diupdate (kolom `foto` ada)
- [ ] Folder `uploads/` sudah dibuat (chmod 777)
- [ ] File `upload.php` ada di root
- [ ] File `admin/edit.php` sudah diupdate
- [ ] File `menu/view_menu.php` sudah diupdate
- [ ] File `.htaccess` sudah ada
- [ ] Test upload foto berhasil
- [ ] Foto tampil di front-end
- [ ] Lightbox berfungsi
- [ ] Mobile responsive OK

---

## 🚀 Next Steps

Setelah instalasi selesai:

1. ✅ Upload foto di setiap menu
2. ✅ Test di berbagai devices (desktop, tablet, mobile)
3. ✅ Test di berbagai browsers (Chrome, Firefox, Safari, Edge)
4. ✅ Backup database secara berkala
5. ✅ Compress foto sebelum upload untuk performa optimal

---

## 📈 Performance Tips

1. **Compress images**: Gunakan TinyPNG sebelum upload
2. **Lazy loading**: Sudah diimplementasikan
3. **Browser caching**: Sudah dikonfigurasi di `.htaccess`
4. **CDN**: Pertimbangkan untuk production

---

## 🔄 Update Log

### Version 1.0 (28 Januari 2026)
- ✅ Initial release fitur foto gallery
- ✅ Upload multiple photos
- ✅ Drag & drop support
- ✅ Auto resize
- ✅ Lightbox gallery
- ✅ Responsive design
- ✅ Security validation

---

## 🎉 Selamat!

Fitur foto gallery SI-BAGO sudah siap digunakan!

**Jangan lupa:**
- 📖 Baca dokumentasi lengkap
- 🔒 Backup database
- 🧪 Test semua fitur
- 📱 Test di mobile

**Happy coding! 🚀**

---

**Developed with ❤️ for SI-BAGO**  
**Version:** 1.0  
**Date:** 28 Januari 2026
