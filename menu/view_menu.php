<?php
include '../head.php';
include '../header.php';
include '../config/database.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header("Location: ../index.php");
    exit;
}

// Ambil data menu dari database (tersedia untuk semua file konten via $data)
$data = $conn->query("SELECT * FROM menu WHERE slug='$slug'")->fetch_assoc();

if (!$data) {
    $data = [
        'judul' => 'Menu Tidak Ditemukan',
        'konten' => 'Menu yang Anda cari tidak tersedia atau belum dibuat.',
        'foto' => null
    ];
}

// ============================================================
// ROUTER UTAMA — Sistem Whitelist
//
// Daftarkan slug yang punya file konten SENDIRI (content-only,
// tanpa head/header/footer) di array $custom_pages.
//
// File etnomatematika.php, gladhen.php, dll yang punya
// header/footer sendiri JANGAN didaftarkan di sini.
//
// Cara tambah menu baru:
// 1. Buat file menu/namabaru.php (content-only, tanpa header/footer)
// 2. Tambahkan 'namabaru' ke array $custom_pages di bawah
// ============================================================
$custom_pages = [
    'simulasi',       // menu/simulasi.php ✅ content-only
    'etnomatematika', // menu/etnomatematika.php ✅ content-only
    'gladhen',        // menu/gladhen.php ✅ content-only
    'penyusun',       // menu/penyusun.php ✅ content-only
];

$page_file = __DIR__ . '/' . $slug . '.php';

if (in_array($slug, $custom_pages) && file_exists($page_file)) {
    // Include file konten khusus (tanpa head/header/footer)
    include $page_file;

} else {
    // ── Layout Umum (untuk semua menu yang tidak ada di whitelist) ──
    $foto_gallery = [];
    if (!empty($data['foto'])) {
        $foto_gallery = json_decode($data['foto'], true);
        if (!is_array($foto_gallery)) {
            $foto_gallery = [$data['foto']];
        }
    }
    ?>
    <style>
    /* ─── KODE PEMAKSA WARNA BIRU SOFT (TAMBAHKAN INI) ─── */
    .navbar {
        background: #A2C2E8 !important; /* Mengubah background navbar */
    }
    footer {
        background: #A2C2E8 !important; /* Mengubah background footer */
    }
    .navbar-nav .nav-link, .navbar-brand {
        color: #2C3E50 !important; /* Mengubah teks menu menjadi gelap agar kontras */
    }
    .navbar-nav .nav-link:hover {
        background: rgba(255,255,255,0.4) !important;
    }

    /* ─── Kode Bawaan Asli Kamu (Biarkan Tetap Ada) ─── */
    .content { text-align: justify; line-height: 1.6; }
    .photo-gallery-section { margin-top: 40px; padding-top: 30px; border-top: 2px solid #e9ecef; }
    .photo-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
    @media (max-width: 768px) { .photo-gallery { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); } }
    .gallery-item { border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; aspect-ratio: 4/3; }
    .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s ease; }
    .gallery-item:hover img { transform: scale(1.1); }
    .lightbox-modal { display: none; position: fixed; z-index: 9999; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.9); }
    .lightbox-modal.active { display: flex; align-items: center; justify-content: center; }
    .lightbox-content { max-width: 90%; max-height: 90%; position: relative; }
    .lightbox-content img { max-width: 100%; max-height: 90vh; border-radius: 8px; }
    .lightbox-close { position: absolute; top:20px; right:40px; font-size:40px; color:white; cursor:pointer; z-index:10000; }
    .lightbox-nav { position:absolute; top:50%; transform:translateY(-50%); font-size:50px; color:white; cursor:pointer; user-select:none; padding:20px; }
    .lightbox-prev { left:20px; } .lightbox-next { right:20px; }
    </style>

    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold"><?php echo htmlspecialchars($data['judul']); ?></h2>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">

                        <?php if ($slug === 'logo'): ?>
                        <!-- ── Banner Logo SI-BAGO ── -->
                        <div class="row align-items-center mb-4">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <img src="../assets/img/LOGO SI-BAGO.png"
                                     alt="Logo SI-BAGO"
                                     style="max-width:100%; height:auto; max-height:160px; object-fit:contain;">
                            </div>
                            <div class="col-md-9">
                                <p style="text-align:justify; margin-bottom:0; font-style:italic; color:#555; line-height:1.7;">
                                    Logo SI-BAGO dirancang untuk melambangkan transformasi pembelajaran matematika yang kaku
                                    menjadi sebuah petualangan interaktif, di mana setiap elemen visualnya mencerminkan
                                    nilai edukasi, budaya, dan teknologi.
                                </p>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <?php endif; ?>

                        <div class="content mb-5"><?php echo nl2br($data['konten']); ?></div>

                        <?php if (!empty($foto_gallery)): ?>
                            <div class="photo-gallery-section">
                                <h4 class="mb-4"><i class="fas fa-images"></i> Galeri Foto</h4>
                                <div class="photo-gallery">
                                    <?php foreach ($foto_gallery as $index => $foto): ?>
                                        <div class="gallery-item" onclick="openLightbox(<?= $index ?>)">
                                            <img src="../assets/img/uploads/<?= htmlspecialchars($foto) ?>" loading="lazy">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox(event)">
        <span class="lightbox-close" onclick="closeLightbox(event)">&times;</span>
        <span class="lightbox-nav lightbox-prev" onclick="changeImage(-1,event)">&#10094;</span>
        <span class="lightbox-nav lightbox-next" onclick="changeImage(1,event)">&#10095;</span>
        <div class="lightbox-content"><img id="lightboxImage" src="" alt=""></div>
    </div>
    <script>
    const images = <?= json_encode($foto_gallery) ?>;
    let cur = 0;
    function openLightbox(i) {
        if (!images.length) return;
        cur = i;
        document.getElementById('lightboxImage').src = '../assets/img/uploads/' + images[i];
        document.getElementById('lightboxModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox(e) {
        if (e.target.id === 'lightboxModal' || e.target.className === 'lightbox-close') {
            document.getElementById('lightboxModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
    function changeImage(dir, e) {
        e.stopPropagation();
        cur = (cur + dir + images.length) % images.length;
        document.getElementById('lightboxImage').src = '../assets/img/uploads/' + images[cur];
    }
    document.addEventListener('keydown', e => {
        const m = document.getElementById('lightboxModal');
        if (!m.classList.contains('active')) return;
        if (e.key === 'Escape') { m.classList.remove('active'); document.body.style.overflow = 'auto'; }
        if (e.key === 'ArrowLeft')  changeImage(-1, {stopPropagation:()=>{}});
        if (e.key === 'ArrowRight') changeImage(1,  {stopPropagation:()=>{}});
    });
    </script>
    <?php
}

include '../footer.php';
?>