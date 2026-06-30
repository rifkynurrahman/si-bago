<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$upload_dir = 'assets/img/uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$response = ['success' => false];

// CEK APAKAH MULTIPLE FILES
if (isset($_FILES['foto']) && is_array($_FILES['foto']['name'])) {
    // MULTIPLE FILES
    $uploaded_files = [];
    $file_count = count($_FILES['foto']['name']);
    
    for ($i = 0; $i < $file_count; $i++) {
        if ($_FILES['foto']['error'][$i] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['foto']['tmp_name'][$i];
            $file_name = $_FILES['foto']['name'][$i];
            $file_size = $_FILES['foto']['size'][$i];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (!in_array($file_ext, $allowed)) {
                $uploaded_files[] = [
                    'success' => false,
                    'message' => "Format file $file_name tidak didukung"
                ];
                continue;
            }
            
            if ($file_size > 5 * 1024 * 1024) {
                $uploaded_files[] = [
                    'success' => false,
                    'message' => "File $file_name terlalu besar (max 5MB)"
                ];
                continue;
            }
            
            $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
            $destination = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file_tmp, $destination)) {
                $uploaded_files[] = [
                    'success' => true,
                    'filename' => $new_filename,
                    'path' => $destination
                ];
            } else {
                $uploaded_files[] = [
                    'success' => false,
                    'message' => "Gagal upload $file_name"
                ];
            }
        }
    }
    
    $response = [
        'success' => true,
        'files' => $uploaded_files,
        'message' => count($uploaded_files) . ' file diproses'
    ];
    
} else {
    // SINGLE FILE (backward compatibility)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_ext, $allowed)) {
            if ($file_size <= 5 * 1024 * 1024) {
                $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
                $destination = $upload_dir . $new_filename;
                
                if (move_uploaded_file($file_tmp, $destination)) {
                    $response = [
                        'success' => true,
                        'filename' => $new_filename,
                        'path' => $destination,
                        'message' => 'Upload berhasil'
                    ];
                } else {
                    $response['message'] = 'Gagal memindahkan file';
                }
            } else {
                $response['message'] = 'File terlalu besar (max 5MB)';
            }
        } else {
            $response['message'] = 'Format file tidak didukung';
        }
    } else {
        $response['message'] = 'Tidak ada file yang diupload';
    }
}

echo json_encode($response);