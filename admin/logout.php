<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2;url=../index.php">
    <title>Logout - SI-BAGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            /* ─── UBAH BACKGROUND MENJADI GRADASI BIRU SOFT SEJUK ─── */
            background: linear-gradient(135deg, #A2C2E8 0%, #7AA0CD 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .logout-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(44, 62, 80, 0.15);
            max-width: 400px;
            border: none;
        }
        
        .logout-icon {
            font-size: 4rem;
            /* ─── UBAH WARNA ICON CHECK MENJADI BIRU AGAR SERASI ─── */
            color: #7AA0CD;
            margin-bottom: 1rem;
            animation: checkmark 0.5s ease-in-out;
        }
        
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        /* ─── KUSTOMISASI WARNA SPINNER LOADING ─── */
        .spinner-border {
            margin-top: 1rem;
            color: #7AA0CD !important;
        }

        h3 {
            color: #2C3E50;
            font-weight: 700;
        }

        a {
            color: #7AA0CD;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            color: #2C3E50;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logout-card">
        <i class="fas fa-check-circle logout-icon"></i>
        <h3 class="mb-3">Logout Berhasil!</h3>
        <p class="text-muted mb-3">Anda telah keluar dari sistem.</p>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-muted small mt-3">
            Mengalihkan ke halaman utama dalam 2 detik...<br>
            <a href="../index.php">Klik di sini</a> jika tidak otomatis redirect.
        </p>
    </div>

    <script>
        // Redirect after 2 seconds
        setTimeout(function() {
            window.location.href = '../index.php';
        }, 2000);
    </script>
</body>
</html>