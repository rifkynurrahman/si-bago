<?php
// Determine the correct path based on current directory
$isInSubfolder = (strpos($_SERVER['PHP_SELF'], '/menu/') !== false || 
                  strpos($_SERVER['PHP_SELF'], '/admin/') !== false);
$basePath = $isInSubfolder ? '../' : '';

// Include database only if not already included
if (!isset($conn)) {
    include $basePath . 'config/database.php';
}
?>

<style>
/* Sticky Navbar Styles */
.navbar-sticky {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Modifikasi Efek Scroll ke Biru Soft yang sedikit lebih pekat agar teks tetap terbaca */
.navbar-sticky.scrolled {
    background: linear-gradient(90deg, #92B4DC, #7AA0CD) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    padding: 0.5rem 0 !important;
}

/* Add padding to body to prevent content from hiding under fixed navbar */
body {
    padding-top: 150px;
}

/* Navbar brand animation */
.navbar-brand {
    transition: all 0.3s ease;
    color: #2C3E50 !important; /* Warna teks brand utama */
}

.navbar-brand:hover {
    transform: scale(1.05);
}

/* Nav link text style & hover effects */
.navbar-nav .nav-link {
    position: relative;
    transition: all 0.3s ease;
    color: #2C3E50 !important; /* Mengubah teks menu menjadi biru gelap agar kontras di latar soft */
    font-weight: 500;
}

.navbar-nav .nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: #2C3E50; /* Garis bawah hover menyesuaikan warna teks */
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.navbar-nav .nav-link:hover::after,
.navbar-nav .nav-link.active::after {
    width: 80%;
}

/* Styling khusus untuk menu yang sedang aktif (seperti tombol Identitas) */
.navbar-nav .nav-link.active {
    background-color: rgba(255, 255, 255, 0.4) !important;
    border-radius: 8px;
}

/* Mobile menu improvements */
@media (max-width: 991px) {
    .navbar-collapse {
        background: rgba(162, 194, 232, 0.95); /* Background mobile menu disesuaikan pastel */
        border-radius: 10px;
        margin-top: 1rem;
        padding: 1rem;
    }
    
    .navbar-nav .nav-link {
        padding: 0.75rem 1rem !important;
        margin: 0.2rem 0;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-sticky" style="background: #A2C2E8 !important; padding: 1rem 0;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo $basePath; ?>index.php" style="font-size: 1.3rem; letter-spacing: 1px;">
            <img src="<?php echo $basePath; ?>assets/img/LOGO SI-BAGO.png" 
                 alt="SI-BAGO" 
                 style="height: 80px; 
                        width: auto; 
                        margin-right: 10px; 
                        padding: 5px;
                        border-radius: 8px;">
            <span>SI-BAGO</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border-color: #2C3E50;">
            <span class="navbar-toggler-icon" style="filter: invert(20%);"></span> </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                // Get current page
                $currentPage = basename($_SERVER['PHP_SELF']);
                $currentSlug = $_GET['slug'] ?? '';
                
                // Fetch menus from database
                $menus = $conn->query("SELECT slug, judul FROM menu ORDER BY id");
                
                if ($menus && $menus->num_rows > 0) {
                    while ($menu = $menus->fetch_assoc()) {
                        $menuSlug = $menu['slug'];
                        $menuJudul = htmlspecialchars($menu['judul']);
                        
                        // Determine if this menu is active
                        $isActive = ($currentSlug === $menuSlug) ? 'active' : '';
                        
                        // Build correct URL based on current location
                        $menuUrl = $basePath . 'menu/view_menu.php?slug=' . $menuSlug;
                        
                        echo "<li class='nav-item'>
                                <a class='nav-link {$isActive}' href='{$menuUrl}'>
                                    {$menuJudul}
                                </a>
                              </li>";
                    }
                } else {
                    // Fallback if no menus found
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='{$basePath}index.php'>
                                <i class='fas fa-home'></i> Home
                            </a>
                          </li>";
                }
                ?>
                
                <li class='nav-item'>
                    <a class='nav-link' href='<?php echo $basePath; ?>contact.php'>
                        <i class='fas fa-envelope'></i> Kontak
                    </a>
                </li>
                
                <?php if (isset($_SESSION['admin'])): ?>
                <li class='nav-item'>
                    <a class='nav-link' href='<?php echo $basePath; ?>admin/dashboard.php'>
                        <i class='fas fa-tachometer-alt'></i> Dashboard
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='<?php echo $basePath; ?>admin/logout.php'>
                        <i class='fas fa-sign-out-alt'></i> Logout
                    </a>
                </li>
                <?php else: ?>
                <li class='nav-item'>
                    <a class='nav-link' href='<?php echo $basePath; ?>admin/login.php'>
                        <i class='fas fa-sign-in-alt'></i> Admin
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
// Sticky navbar with scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar-sticky');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Close mobile menu when clicking a link
const navbarCollapseEl = document.querySelector('.navbar-collapse');
const bsCollapseInstance = bootstrap.Collapse.getOrCreateInstance(navbarCollapseEl, { toggle: false });

document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.addEventListener('click', function() {
        if (navbarCollapseEl.classList.contains('show')) {
            bsCollapseInstance.hide();
        }
    });
});

// Highlight current page in navbar
document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
    });
});
</script>