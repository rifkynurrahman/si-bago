# 📸 DOKUMENTASI FITUR FOTO GALLERY - SI-BAGO

## 🎯 Ringkasan Update

Fitur foto gallery telah berhasil ditambahkan ke website SI-BAGO! Sekarang admin dapat:
- ✅ Upload multiple foto di setiap menu
- ✅ Drag & drop untuk upload
- ✅ Preview foto sebelum simpan
- ✅ Delete foto dengan mudah
- ✅ Menampilkan galeri foto di halaman front-end dengan lightbox

---

## 📦 File-File yang Ditambahkan/Dimodifikasi

### ✨ File Baru:
1. **upload.php** - Handler untuk upload foto
2. **database/update_foto_gallery.sql** - Query update database
3. **database/db_sibago_with_foto.sql** - Database lengkap dengan kolom foto
4. **menu/view_menu_backup.php** - Backup file view_menu.php yang lama

### 🔧 File yang Dimodifikasi:
1. **admin/edit.php** - Tambah fitur upload foto
2. **menu/view_menu.php** - Tambah tampilan galeri foto
3. **assets/img/uploads/** - Folder baru untuk menyimpan foto (chmod 777)

---

## 🚀 CARA INSTALASI

### Langkah 1: Update Database

Buka phpMyAdmin dan jalankan query berikut:

```sql
ALTER TABLE `menu` ADD COLUMN `foto` TEXT NULL AFTER `konten`;
```

**ATAU** import ulang database:
- Drop database lama: `DROP DATABASE db_sibago;`
- Import file: `database/db_sibago_with_foto.sql`

### Langkah 2: Set Permission Folder

Pastikan folder uploads memiliki permission yang benar:

```bash
chmod 777 assets/img/uploads
```

Atau via cPanel File Manager:
- Klik kanan folder `uploads`
- Change Permissions → **777** (rwxrwxrwx)

### Langkah 3: Test Upload

1. Login ke admin panel
2. Klik Edit pada menu manapun
3. Scroll ke bagian **Galeri Foto**
4. Upload foto dengan:
   - Klik "Pilih Foto"
   - Atau drag & drop foto
5. Klik **Simpan Perubahan**

### Langkah 4: Verifikasi Front-End

1. Buka halaman menu yang sudah diupload foto
2. Scroll ke bawah, cek galeri foto
3. Klik foto untuk lihat lightbox

---

## 📁 Struktur Folder Lengkap

```
si-bago/
├── admin/
│   ├── dashboard.php
│   ├── edit.php           ← DIUPDATE (fitur upload foto)
│   ├── login.php
│   ├── logout.php
│   └── penyusun.php
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── img/
│   │   └── uploads/       ← FOLDER BARU (chmod 777)
│   └── js/
├── config/
│   └── database.php
├── database/
│   ├── db_sibago_with_foto.sql       ← DATABASE BARU
│   ├── update_foto_gallery.sql       ← QUERY UPDATE
│   ├── si-bago.sql                   ← DATABASE LAMA
│   └── sample_penyusun.sql
├── menu/
│   ├── dokumentasi.php
│   ├── etnomatematika.php
│   ├── gladhen.php
│   ├── identitas.php
│   ├── logo.php
│   ├── penyusun.php
│   ├── template.php
│   ├── view_menu.php              ← DIUPDATE (tampilan gallery)
│   └── view_menu_backup.php       ← BACKUP FILE LAMA
├── upload.php                     ← FILE BARU (handler upload)
├── index.php
├── header.php
├── footer.php
└── DOKUMENTASI_FOTO_GALLERY.md    ← FILE INI
```

---

## 🎨 Fitur-Fitur yang Tersedia

### Di Admin Panel:

#### 1. Upload Foto
- **Multiple Upload**: Upload banyak foto sekaligus
- **Drag & Drop**: Seret foto langsung ke area upload
- **Preview Real-time**: Lihat preview foto sebelum save
- **Auto Resize**: Foto otomatis di-resize jika terlalu besar (max 1920x1080)
- **Validasi**: 
  - Tipe file: JPG, PNG, GIF, WEBP
  - Ukuran max: 5MB per file

#### 2. Manajemen Foto
- **Delete**: Hover foto → klik tombol X merah
- **Reorder**: Urutan foto sesuai urutan upload
- **Grid Layout**: Tampilan grid responsive

### Di Front-End:

#### 1. Galeri Foto
- **Grid Responsive**: Otomatis menyesuaikan ukuran layar
- **Hover Effect**: Zoom in saat hover
- **Lazy Loading**: Foto dimuat saat dibutuhkan

#### 2. Lightbox
- **Click to Zoom**: Klik foto untuk view full size
- **Navigation**: 
  - Tombol prev/next
  - Arrow keyboard (← →)
  - ESC untuk close
- **Smooth Animation**: Transisi halus

---

## 🔧 Konfigurasi

### Upload Settings (upload.php)

```php
// Maksimal ukuran file
$max_size = 5 * 1024 * 1024; // 5MB

// Tipe file yang diizinkan
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

// Dimensi maksimal (auto resize)
$max_width = 1920;
$max_height = 1080;
```

### Database Structure

```sql
-- Kolom foto menyimpan JSON array filenames
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `konten` text DEFAULT NULL,
  `foto` text DEFAULT NULL,  -- JSON: ["file1.jpg", "file2.jpg"]
  PRIMARY KEY (`id`)
);
```

---

## 🐛 Troubleshooting

### Problem 1: "Foto gagal diupload"

**Penyebab:**
- Permission folder salah
- Folder uploads tidak ada

**Solusi:**
```bash
# Buat folder jika belum ada
mkdir -p assets/img/uploads

# Set permission
chmod 777 assets/img/uploads

# Cek permission
ls -la assets/img/
```

### Problem 2: "Warning: move_uploaded_file() failed"

**Penyebab:**
- PHP tidak punya akses write ke folder
- Safe mode aktif

**Solusi:**
1. Cek php.ini:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   file_uploads = On
   ```

2. Atau tambahkan di .htaccess:
   ```apache
   php_value upload_max_filesize 10M
   php_value post_max_size 10M
   ```

### Problem 3: "Foto tidak tampil di front-end"

**Penyebab:**
- Path foto salah
- Data foto tidak tersimpan di database

**Solusi:**
1. Cek database:
   ```sql
   SELECT id, judul, foto FROM menu WHERE id = 1;
   ```

2. Pastikan format JSON benar:
   ```json
   ["img_123_456.jpg", "img_789_012.jpg"]
   ```

3. Cek file fisik ada:
   ```bash
   ls -la assets/img/uploads/
   ```

### Problem 4: "Upload file besar gagal"

**Penyebab:**
- Limit PHP terlalu kecil

**Solusi:**
Edit `.htaccess`:
```apache
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value max_input_time 300
php_value memory_limit 128M
```

### Problem 5: "Session error saat upload"

**Penyebab:**
- User belum login
- Session expired

**Solusi:**
- Login ulang ke admin panel
- Cek `upload.php` line 5-8 untuk validasi session

---

## 📊 Database Schema

### Sebelum Update:
```sql
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `slug` varchar(50),
  `judul` varchar(100),
  `konten` text
);
```

### Setelah Update:
```sql
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `slug` varchar(50),
  `judul` varchar(100),
  `konten` text,
  `foto` text  -- ← KOLOM BARU
);
```

### Format Data Foto:

**Single photo (backward compatible):**
```
"img_abc123_456.jpg"
```

**Multiple photos (JSON array):**
```json
["img_abc123_456.jpg", "img_def789_012.png", "img_ghi345_678.jpg"]
```

---

## 🎯 Penggunaan untuk Admin

### Upload Foto:

1. **Login** ke admin panel (`/admin/login.php`)
   - Username: `admin`
   - Password: `admin123`

2. **Pilih Menu** yang ingin ditambah foto
   - Klik tombol **Edit** di dashboard

3. **Upload Foto**
   
   **Cara 1 - Klik Upload:**
   - Scroll ke bagian "Galeri Foto"
   - Klik tombol "Pilih Foto"
   - Pilih foto (bisa multiple select)
   - Klik Open
   
   **Cara 2 - Drag & Drop:**
   - Drag foto dari folder
   - Drop ke area upload
   
4. **Preview & Konfirmasi**
   - Lihat preview foto yang diupload
   - Foto existing juga ditampilkan
   
5. **Simpan**
   - Klik "Simpan Perubahan"
   - Foto akan tersimpan ke database

### Delete Foto:

1. Buka halaman Edit menu
2. Hover foto yang ingin dihapus
3. Klik tombol **X** merah di pojok kanan atas
4. Konfirmasi hapus
5. Klik "Simpan Perubahan"

---

## 🎨 Customization

### Mengubah Jumlah Kolom Grid:

Edit `menu/view_menu.php`, line ~50:

```css
.photo-gallery {
    /* Default: 250px min width */
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    
    /* Untuk 2 kolom fixed: */
    /* grid-template-columns: repeat(2, 1fr); */
    
    /* Untuk 3 kolom fixed: */
    /* grid-template-columns: repeat(3, 1fr); */
}
```

### Mengubah Aspect Ratio Foto:

Edit `menu/view_menu.php`, line ~70:

```css
.gallery-item {
    /* Default: 4:3 */
    aspect-ratio: 4/3;
    
    /* Untuk 16:9: */
    /* aspect-ratio: 16/9; */
    
    /* Untuk square: */
    /* aspect-ratio: 1; */
}
```

### Mengubah Max Upload Size:

Edit `upload.php`, line 16:

```php
// Default: 5MB
$max_size = 5 * 1024 * 1024;

