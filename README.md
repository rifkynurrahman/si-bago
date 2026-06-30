# SI-BAGO
link = https://si-bago.gamer.gd/
**Smart Innovative Boardgame Geometri berbasis Etnomatematika Jawa Tengah**

![SI-BAGO Logo](assets/img/logo.png)

## 📚 Tentang SI-BAGO

SI-BAGO adalah media pembelajaran inovatif yang menggabungkan konsep geometri dengan kearifan lokal Jawa Tengah. Melalui permainan kartu edukatif, siswa dapat belajar matematika dengan cara yang menyenangkan dan bermakna.

## ✨ Fitur Utama

### 1. **Halaman Utama**
- Hero section yang menarik
- 6 menu utama (Identitas, Logo, Etnomatematika, Gladhen, Penyusun, Dokumentasi)
- Design responsif dan modern

### 2. **Menu Identitas SI-BAGO**
- Informasi lengkap tentang SI-BAGO
- Tujuan dan visi misi
- Keunggulan media pembelajaran

### 3. **Filosofi Logo**
- Makna di balik setiap elemen logo
- Representasi nilai budaya Jawa Tengah

### 4. **Etnomatematika Jawa Tengah**
- 20+ contoh objek budaya dengan bentuk geometri
- Integrasi matematika dan budaya lokal
- Visualisasi yang menarik

### 5. **Kartu Gladhen**
- 4 jenis kartu permainan
- Aturan permainan lengkap
- Manfaat edukatif

### 6. **Seputar Penyusun**
- Profil tim penyusun
- Foto dan biodata lengkap
- Tabel interaktif

### 7. **Dokumentasi**
- Galeri foto kegiatan
- Lightbox image viewer
- Upload foto (admin)

### 8. **Admin Panel**
- Dashboard informatif
- Kelola konten menu
- Kelola data penyusun
- Upload gambar
- Statistik website

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 8+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5.3.2
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Poppins)

## 📦 Struktur Project

```
si-bago/
├── admin/
│   ├── dashboard.php      # Dashboard admin
│   ├── edit.php          # Edit konten menu
│   ├── login.php         # Login admin
│   ├── logout.php        # Logout
│   └── penyusun.php      # Kelola penyusun
├── assets/
│   ├── css/
│   │   └── style.css     # CSS custom
│   ├── js/
│   │   └── main.js       # JavaScript utilities
│   └── img/
│       ├── default-avatar.png
│       └── penyusun/     # Foto penyusun
├── config/
│   └── database.php      # Koneksi database
├── database/
│   ├── si-bago.sql       # Database schema & data
│   └── sample_penyusun.sql
├── menu/
│   ├── dokumentasi.php   # Halaman dokumentasi
│   ├── etnomatematika.php
│   ├── gladhen.php       # Halaman kartu gladhen
│   ├── identitas.php
│   ├── logo.php
│   ├── penyusun.php      # Halaman penyusun
│   └── view_menu.php     # Template view menu
├── footer.php            # Footer template
├── head.php             # Head template
├── header.php           # Header template
├── index.php            # Homepage
├── setup_database.php   # Setup database
└── README.md            # Dokumentasi ini
```

## 🚀 Instalasi

### Prasyarat
- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau MariaDB 10.4+
- Web server (Apache/Nginx)
- phpMyAdmin (opsional)

### Langkah Instalasi

1. **Clone atau Extract Project**
   ```bash
   # Extract si-bago.zip ke folder web server
   # Contoh: C:/xampp/htdocs/si-bago
   ```

2. **Buat Database**
   ```sql
   CREATE DATABASE db_sibago;
   ```

3. **Import Database**
   - Buka phpMyAdmin
   - Pilih database `db_sibago`
   - Import file `database/si-bago.sql`
   
   Atau via command line:
   ```bash
   mysql -u root -p db_sibago < database/si-bago.sql
   ```

4. **Konfigurasi Database**
   Edit file `config/database.php`:
   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";  // password database Anda
   $db = "db_sibago";
   ```

5. **Jalankan Setup (Opsional)**
   Buka di browser: `http://localhost/si-bago/setup_database.php`

6. **Akses Website**
   ```
   Frontend: http://localhost/si-bago/
   Admin: http://localhost/si-bago/admin/login.php
   ```

## 🔐 Login Admin

**Default Admin Account:**
- Username: `admin`
- Password: `admin123`

⚠️ **PENTING**: Segera ganti password default setelah login pertama!

## 📝 Penggunaan

### Untuk Administrator

