<?php
/**
 * htdocs/setup_database_local.php
 * Setup database otomatis untuk development LOKAL (XAMPP/WAMP/LAMP)
 * Membuat database + tabel + admin default jika belum ada
 *
 * Cara pakai: akses lewat browser
 * http://localhost/SI-BAGO/htdocs/setup_database_local.php
 */

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "db_sibago";

// Buat koneksi tanpa database dulu (untuk CREATE DATABASE)
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat database jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
$conn->select_db($dbname);

// Tabel admin
$conn->query("CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)");

// Tabel menu
$conn->query("CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50),
    judul VARCHAR(100),
    konten TEXT,
    foto TEXT NULL
)");

// Tabel penyusun
$conn->query("CREATE TABLE IF NOT EXISTS penyusun (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Admin default
$conn->query("INSERT IGNORE INTO admin (username, password) VALUES ('admin', MD5('admin123'))");

echo "<strong>Setup database lokal selesai!</strong><br>";
echo "Database, tabel, dan admin default sudah siap.<br>";
echo "Untuk mengisi data menu (Identitas, Logo, dst), import file <code>database/db_sibago.sql</code> lewat phpMyAdmin.<br><br>";
echo "<a href='../index.php'>Kembali ke halaman utama</a>";

$conn->close();
?>
