<?php
session_start();
include '../head.php';
include '../header.php';
include '../config/database.php';

$slug = 'dokumentasi';
$data = $conn->query("SELECT * FROM menu WHERE slug='$slug'")->fetch_assoc();

if (!$data) {
    $data = [
        'judul' => 'Dokumentasi SI-BAGO',
        'konten' => 'Dokumentasi ini merangkum perjalanan kreatif lahirnya SI-BAGO.'
    ];
}

$dokumentasi_items = [
    [
        'image' => 'https://via.placeholder.com/400x300/8B4513/ffffff?text=Workshop+SI-BAGO',
        'title' => 'Workshop Pengembangan SI-BAGO',
        'description' => 'Sesi brainstorming dan workshop intensif dalam pengembangan media pembelajaran SI-BAGO'
    ],
    [
        'image' => 'https://via.placeholder.com/400x300/D2691E/ffffff?text=LOGO SI-BAGO',
        'title' => 'LOGO SI-BAGO',
        'description' => 'Logo resmi SI-BAGO yang mencerminkan nilai-nilai etnomatematika'
    ],
    [
        'image' => 'https://via.placeholder.com/400x300/FF6B35/ffffff?text=Presentasi+Media',
        'title' => 'Presentasi Media Pembelajaran',
        'description' => 'Presentasi SI-BAGO di forum pendidikan matematika'
    ],
    [
        'image' => 'https://via.placeholder.com/400x300/8B4513/ffffff?text=Desain+Kartu',
        'title' => 'Proses Desain Kartu Gladhen',
        'description' => 'Proses kreatif dalam mendesain kartu-kartu permainan yang menarik'
    ],
    [
        'image' => 'https://via.placeholder.com/400x300/D2691E/ffffff?text=Tim+Penyusun',
        'title' => 'Tim Penyusun SI-BAGO',
        'description' => 'Foto bersama tim penyusun setelah menyelesaikan prototype SI-BAGO'
    ],
    [
        'image' => 'https://via.placeholder.com/400x300/FF6B35/ffffff?text=Etnomatematika',
        'title' => 'Eksplorasi Etnomatematika',
        'description' => 'Penelusuran objek-objek budaya Jawa Tengah untuk materi SI-BAGO'
    ]
];
?>

<style>
.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    animation: fadeIn 0.3s ease;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 15px;
}

.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    font-size: 40px;
    color: white;
    cursor: pointer;
}

.lightbox-caption {
    color: white;
    text-align: center;
    margin-top: 1rem;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>

<div class="container py-5">
    <h2 class="text-center mb-4"><?php echo htmlspecialchars($data['judul']); ?></h2>

    <div class="row mb-5">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="content">
                        <?php echo nl2br(htmlspecialchars($data['konten'])); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3 class="text-center mb-4" style="color: #8B4513;">📸 Galeri Foto</h3>
        </div>
    </div>

    <div class="gallery-grid">
        <?php foreach ($dokumentasi_items as $item): ?>
        <div class="gallery-item" data-title="<?php echo htmlspecialchars($item['title']); ?>">
            <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                 alt="<?php echo htmlspecialchars($item['title']); ?>">
            <div class="gallery-item-overlay">
                <h5><?php echo htmlspecialchars($item['title']); ?></h5>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const img = this.querySelector('img');
            const title = this.getAttribute('data-title');
            
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <span class="lightbox-close">&times;</span>
                    <img src="${img.src}" alt="${title}">
                    <p class="lightbox-caption">${title}</p>
                </div>
            `;
            
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            lightbox.querySelector('.lightbox-close').addEventListener('click', function() {
                document.body.removeChild(lightbox);
                document.body.style.overflow = '';
            });
            
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    document.body.removeChild(lightbox);
                    document.body.style.overflow = '';
                }
            });
        });
    });
});
</script>

<?php include '../footer.php'; ?>