1. **Login ke Admin Panel**
   - Akses `/admin/login.php`
   - Masukkan username dan password

2. **Kelola Konten Menu**
   - Dashboard → Kelola Konten Menu
   - Klik "Edit" untuk mengubah konten
   - Klik "Tambah Menu Baru" untuk menambah menu

3. **Kelola Penyusun**
   - Dashboard → Kelola Penyusun
   - Upload foto penyusun (format: JPG, PNG, max 2MB)
   - Tambah/edit biodata penyusun

4. **Upload Dokumentasi**
   - Menu Dokumentasi → Upload Foto
   - Pilih foto dan isi deskripsi
   - Foto akan muncul di galeri

### Untuk Pengunjung

1. **Jelajahi Menu**
   - Klik salah satu dari 6 kartu menu di homepage
   - Baca informasi lengkap di setiap halaman

2. **Lihat Galeri**
   - Kunjungi halaman Dokumentasi
   - Klik foto untuk melihat dalam mode fullscreen

3. **Pelajari Kartu Gladhen**
   - Lihat jenis-jenis kartu
   - Pelajari aturan permainan
   - Download panduan lengkap

## 🎨 Customization

### Mengubah Warna Tema

Edit file `assets/css/style.css`:
```css
:root {
    --primary-color: #8B4513;    /* Coklat tua */
    --secondary-color: #D2691E;  /* Coklat muda */
    --accent-color: #FF6B35;     /* Orange */
    --accent-light: #F7931E;     /* Orange terang */
}
```

### Menambah Menu Baru

1. Login sebagai admin
2. Dashboard → "Tambah Menu Baru"
3. Isi slug, judul, dan konten
4. Menu otomatis muncul di navbar

### Mengubah Logo

Replace file:
- `assets/img/logo.png` (ukuran ideal: 200x200px)

## 🔧 Troubleshooting

### Database Connection Error
```
Error: Connection failed: Access denied for user...
```
**Solusi**: 
- Periksa konfigurasi di `config/database.php`
- Pastikan username dan password database benar
- Pastikan database sudah dibuat

### Menu Tidak Muncul
**Solusi**:
- Jalankan `setup_database.php`
- Import ulang file `database/si-bago.sql`
- Pastikan tabel `menu` terisi

### Upload Foto Gagal
**Solusi**:
- Periksa permission folder `assets/img/penyusun/` (chmod 755 atau 777)
- Pastikan format file: JPG, PNG, GIF
- Maksimal ukuran file: 2MB

### CSS/JS Tidak Load
**Solusi**:
- Clear browser cache (Ctrl + F5)
- Periksa path file di `head.php` dan `footer.php`
- Pastikan file CSS/JS ada di folder `assets/`

## 📱 Responsive Design

SI-BAGO sudah dioptimalkan untuk berbagai ukuran layar:
- 📱 Mobile (< 576px)
- 📱 Tablet (576px - 768px)
- 💻 Desktop (> 768px)

## ⚡ Performa

- Lazy loading untuk gambar
- Minified CSS dan JS (production)
- Optimasi database query
- Caching browser
- Compressed images

## 🔐 Keamanan

- SQL Injection protection (prepared statements)
- XSS prevention (htmlspecialchars)
- Session management
- Password hashing (MD5 - **disarankan upgrade ke bcrypt**)
- CSRF protection (akan ditambahkan)

## 🚧 Roadmap

### Version 2.0 (Planning)
- [ ] User registration & login
- [ ] Online quiz feature
- [ ] Leaderboard
- [ ] Certificate generator
- [ ] API integration
- [ ] Multi-language support
- [ ] Dark mode
- [ ] PWA (Progressive Web App)

## 👥 Tim Pengembang

- **Dr. Henry Suryo Bintoro, S.Pd., M.Pd.** - Project Lead
- **Galeh Febrian Agustino** - Developer
- **Meutya Rahma Hakim** - Designer
- **Luqyana Rosyada** - Content Writer
- **Muhammad Rifky Nur Rahman** - Tester
- **Muhammad Fajar Maulana** - Researcher
- **Muhammad Azka Latif** - Documentation

## 📄 License

© 2026 SI-BAGO. All Rights Reserved.

Developed with ❤️ by Tim SI-BAGO

---

## 🤝 Kontribusi

Kami terbuka untuk kontribusi! Jika Anda ingin berkontribusi:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📞 Kontak

- Email: 
- Website:
- Phone: 

---

**Terima kasih telah menggunakan SI-BAGO!** 🎉
