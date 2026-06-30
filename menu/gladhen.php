<?php
/**
 * menu/gladhen.php
 * Konten halaman Kartu Gladhen & Kartu Cakra — content-only
 * Di-include oleh view_menu.php — TIDAK perlu head/header/footer
 * Variabel $data tersedia dari view_menu.php, tapi tetap dijaga
 * agar aman jika file ini diakses/dites secara langsung.
 */

if (!isset($conn)) {
    include '../config/database.php';
}
if (!isset($data) || empty($data)) {
    $slug = 'gladhen';
    $data = $conn->query("SELECT * FROM menu WHERE slug='$slug'")->fetch_assoc();
    if (!$data) {
        $data = ['judul' => 'Kartu Gladhen', 'foto' => null];
    }
}

// Ambil foto dari database
$foto_gallery = [];
if (!empty($data['foto'])) {
    $foto_gallery = json_decode($data['foto'], true);
    if (!is_array($foto_gallery)) {
        $foto_gallery = [$data['foto']];
    }
}

// ============================================================
// ATUR JUMLAH FOTO DI SINI
// $jumlah_gladhen = berapa foto pertama untuk Kartu Gladhen
// Sisanya otomatis masuk Kartu Cakra
// Contoh: total 10 foto, gladhen=7 → gladhen dapat 7, cakra dapat 3
// ============================================================
$jumlah_gladhen = 16; // ← GANTI ANGKA INI sesuai kebutuhan

$foto_gladhen = array_slice($foto_gallery, 0, $jumlah_gladhen);
$foto_cakra   = array_slice($foto_gallery, $jumlah_gladhen);
?>

<style>
.gladhen-section {
    margin-bottom: 45px;
    padding-bottom: 35px;
    border-bottom: 2px solid #e9ecef;
}
.gladhen-section:last-child { border-bottom: none; margin-bottom: 0; }

.gladhen-title {
    color: #8B4513;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 15px;
    padding-left: 12px;
    border-left: 4px solid #D2691E;
}

.gladhen-text {
    text-align: justify;
    line-height: 1.8;
    margin-bottom: 25px;
    color: #333;
}

/* Grid foto */
.gladhen-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.gladhen-gallery-item {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
    cursor: pointer;
    background: #fff;
    padding: 8px;
    transition: all 0.3s ease;
}

.gladhen-gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(139,69,19,0.25);
}

.gladhen-gallery-item img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 6px;
    transition: transform 0.3s ease;
}

.gladhen-gallery-item:hover img { transform: scale(1.03); }

.gallery-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #8B4513;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.gallery-label::before {
    content: '';
    display: inline-block;
    width: 20px; height: 3px;
    background: #D2691E;
    border-radius: 2px;
}

