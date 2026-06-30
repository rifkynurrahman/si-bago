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
    $stmt = $conn->prepare("DELETE FROM penyusun WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: penyusun.php");
    exit;
}

// Handle add/edit
$message = '';
if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $bio = trim($_POST['bio']);
    $foto = '';

    // Handle file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/img/penyusun/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $foto = 'assets/img/penyusun/' . $new_filename;
            } else {
                $message = "Gagal upload foto!";
            }
        } else {
            $message = "Format file tidak didukung! Gunakan JPG, PNG, atau GIF.";
        }
    }

    if (empty($message)) {
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            // Update existing
            $id = $_POST['edit_id'];
            if (!empty($foto)) {
                $stmt = $conn->prepare("UPDATE penyusun SET nama = ?, foto = ?, bio = ? WHERE id = ?");
                $stmt->bind_param("sssi", $nama, $foto, $bio, $id);
            } else {
                $stmt = $conn->prepare("UPDATE penyusun SET nama = ?, bio = ? WHERE id = ?");
                $stmt->bind_param("ssi", $nama, $bio, $id);
            }
        } else {
            // Add new
            if (!empty($nama) && !empty($bio)) {
                $stmt = $conn->prepare("INSERT INTO penyusun (nama, foto, bio) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $nama, $foto, $bio);
            } else {
                $message = "Nama dan bio harus diisi!";
            }
        }

        if (empty($message) && $stmt->execute()) {
            header("Location: penyusun.php?success=1");
            exit;
        } else {
            $message = "Gagal menyimpan data!";
        }
    }
}

// Get penyusun for editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM penyusun WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Penyusun - SI-BAGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Kelola Penyusun SI-BAGO</h2>
            <div>
                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPenyusunModal">
                    <i class="fas fa-plus"></i> Tambah Penyusun
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penyusun telah disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php
            $q = $conn->query("SELECT * FROM penyusun ORDER BY created_at DESC");
            if ($q && $q->num_rows > 0) {
                while ($p = $q->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>
                        <div class='card h-100'>
                            <div class='card-body text-center'>
                                <img src='../" . ($p['foto'] ?: 'assets/img/default-avatar.png') . "' class='rounded-circle mb-3' style='width: 100px; height: 100px; object-fit: cover;' alt='Foto {$p['nama']}'>
                                <h6 class='card-title'>{$p['nama']}</h6>
                                <p class='card-text small text-muted'>" . substr($p['bio'], 0, 100) . "...</p>
                                <div class='btn-group'>
                                    <a href='penyusun.php?edit={$p['id']}' class='btn btn-sm btn-primary'>Edit</a>
                                    <a href='penyusun.php?delete={$p['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<div class='col-12'>
                    <div class='alert alert-info text-center'>
                        <h5>Belum ada data penyusun</h5>
                        <p>Klik tombol 'Tambah Penyusun' untuk menambah data penyusun pertama.</p>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>

    <!-- Modal Tambah/Edit Penyusun -->
    <div class="modal fade" id="addPenyusunModal" tabindex="-1" aria-labelledby="addPenyusunModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPenyusunModalLabel">
                        <?php echo $edit_data ? 'Edit Penyusun' : 'Tambah Penyusun Baru'; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="edit_id" value="<?php echo $edit_data['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                   value="<?php echo $edit_data['nama'] ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Penyusun</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <small class="form-text text-muted">
                                Format: JPG, PNG, GIF. Maksimal 2MB.
                                <?php if ($edit_data && $edit_data['foto']): ?>
                                    <br>Abaikan jika tidak ingin mengubah foto.
                                <?php endif; ?>
                            </small>
                            <?php if ($edit_data && $edit_data['foto']): ?>
                                <div class="mt-2">
                                    <img src="../<?php echo $edit_data['foto']; ?>" style="width: 100px; height: 100px; object-fit: cover;" class="rounded">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biografi</label>
                            <textarea class="form-control" id="bio" name="bio" rows="6" required><?php echo $edit_data['bio'] ?? ''; ?></textarea>
                            <small class="form-text text-muted">Deskripsikan latar belakang, pengalaman, dan kontribusi penyusun.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan" class="btn btn-success">
                            <?php echo $edit_data ? 'Update' : 'Tambah'; ?> Penyusun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-show modal if editing
        <?php if ($edit_data): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('addPenyusunModal'));
                modal.show();
            });
        <?php endif; ?>
    </script>
</body>
</html>