// Untuk 10MB:
// $max_size = 10 * 1024 * 1024;

// Untuk 20MB:
// $max_size = 20 * 1024 * 1024;
```

---

## 🔒 Security Features

✅ **Session Validation**: Hanya admin yang login bisa upload
✅ **File Type Validation**: Hanya image files yang diizinkan
✅ **File Size Validation**: Max 5MB per file
✅ **Random Filename**: Generate nama file unik untuk prevent overwrite
✅ **Path Traversal Protection**: Menggunakan `basename()` untuk sanitize filename
✅ **SQL Injection Protection**: Menggunakan prepared statements
✅ **XSS Protection**: Menggunakan `htmlspecialchars()` di output

---

## 📱 Responsive Design

### Desktop (> 992px):
- Grid: 4-5 kolom
- Foto size: 250px min width

### Tablet (768px - 992px):
- Grid: 3 kolom
- Foto size: 200px min width

### Mobile (< 768px):
- Grid: 2 kolom
- Foto size: 150px min width
- Touch-friendly buttons

---

## 🔄 Migration Guide

### Dari Sistem Lama ke Sistem Baru:

**Jika sudah punya foto di sistem lama:**

1. Pindahkan foto ke folder baru:
   ```bash
   cp -r old_photos/* assets/img/uploads/
   ```

2. Update database manual:
   ```sql
   UPDATE menu 
   SET foto = '["old_photo1.jpg", "old_photo2.jpg"]'
   WHERE id = 1;
   ```

**Atau gunakan script PHP:**

```php
<?php
include 'config/database.php';

// Array foto lama per menu
$old_photos = [
    1 => ['foto1.jpg', 'foto2.jpg'],
    2 => ['logo1.png', 'logo2.png'],
    // ...
];

foreach ($old_photos as $menu_id => $photos) {
    $foto_json = json_encode($photos);
    $stmt = $conn->prepare("UPDATE menu SET foto = ? WHERE id = ?");
    $stmt->bind_param("si", $foto_json, $menu_id);
    $stmt->execute();
}

echo "Migration selesai!";
?>
```

---

## 📈 Performance Tips

### Optimasi Loading:

1. **Lazy Loading**: Sudah diimplementasikan
   ```html
   <img loading="lazy" src="...">
   ```

2. **Compress Images**: Gunakan tools seperti TinyPNG sebelum upload

3. **CDN**: Pertimbangkan menggunakan CDN untuk static files

4. **Caching**: Tambahkan browser caching di `.htaccess`:
   ```apache
   <IfModule mod_expires.c>
     ExpiresActive On
     ExpiresByType image/jpg "access plus 1 year"
     ExpiresByType image/jpeg "access plus 1 year"
     ExpiresByType image/gif "access plus 1 year"
     ExpiresByType image/png "access plus 1 year"
     ExpiresByType image/webp "access plus 1 year"
   </IfModule>
   ```

---

## 📞 Support & Contact

Jika ada masalah atau pertanyaan:

1. **Cek Error Log PHP**: `/var/log/apache2/error.log`
2. **Cek Browser Console**: F12 → Console tab
3. **Cek Database**: Pastikan data tersimpan dengan benar
4. **Cek Permission**: Folder dan file harus readable/writable

---

## 🎉 Selesai!

Fitur foto gallery sudah siap digunakan! 

**Next Steps:**
- [ ] Upload foto di setiap menu
- [ ] Test di berbagai browser
- [ ] Test di mobile devices
- [ ] Backup database secara berkala

---

**Versi:** 1.0  
**Tanggal:** 28 Januari 2026  
**Developer:** SI-BAGO Development Team  
**License:** Internal Use Only

---

## 📝 Changelog

### Version 1.0 (28 Januari 2026)
- ✅ Initial release
- ✅ Upload multiple photos
- ✅ Drag & drop support
- ✅ Auto resize images
- ✅ Lightbox gallery
- ✅ Responsive design
- ✅ Security validation

---

**Happy Coding! 🚀**
