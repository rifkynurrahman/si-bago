<?php
include 'head.php';
include 'header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars(trim($_POST['nama']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subjek = htmlspecialchars(trim($_POST['subjek']));
    $pesan = htmlspecialchars(trim($_POST['pesan']));
    
    if (!empty($nama) && !empty($email) && !empty($subjek) && !empty($pesan)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // In real application, you would send email or save to database
            // For now, just show success message
            $success = "Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.";
        } else {
            $error = "Format email tidak valid!";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<style>
.contact-hero {
    background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
    margin-bottom: 3rem;
}

.contact-hero h1 {
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 1rem;
}

.contact-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #FF6B35, #F7931E);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin: 0 auto 1rem;
}

.info-card {
    background: linear-gradient(135deg, rgba(139,69,19,0.05) 0%, rgba(210,105,30,0.05) 100%);
    border-left: 5px solid #FF6B35;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.info-card h5 {
    color: #8B4513;
    font-weight: 700;
    margin-bottom: 1rem;
}

.info-card p {
    margin-bottom: 0.5rem;
}

.info-card i {
    color: #FF6B35;
    margin-right: 0.5rem;
    width: 20px;
}

.social-links {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.social-link {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #FF6B35, #F7931E);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    font-size: 1.3rem;
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.5);
    color: white;
}
</style>

<div class="contact-hero">
    <div class="container">
        <h1><i class="fas fa-envelope"></i> Hubungi Kami</h1>
        <p class="lead">Punya pertanyaan? Kami siap membantu Anda!</p>
    </div>
</div>

<div class="container py-5">
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <strong>Sukses!</strong> <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8 mb-4">
            <div class="contact-card">
                <h3 class="mb-4" style="color: #8B4513;">
                    <i class="fas fa-paper-plane"></i> Kirim Pesan
                </h3>
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control" id="nama" name="nama" required
                                   placeholder="Masukkan nama Anda">
                            <div class="invalid-feedback">Nama harus diisi!</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   placeholder="nama@email.com">
                            <div class="invalid-feedback">Email harus valid!</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subjek" class="form-label">Subjek *</label>
                        <input type="text" class="form-control" id="subjek" name="subjek" required
                               placeholder="Subjek pesan">
                        <div class="invalid-feedback">Subjek harus diisi!</div>
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan *</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="6" required
                                  placeholder="Tulis pesan Anda di sini..."></textarea>
                        <div class="invalid-feedback">Pesan harus diisi!</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-4">
            <div class="info-card">
                <h5><i class="fas fa-map-marker-alt"></i> Alamat</h5>
                <p>
                    Universitas Muria Kudus<br>
                    Jl. Lingkar Utara, Kayuapu Kulon<br>
                    Gondangmanis, Kudus, Jawa Tengah<br>
                    59324
                </p>
            </div>

            <div class="info-card">
                <h5><i class="fas fa-phone"></i> Telepon</h5>
                <p>
                    <i class="fas fa-phone-alt"></i> +62 123 4567 8900<br>
                    <i class="fas fa-fax"></i> +62 123 4567 8901
                </p>
            </div>

            <div class="info-card">
                <h5><i class="fas fa-envelope"></i> Email</h5>
                <p>
                    <i class="fas fa-envelope"></i> info@sibago.com<br>
                    <i class="fas fa-envelope"></i> support@sibago.com
                </p>
            </div>

            <div class="info-card">
                <h5><i class="fas fa-clock"></i> Jam Operasional</h5>
                <p>
                    <i class="fas fa-calendar-week"></i> Senin - Jumat<br>
                    <i class="fas fa-clock"></i> 08:00 - 16:00 WIB<br>
                    <br>
                    <i class="fas fa-calendar-week"></i> Sabtu<br>
                    <i class="fas fa-clock"></i> 08:00 - 12:00 WIB
                </p>
            </div>

            <!-- Social Media -->
            <div class="text-center mt-4">
                <h5 style="color: #8B4513; font-weight: 700;">
                    <i class="fas fa-share-alt"></i> Ikuti Kami
                </h5>
                <div class="social-links">
                    <a href="#" class="social-link" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="contact-card">
                <h3 class="mb-4 text-center" style="color: #8B4513;">
                    <i class="fas fa-map-marked-alt"></i> Lokasi Kami
                </h3>
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0!2d110.8!3d-6.8!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNDgnMDAuMCJTIDExMMKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890"
                        style="border:0; border-radius: 15px;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php include 'footer.php'; ?>
