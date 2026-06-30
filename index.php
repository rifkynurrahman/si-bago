<?php
// Tambahkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan session dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'config/database.php';
?>

<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<style>
/* ─── FIX KODE PEMAKSA WARNA: MENYAMAKAN DENGAN BACKGROUND BAWAH ─── */
.hero-section {
    background: #F4F6F9 !important; /* Warna abu-abu terang bersih, menyatu dengan background bawah */
    color: #2C3E50 !important;      /* Teks diubah menjadi gelap agar terlihat sangat tajam */
    padding: 4rem 0;
}

/* Memastikan tulisan judul SI-BAGO terlihat jelas, tebal, dan tajam */
.hero-section h1.display-4 {
    color: #2C3E50 !important;
    font-weight: 800;
    text-shadow: none !important; /* Menghapus shadow putih agar tidak blur */
}

/* Memastikan teks deskripsi di bawah judul juga berwarna gelap dan bersih */
.hero-section p.lead, .hero-section p {
    color: #4A5A6A !important;
}

/* Logo animation (Bawaan asli kamu) */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.logo-container {
    animation: fadeInDown 1s ease, float 3s ease-in-out infinite 1s;
}

.logo-container img {
    transition: all 0.3s ease;
}

.logo-container:hover img {
    transform: scale(1.05);
    filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.1)) !important; /* Shadow halus gelap agar lebih menyatu */
}
</style>

<div class="hero-section text-center py-5">
    <div class="logo-container mb-4">
        <img src="assets/img/LOGO SI-BAGO.png" 
             alt="Logo SI-BAGO" 
             class="img-fluid" 
             style="max-width: 350px; 
                    max-height: 350px;  
                    padding: 20px; 
                    border-radius: 20px;
                    filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.08));">
    </div>
    
    <h1 class="display-4">SI-BAGO</h1>
    <p class="lead">
        Smart Innovative Boardgame Geometri berbasis Etnomatematika Jawa Tengah
    </p>
    <p class="mt-3">Mari eksplorasi keindahan matematika melalui budaya dan tradisi Jawa</p>
</div>

<div class="container mt-5">
    <div class="row">
        <?php
        // Array icon untuk setiap menu
        $menu_icons = [
            'identitas' => '📐',
            'logo' => '🎨',
            'etnomatematika' => '🧮',
            'gladhen' => '🃏',
            'penyusun' => '👥',
            'dokumentasi' => '📸',
            'simulasi' => '🎲'   
        ];

        // Array deskripsi untuk setiap menu
        $menu_descriptions = [
            'identitas' => 'Informasi lengkap tentang SI-BAGO dan tujuannya dalam pendidikan matematika.',
            'logo' => 'Makna filosofis di balik desain logo SI-BAGO yang sarat nilai budaya Jawa.',
            'etnomatematika' => 'Eksplorasi matematika yang terintegrasi dengan kearifan lokal Jawa Tengah.',
            'gladhen' => 'Permainan kartu edukasi yang menggabungkan geometri dan budaya Jawa.',
            'penyusun' => 'Profil tim penyusun yang berkomitmen pada pendidikan matematika berkualitas.',
            'dokumentasi' => 'Galeri dokumentasi kegiatan dan perkembangan SI-BAGO dari waktu ke waktu.',
            'simulasi' => 'Visualisasi interaktif bangun ruang 3D — putar, ubah ukuran, dan eksplorasi geometri secara langsung!'
        ];

        // Ambil data menu dari database
        $menus = $conn->query("SELECT slug, judul FROM menu ORDER BY id");
        $menu_count = 0;

        while ($menu = $menus->fetch_assoc()) {
            $slug = $menu['slug'];
            $icon = $menu_icons[$slug] ?? '📄';
            $description = $menu_descriptions[$slug] ?? 'Pelajari lebih lanjut tentang ' . $menu['judul'];

            echo "<div class='col-md-4 mb-4'>
                <div class='card h-100 shadow-sm border-0' style='border-radius: 12px;'>
                    <div class='card-body text-center p-4'>
                        <div class='math-icon' style='font-size: 2.5rem; margin-bottom: 1rem;'>{$icon}</div>
                        <h5 class='card-title fw-bold' style='color: #2C3E50;'>{$menu['judul']}</h5>
                        <p class='card-text text-muted' style='font-size: 0.95rem;'>{$description}</p>
                        <a href='menu/view_menu.php?slug={$slug}' class='btn btn-primary px-4' style='background: #7AA0CD; border: none; border-radius: 8px;'>Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>";

            $menu_count++;
            // Buat baris baru setiap 3 menu
            if ($menu_count % 3 == 0) {
                echo "</div><div class='row'>";
            }
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>