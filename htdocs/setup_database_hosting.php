<?php
// Tampilkan error jika ada agar kita tahu masalahnya
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Konfigurasi Database (Gunakan data dari panel MySQL InfinityFree)
$servername = "sql303.infinityfree.com"; // Sesuaikan dengan Hostname di panel kamu
$username   = "if0_40382552";            // Username dari panel
$password   = "PASSWORD_KAMU_DISINI";    // GANTI DENGAN PASSWORD DATABASE KAMU
$dbname     = "if0_40382552_db_sibago";  // Nama database dari panel

// 2. Koneksi langsung ke database yang sudah dibuat di panel
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 3. Tambahkan Admin Default
$sql_admin = "INSERT IGNORE INTO admin (username, password) VALUES ('admin', MD5('admin123'))";
$conn->query($sql_admin);

// 4. Data Menu
$menu_data = [
    ['identitas', 'Identitas SI-BAGO', 'SI-BAGO (Smart Innovative Boardgame Geometri) hadir sebagai manifestasi...'],
    ['logo', 'Filosofi Logo SI-BAGO', 'Logo SI-BAGO dirancang untuk melambangkan...'],
    ['etnomatematika', 'Etnomatematika Jawa Tengah', 'Etnomatematika dalam SI-BAGO hadir untuk membuktikan...'],
    ['gladhen', 'Kartu Gladhen', 'To be continued..'],
    ['penyusun', 'Seputar Penyusun', '• Dr. Henry Suryo Bintoro, S. Pd., M. Pd...'],
    ['dokumentasi', 'Dokumentasi SI-BAGO', 'Dokumentasi ini merangkum perjalanan kreatif...']
];

// 5. Insert data menu ke database
foreach ($menu_data as $menu) {
    $stmt = $conn->prepare("INSERT IGNORE INTO menu (slug, judul, konten) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $menu[0], $menu[1], $menu[2]);
    $stmt->execute();
}

$conn->close();

echo "<strong>Setup selesai! Data menu telah dimasukkan ke database.</strong><br>";
echo "<a href='index.php'>Kembali ke halaman utama</a>";
?>