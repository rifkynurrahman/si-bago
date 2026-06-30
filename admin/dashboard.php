<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}

// Handle add new menu
if (isset($_POST['add_menu'])) {
    $slug = trim($_POST['new_slug']);
    $judul = trim($_POST['new_judul']);
    $konten = trim($_POST['new_konten']);

    if (!empty($slug) && !empty($judul) && !empty($konten)) {
        // Check if slug already exists
        $stmt = $conn->prepare("SELECT id FROM menu WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO menu (slug, judul, konten) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $slug, $judul, $konten);
            if ($stmt->execute()) {
                header("Location: dashboard.php?success=added");
                exit;
            }
        } else {
            $error = "Slug sudah digunakan!";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin SI-BAGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Admin SI-BAGO</h2>
            <div>
                <!-- <a href="penyusun.php" class="btn btn-info me-2"> -->
                    <!-- <i class="fas fa-users"></i> Kelola Penyusun -->
                </a>
                <!-- <a href="logout.php" class="btn btn-danger">Logout</a> -->
            </div>
        </div>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Menu baru telah ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php
        // Debug info
        $menu_count = $conn->query("SELECT COUNT(*) as count FROM menu")->fetch_assoc()['count'];
        $admin_count = $conn->query("SELECT COUNT(*) as count FROM admin")->fetch_assoc()['count'];
        $penyusun_count = $conn->query("SELECT COUNT(*) as count FROM penyusun")->fetch_assoc()['count'];
        ?>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4><?php echo $menu_count; ?></h4>
                        <p class="mb-0">Total Menu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4><?php echo $admin_count; ?></h4>
                        <p class="mb-0">Admin User</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4><?php echo $penyusun_count; ?></h4>
                        <p class="mb-0">Penyusun</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Status Database</h6>
                        <p class="mb-1"><strong>Database:</strong> db_sibago</p>
                        <p class="mb-1"><strong>Status:</strong>
                            <?php
                            if ($conn->connect_error) {
                                echo "<span class='text-danger'>❌ Error: " . $conn->connect_error . "</span>";
                            } else {
                                echo "<span class='text-success'>✅ Connected</span>";
                            }
                            ?>
                        </p>
                        <?php if ($menu_count == 0): ?>
                            <div class="alert alert-warning mt-2">
                                <strong>Perhatian:</strong> Belum ada data menu. <a href="../setup_database.php">Jalankan setup database</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Kelola Konten Menu</h5>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                    <i class="fas fa-plus"></i> Tambah Menu Baru
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Slug</th>
                                <th>Judul</th>
                                <th>Konten (Preview)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q = $conn->query("SELECT * FROM menu ORDER BY id");
                            if ($q && $q->num_rows > 0) {
                                while ($m = $q->fetch_assoc()) {
                                    $preview = substr(strip_tags($m['konten']), 0, 100) . '...';
                                    echo "<tr>
                                        <td>{$m['id']}</td>
                                        <td>{$m['slug']}</td>
                                        <td>{$m['judul']}</td>
                                        <td>{$preview}</td>
                                        <td>";
                                    
                                    // Cek jika slug adalah etnomatematika, sembunyikan tombol Edit & Hapus
                                    if ($m['slug'] == 'etnomatematika') {
                                        echo "<span class='badge bg-secondary'>Hardcode</span>
                                              <small class='d-block text-muted mt-1'>Konten dikelola di kode</small>";
                                    } else {
                                        echo "<a href='edit.php?id={$m['id']}' class='btn btn-sm btn-primary'>Edit</a>
                                              <a href='dashboard.php?delete={$m['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>";
                                    }
                                    
                                    echo "</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted py-4'>
                                    <strong>Tidak ada data menu ditemukan.</strong><br>
                                    <small>Pastikan database sudah di-setup dengan menjalankan <code>setup_database.php</code></small><br>
                                    <a href='../setup_database.php' class='btn btn-sm btn-warning mt-2'>Jalankan Setup Database</a>
                                </td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Menu -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="dashboard.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="new_slug" name="new_slug" required
                                   placeholder="contoh: tentang-kami">
                            <small class="form-text text-muted">Slug digunakan sebagai URL menu (huruf kecil, tanpa spasi)</small>
                        </div>
                        <div class="mb-3">
                            <label for="new_judul" class="form-label">Judul Menu</label>
                            <input type="text" class="form-control" id="new_judul" name="new_judul" required
                                   placeholder="contoh: Tentang Kami">
                        </div>
                        <div class="mb-3">
                            <label for="new_konten" class="form-label">Konten</label>
                            <textarea class="form-control" id="new_konten" name="new_konten" rows="8" required
                                      placeholder="Masukkan konten menu di sini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="add_menu" class="btn btn-success">Tambah Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>