/* Lightbox */
.lightbox-modal { display:none; position:fixed; z-index:9999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.92); }
.lightbox-modal.active { display:flex; align-items:center; justify-content:center; }
.lightbox-content { max-width:90%; max-height:90%; position:relative; text-align:center; }
.lightbox-content img { max-width:100%; max-height:85vh; border-radius:10px; box-shadow:0 0 40px rgba(0,0,0,0.5); }
.lightbox-caption { color:#fff; margin-top:12px; font-size:0.95rem; opacity:0.85; }
.lightbox-close { position:absolute; top:20px; right:40px; font-size:40px; color:white; cursor:pointer; z-index:10000; line-height:1; }
.lightbox-nav { position:absolute; top:50%; transform:translateY(-50%); font-size:50px; color:white; cursor:pointer; user-select:none; padding:20px; opacity:0.8; transition:opacity 0.2s; }
.lightbox-nav:hover { opacity:1; }
.lightbox-prev { left:20px; } .lightbox-next { right:20px; }

@media (max-width: 768px) {
    .gladhen-gallery { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap:10px; }
}
</style>

<div class="container py-5">
    <h2 class="text-center mb-4 fw-bold"><?php echo htmlspecialchars($data['judul']); ?></h2>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <!-- ── Kartu Gladhen ── -->
                    <div class="gladhen-section">
                        <div class="gladhen-title">🃏 Kartu Gladhen</div>
                        <div class="gladhen-text">
                            Merupakan instrumen tantangan dalam permainan SI-BAGO yang menyajikan soal-soal numerasi
                            dan spasial berbasis etnomatematika. Narasi dalam kartu ini membimbing pemain untuk menghitung
                            volume berbagai objek budaya Jawa Tengah, seperti Nasi Tumpeng, Rumah Joglo, Bedug Masjid,
                            hingga jajanan tradisional seperti Onde-Onde dan Lemper. Selain aspek hitungan, kartu ini juga
                            melatih kemampuan visualisasi melalui soal jaring-jaring bangun ruang yang meminta pemain
                            menentukan posisi alas dan tutup secara imajinatif. Seluruh materi disusun secara kontekstual
                            dengan menyertakan ilustrasi gambar dan dimensi objek untuk mempermudah pemahaman konsep
                            geometri dalam kehidupan sehari-hari.
                        </div>

                        <?php if (!empty($foto_gladhen)): ?>
                            <div class="gallery-label">Foto Kartu Gladhen</div>
                            <div class="gladhen-gallery">
                                <?php foreach ($foto_gladhen as $i => $foto): ?>
                                    <div class="gladhen-gallery-item" onclick="openLightbox(<?= $i ?>, 'gladhen')">
                                        <img src="../assets/img/uploads/<?= htmlspecialchars($foto) ?>"
                                             alt="Kartu Gladhen <?= $i+1 ?>" loading="lazy">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- ── Kartu Cakra ── -->
                    <div class="gladhen-section">
                        <div class="gladhen-title">🌀 Kartu Cakra</div>
                        <div class="gladhen-text">
                            Merupakan bagian dari permainan SI-BAGO yang berisi instruksi nasib bagi para pemain.
                            Kartu ini terbagi menjadi dua jenis utama, yaitu kartu keuntungan yang berwarna hijau
                            untuk memberikan kemajuan seperti melompat maju atau menggandakan angka dadu, serta
                            kartu kerugian yang berwarna merah untuk memberikan hambatan seperti mundur langkah
                            atau berhenti satu putaran. Secara naratif, kartu-kartu ini berfungsi menambah dinamika
                            kompetisi dengan mengubah posisi pemain secara tiba-tiba berdasarkan instruksi yang tertulis.
                        </div>

                        <?php if (!empty($foto_cakra)): ?>
                            <div class="gallery-label">Foto Kartu Cakra</div>
                            <div class="gladhen-gallery">
                                <?php foreach ($foto_cakra as $j => $foto): ?>
                                    <div class="gladhen-gallery-item" onclick="openLightbox(<?= $j ?>, 'cakra')">
                                        <img src="../assets/img/uploads/<?= htmlspecialchars($foto) ?>"
                                             alt="Kartu Cakra <?= $j+1 ?>" loading="lazy">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif (empty($foto_gladhen)): ?>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle"></i> Belum ada foto yang diupload. Tambahkan foto melalui dashboard admin.
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox(event)">
    <span class="lightbox-close" onclick="closeLightboxBtn()">&times;</span>
    <span class="lightbox-nav lightbox-prev" onclick="changeImage(-1,event)">&#10094;</span>
    <span class="lightbox-nav lightbox-next" onclick="changeImage(1,event)">&#10095;</span>
    <div class="lightbox-content">
        <img id="lightboxImage" src="" alt="">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
</div>

<script>
const gladhenFotos = <?= json_encode($foto_gladhen) ?>;
const cakraFotos   = <?= json_encode($foto_cakra) ?>;
let lbImages = [], lbIndex = 0, lbType = '';

function openLightbox(i, type) {
    lbType   = type;
    lbImages = type === 'gladhen' ? gladhenFotos : cakraFotos;
    lbIndex  = i;
    showImage();
    document.getElementById('lightboxModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function showImage() {
    document.getElementById('lightboxImage').src = '../assets/img/uploads/' + lbImages[lbIndex];
    const label = lbType === 'gladhen' ? 'Kartu Gladhen' : 'Kartu Cakra';
    document.getElementById('lightboxCaption').textContent = label + ' ' + (lbIndex + 1) + ' / ' + lbImages.length;
}

function closeLightbox(e) {
    if (e.target.id === 'lightboxModal') {
        document.getElementById('lightboxModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

function closeLightboxBtn() {
    document.getElementById('lightboxModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function changeImage(dir, e) {
    e.stopPropagation();
    lbIndex = (lbIndex + dir + lbImages.length) % lbImages.length;
    showImage();
}

document.addEventListener('keydown', e => {
    const m = document.getElementById('lightboxModal');
    if (!m.classList.contains('active')) return;
    if (e.key === 'Escape')      { closeLightboxBtn(); }
    if (e.key === 'ArrowLeft')   changeImage(-1, {stopPropagation:()=>{}});
    if (e.key === 'ArrowRight')  changeImage(1,  {stopPropagation:()=>{}});
});
</script>