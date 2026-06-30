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
            background: linear-gradient(135deg, #F7931E 0%, #fa9911  100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logout-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 400px;
        }
        
        .logout-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
            animation: checkmark 0.5s ease-in-out;
        }
        
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .spinner-border {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="logout-card">
        <i class="fas fa-check-circle logout-icon"></i>
        <h3 class="mb-3">Logout Berhasil!</h3>
        <p class="text-muted mb-3">Anda telah keluar dari sistem.</p>
        <div class="spinner-border text-primary" role="status">
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
