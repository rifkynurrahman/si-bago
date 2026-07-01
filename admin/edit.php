<?php
session_start();
include '../config/database.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

// Decode foto gallery jika ada
$foto_gallery = [];
if (!empty($data['foto'])) {
    $foto_gallery = json_decode($data['foto'], true);
    if (!is_array($foto_gallery)) {
        $foto_gallery = [$data['foto']];
    }
}

$message = '';

if (isset($_POST['simpan'])) {
    $judul = trim($_POST['judul']);
    $konten = trim($_POST['konten']);

    if (empty($judul) || empty($konten)) {
        $message = "Judul dan konten tidak boleh kosong!";
    } else {
        // Handle foto gallery
        $existing_photos = isset($_POST['existing_photos']) ? $_POST['existing_photos'] : [];
        $final_gallery = is_array($existing_photos) ? $existing_photos : [];
        
        $foto_json = json_encode($final_gallery);
        
        $stmt = $conn->prepare("UPDATE menu SET judul = ?, konten = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("sssi", $judul, $konten, $foto_json, $id);
        if ($stmt->execute()) {
            header("Location: dashboard.php?success=1");
            exit;
        } else {
            $message = "Gagal menyimpan perubahan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - SI-BAGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .edit-header {
            /* Mengubah gradasi cokelat menjadi gradasi biru cerah khas SI-BAGO */
            background: linear-gradient(135deg, #7FA9D8 0%, #A2C2E8 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 600;
            color: #4A5568;
        }
        .char-counter {
            font-size: 0.875rem;
            color: #666;
            float: right;
        }
        .btn-save {
            /* Mengubah warna tombol simpan menjadi biru cerah */
            background: linear-gradient(45deg, #4A90E2, #7FA9D8);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            background: linear-gradient(45deg, #357ABD, #4A90E2);
            color: white;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
        }
        
        /* Photo Gallery Styles */
        .upload-area {
            /* Mengubah border putus-putus menjadi warna biru */
            border: 2px dashed #7FA9D8;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #fff;
        }
        
        .upload-area:hover {
            background-color: #f0f7ff;
            border-color: #4A90E2;
        }
        
        .upload-area.dragover {
            background-color: #e1f0ff;
            border-color: #4A90E2;
        }
        
        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .photo-item {
            position: relative;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
        }
        
        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .photo-item .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .photo-item:hover .delete-btn {
            opacity: 1;
        }
        
        #preview-container {
            margin-top: 20px;
        }
        
        .preview-image {
            max-width: 150px;
            max-height: 150px;
            margin: 10px;
            border-radius: 8px;
        }
        
        /* Penyesuaian warna teks panduan agar senada dengan warna biru */
        .card.mt-4 {
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="edit-header">
        <div class="container">
            <h2 class="mb-0">
                <i class="fas fa-edit"></i> Edit Menu: <?php echo htmlspecialchars($data['slug']); ?>
            </h2>
            <p class="mb-0 mt-2">Edit konten untuk halaman <strong><?php echo htmlspecialchars($data['judul']); ?></strong></p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if ($message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <form method="post" id="editForm">
                            <div class="mb-4">
                                <label for="judul" class="form-label">
                                    <i class="fas fa-heading"></i> Judul Menu
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="judul" 
                                       name="judul"
                                       value="<?php echo htmlspecialchars($data['judul']); ?>" 
                                       required
                                       placeholder="Masukkan judul menu">
                                <small class="text-muted">Judul akan muncul di navbar dan halaman</small>
                            </div>

                            <div class="mb-4">
                                <label for="konten" class="form-label">
                                    <i class="fas fa-file-alt"></i> Konten
                                    <span class="char-counter">
                                        <span id="charCount">0</span> karakter
                                    </span>
                                </label>
                                <textarea class="form-control" 
                                          id="konten" 
                                          name="konten" 
                                          rows="20" 
                                          required
                                          placeholder="Masukkan konten menu di sini..."><?php echo htmlspecialchars($data['konten']); ?></textarea>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Tips: Gunakan enter untuk membuat paragraf baru. Konten akan otomatis diformat.
                                </small>
                            </div>

                            <!-- Foto Gallery Section -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-images"></i> Galeri Foto
                                </label>
                                
                                <!-- Upload Area -->
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Klik atau Drag & Drop untuk Upload Foto</h5>
                                    <p class="text-muted">JPG, PNG, GIF, WEBP (Maks. 5MB)</p>
                                    <input type="file" id="fotoInput" accept="image/*" multiple style="display: none;">
                                    <button type="button" class="btn btn-save mt-2" onclick="document.getElementById('fotoInput').click()">
                                        <i class="fas fa-plus me-2"></i>Pilih Foto
                                    </button>
                                </div>

                                <!-- Preview Upload -->
                                <div id="preview-container"></div>

                                <!-- Existing Photos -->
                                <?php if (!empty($foto_gallery)): ?>
                                    <div class="mt-3">
                                        <h6>Foto yang sudah ada:</h6>
                                        <div class="photo-gallery" id="photoGallery">
                                            <?php foreach ($foto_gallery as $index => $foto): ?>
                                                <div class="photo-item" data-index="<?= $index ?>">
                                                    <img src="../assets/img/uploads/<?= htmlspecialchars($foto) ?>" alt="Foto">
                                                    <button type="button" class="delete-btn" onclick="deletePhoto(<?= $index ?>)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <input type="hidden" name="existing_photos[]" value="<?= htmlspecialchars($foto) ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Hidden input for new uploaded photos -->
                            <div id="newPhotosContainer"></div>

                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb"></i> 
                                <strong>Informasi:</strong> Slug <code><?php echo htmlspecialchars($data['slug']); ?></code> tidak dapat diubah karena terhubung dengan sistem.
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="dashboard.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <div>
                                    <!-- <button type="reset" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-undo"></i> Reset
                                    </button> -->
                                    <button type="submit" name="simpan" class="btn btn-save">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="card mt-4 border-0" style="background: linear-gradient(135deg, rgba(74,144,226,0.05) 0%, rgba(162,194,232,0.1) 100%); border-radius: 15px;">
                     <div class="card-body">
                        <h6 class="fw-bold" style="color: #357ABD;">
                            <i class="fas fa-question-circle"></i> Panduan Edit Konten
                        </h6>
                        <ul class="mb-0 small">
                            <li>Tekan <kbd>Enter</kbd> untuk membuat paragraf baru</li>
                            <li>Konten akan otomatis di-format saat ditampilkan</li>
                            <li>Pastikan tidak ada tag HTML untuk keamanan</li>
                            <li>Simpan secara berkala untuk menghindari kehilangan data</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Character counter
        const kontenTextarea = document.getElementById('konten');
        const charCount = document.getElementById('charCount');
        
        function updateCharCount() {
            if (kontenTextarea && charCount) {
                charCount.textContent = kontenTextarea.value.length.toLocaleString();
            }
        }
        
        if (kontenTextarea) {
            kontenTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        }
        
        // Confirm before leaving if form is dirty
        let formDirty = false;
        const form = document.getElementById('editForm');
        
        if (form) {
            form.addEventListener('change', () => {
                formDirty = true;
            });
            
            window.addEventListener('beforeunload', (e) => {
                if (formDirty) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
            
            form.addEventListener('submit', () => {
                formDirty = false;
            });
        }
        
        // ===== PHOTO UPLOAD FUNCTIONALITY (BATCH UPLOAD) =====
        const uploadArea = document.getElementById('uploadArea');
        const fotoInput = document.getElementById('fotoInput');
        const previewContainer = document.getElementById('preview-container');
        const newPhotosContainer = document.getElementById('newPhotosContainer');
        let uploadedFiles = [];

        if (uploadArea && fotoInput && previewContainer && newPhotosContainer) {
            // Drag & Drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                const files = e.dataTransfer.files;
                handleFiles(files);
            });

            // File input change
            fotoInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
            });

            // Handle files - Upload sekaligus (BATCH)
            function handleFiles(files) {
                const validFiles = [];
                
                // Validasi dulu semua file
                for (let file of files) {
                    if (!file.type.startsWith('image/')) {
                        alert(`File ${file.name} bukan gambar!`);
                        continue;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        alert(`File ${file.name} terlalu besar! Maksimal 5MB`);
                        continue;
                    }

                    validFiles.push(file);
                }

                // Upload semua file valid sekaligus
                if (validFiles.length > 0) {
                    uploadMultipleFiles(validFiles);
                }
            }

            // Upload BANYAK file sekaligus dengan Progress Bar
            function uploadMultipleFiles(files) {
                const formData = new FormData();
                
                // Tambahkan semua file ke FormData
                files.forEach((file) => {
                    formData.append('foto[]', file); // Pakai array
                });

                // Show loading dengan progress bar
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'text-center my-3';
                loadingDiv.innerHTML = `
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Mengupload ${files.length} foto...</p>
                    <div class="progress mt-2" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: 0%" id="uploadProgress">0%</div>
                    </div>
                `;
                previewContainer.appendChild(loadingDiv);
                previewContainer.style.display = 'block';

                // Gunakan XMLHttpRequest untuk progress tracking
                const xhr = new XMLHttpRequest();
                
                // Track upload progress
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        const progressBar = document.getElementById('uploadProgress');
                        if (progressBar) {
                            progressBar.style.width = percent + '%';
                            progressBar.textContent = percent + '%';
                        }
                    }
                });
                
                xhr.addEventListener('load', () => {
                    loadingDiv.remove();
                    
                    if (xhr.status === 200) {
                        try {
                            const data = JSON.parse(xhr.responseText);
                            
                            if (data.success && data.files) {
                                let successCount = 0;
                                
                                data.files.forEach(fileData => {
                                    if (fileData.success) {
                                        successCount++;
                                        uploadedFiles.push(fileData.filename);
                                        
                                        // Show preview
                                        const img = document.createElement('img');
                                        img.src = '../' + fileData.path;
                                        img.className = 'preview-image';
                                        previewContainer.appendChild(img);
                                        
                                        // Add hidden input
                                        const input = document.createElement('input');
                                        input.type = 'hidden';
                                        input.name = 'existing_photos[]';
                                        input.value = fileData.filename;
                                        newPhotosContainer.appendChild(input);
                                    }
                                });
                                
                                showNotification(`Berhasil upload ${successCount} dari ${files.length} foto!`, 'success');
                            } else {
                                showNotification(data.message || 'Gagal upload foto', 'danger');
                            }
                        } catch (e) {
                            showNotification('Error parsing response', 'danger');
                            console.error('Parse error:', e);
                        }
                    } else {
                        showNotification('Error: Server error (Status ' + xhr.status + ')', 'danger');
                    }
                });
                
                xhr.addEventListener('error', () => {
                    loadingDiv.remove();
                    showNotification('Error saat upload foto', 'danger');
                });
                
                xhr.open('POST', '../upload.php');
                xhr.send(formData);
            }
        } else {
            console.warn('Photo upload elements not found on this page');
        }

        // Delete photo
        function deletePhoto(index) {
            if (confirm('Hapus foto ini?')) {
                const photoItem = document.querySelector(`.photo-item[data-index="${index}"]`);
                if (photoItem) {
                    photoItem.remove();
                    showNotification('Foto akan dihapus setelah simpan perubahan', 'info');
                }
            }
        }

        // Show notification
        function showNotification(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            const container = document.querySelector('.container .row .col-lg-8');
            if (container) {
                container.insertBefore(alertDiv, container.firstChild);
                
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        }
    </script>
</body>
</html>