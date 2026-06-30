<?php
/**
 * menu/etnomatematika.php
 * Konten halaman Etnomatematika — content-only
 * Di-include oleh view_menu.php — TIDAK perlu head/header/footer
 * Variabel $data tersedia dari view_menu.php, tapi tetap dijaga
 * agar aman jika file ini diakses/dites secara langsung.
 */

if (!isset($conn)) {
    include '../config/database.php';
}
if (!isset($data) || empty($data)) {
    $slug = 'etnomatematika';
    $data = $conn->query("SELECT * FROM menu WHERE slug='$slug'")->fetch_assoc();
    if (!$data) {
        $data = ['judul' => 'Etnomatematika Jawa Tengah'];
    }
}

// HARDCODE DATA ETNOMATEMATIKA - GANTI NAMA FOTO DI SINI
$kategori_etno = [
    [
        'judul' => 'Nasi Tumpeng (Kerucut)',
        'konten' => 'Bentuknya yang menjulang tinggi ke atas adalah contoh Kerucut. Bagian bawahnya bulat (lingkaran) dan ujungnya lancip. (Hampir di seluruh daerah Jawa Tengah).',
        'foto' => ['nasi tumpeng.png', 'kerucut.png']
    ],
    [
        'judul' => 'Kue Wajik (Kubus)',
        'konten' => 'Kue manis ini dipotong miring supaya membentuk Prisma. Alasnya terlihat seperti jajar genjang atau belah ketupat. (Banyak ditemukan di Magelang dan Semarang).',
        'foto' => ['kue wajik.png', 'prisma.png']
    ],
    [
        'judul' => 'Rumah Joglo (Limas Terpancung)',
        'konten' => 'Coba lihat atap paling atas rumah Joglo. Bentuknya seperti Limas yang dipotong bagian pucuknya. Jadi, bagian atasnya datar! (Rumah adat khas Jawa Tengah).',
        'foto' => ['rumah joglo.png', 'limas terpancung.png']
    ],
    [
        'judul' => 'Kue Gabin Tapai (Balok)',
        'konten' => 'Dua biskuit kotak yang mengapit tapai ini membentuk Balok tipis. Ada sisi atas, bawah, dan samping yang semuanya berbentuk persegi panjang. (Camilan populer di Jawa Tengah).',
        'foto' => ['kue gabin.png', 'balok.png']
    ],
    [
        'judul' => 'Onde-onde (Bola)',
        'konten' => 'Jajanan bulat berbalur wijen ini adalah contoh Bola. Tidak punya sudut, hanya ada satu permukaan melengkung. (Sangat terkenal di daerah Mojokerto dan sekitarnya).',
        'foto' => ['onde onde.png', 'bola.png']
    ],
    [
        'judul' => 'Kue Lapis Legit (Kubus atau Balok)',
        'konten' => 'Kue ini punya banyak lapisan warna. Kalau dipotong kotak sama panjang, jadilah Kubus yang cantik! (Sajian khas saat hari raya di Jawa Tengah).',
        'foto' => ['kue lapis.png', 'kubus.png']
    ],
    [
        'judul' => 'Bedug Masjid (Tabung)',
        'konten' => 'Alat musik pukul di masjid ini bentuknya Tabung raksasa. Kulit senjatnya berbentuk lingkaran, badan utamanya seperti silinder besar.',
        'foto' => ['bedug.png', 'tabung.png']
    ],
    [
        'judul' => 'Keris (Prisma Segitiga)',
        'konten' => 'Senjata pusaka ini kalau dilihat dari samping, penampangnya berbentuk segitiga. Dari ujung sampai pangkal, bentuknya konsisten seperti prisma.',
        'foto' => ['keris.png', 'segitiga.png']
    ],
    [
        'judul' => 'Gunungan Wayang (Segitiga & Trapesium)',
        'konten' => 'Properti wayang kulit ini bentuknya seperti gunung. Bagian atasnya runcing (segitiga), sedangkan keseluruhannya bisa dilihat sebagai trapesium.',
        'foto' => ['gunung wayang.png', 'trapesium.png']
    ],
    [
        'judul' => 'Candi (Limas Segi Empat)',
        'konten' => 'Atap candi-candi kuno di Jawa Tengah seperti Candi Borobudur memiliki stupa berbentuk limas. Dasarnya persegi, puncaknya meruncing.',
        'foto' => ['candi.png', 'limas segi empat.png']
    ]
];

// Buat array semua foto untuk lightbox
$foto_gallery = [];
foreach ($kategori_etno as $kat) {
    $foto_gallery = array_merge($foto_gallery, $kat['foto']);
}
?>

<style>
.etno-layout {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 2px solid #e9ecef;
}
.etno-layout:last-child { border-bottom: none; }
.etno-text {
    text-align: justify;
    line-height: 1.8;
    margin-bottom: 20px;
}
.etno-text h5 {
    color: #d97634;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1.2rem;
}
.etno-images { display: flex; gap: 20px; justify-content: center; }
.etno-images img {
    width: 48%; max-width: 400px; height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
    cursor: pointer;
}
.etno-images img:hover { transform: scale(1.05); }
@media (max-width: 768px) {
    .etno-images { flex-direction: column; align-items: center; }
    .etno-images img { width: 100%; max-width: 500px; }
}
/* Lightbox */
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

                    <div class="mb-4">
                        <p style="text-align:justify; line-height:1.8; margin-bottom:30px;">
                            Etnomatematika dalam SI-BAGO hadir untuk membuktikan bahwa matematika bukanlah sekadar angka di atas kertas,
                            melainkan napas budaya yang telah lama hidup dalam keseharian masyarakat Jawa Tengah. Melalui media ini, siswa
                            diajak menelusuri jejak logika para leluhur yang tertuang dalam arsitektur megah, kelezatan kuliner, hingga artefak
                            tradisional yang sarat akan nilai geometri.
                        </p>
                    </div>

                    <?php
                    $photoIndex = 0;
                    foreach ($kategori_etno as $index => $item):
                    ?>
                        <div class="etno-layout">
                            <div class="etno-text">
                                <h5><?= ($index + 1) ?>) <?= htmlspecialchars($item['judul']) ?></h5>
                                <p style="margin-bottom:0;"><?= nl2br(htmlspecialchars($item['konten'])) ?></p>
                            </div>
                            <div class="etno-images">
                                <?php foreach ($item['foto'] as $foto): ?>
                                    <img src="../assets/img/uploads/<?= htmlspecialchars($foto) ?>"
                                         alt="<?= htmlspecialchars($item['judul']) ?>"
                                         onclick="openLightbox(<?= $photoIndex ?>)">
                                    <?php $photoIndex++; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

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
const etnoImages = <?= json_encode($foto_gallery) ?>;
let etnoIndex = 0;
function openLightbox(i) {
    etnoIndex = i;
    document.getElementById('lightboxImage').src = '../assets/img/uploads/' + etnoImages[i];
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
    etnoIndex = (etnoIndex + dir + etnoImages.length) % etnoImages.length;
    document.getElementById('lightboxImage').src = '../assets/img/uploads/' + etnoImages[etnoIndex];
}
document.addEventListener('keydown', e => {
    const m = document.getElementById('lightboxModal');
    if (!m.classList.contains('active')) return;
    if (e.key === 'Escape') { m.classList.remove('active'); document.body.style.overflow = 'auto'; }
    if (e.key === 'ArrowLeft')  changeImage(-1, {stopPropagation:()=>{}});
    if (e.key === 'ArrowRight') changeImage(1,  {stopPropagation:()=>{}});
});
</script>