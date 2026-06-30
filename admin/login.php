<?php
session_start();
include '../config/database.php';

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$message = '';
$messageType = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['user']);
    $password = md5(trim($_POST['pass']));

    if (empty($username) || empty($_POST['pass'])) {
        $message = "Username dan password harus diisi!";
        $messageType = "danger";
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Username atau password salah!";
            $messageType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SI-BAGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #e2eaf4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(44, 62, 80, 0.15);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        /* Mengubah header login menjadi Biru Soft */
        .login-header {
            background: linear-gradient(135deg, #A2C2E8 0%, #7AA0CD 100%);
            color: #2C3E50; /* Teks diubah gelap agar kontras */
            padding: 2rem;
            text-align: center;
        }
        
        .login-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #2C3E50;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
        }
        
        /* Focus border diubah menjadi senada biru soft */
        .form-control:focus {
            border-color: #7AA0CD;
            box-shadow: 0 0 0 0.2rem rgba(122, 160, 205, 0.25);
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #7AA0CD;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        /* Tombol login diubah menjadi gradasi Biru Soft pekat modern */
        .btn-login {
            background: linear-gradient(45deg, #7AA0CD, #92B4DC);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: linear-gradient(45deg, #92B4DC, #7AA0CD);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(122, 160, 205, 0.4);
            color: white;
        }
        
        .back-to-home {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        /* Teks diubah ke gelap agar terbaca jelas di background body yang terang */
        .back-to-home a {
            color: #4A5A6A;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-to-home a:hover {
            color: #2C3E50;
            text-decoration: underline;
        }
        
        .default-credentials {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid #7AA0CD;
        }
        
        .default-credentials small {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-user-shield"></i>
                        <h3 class="mb-0 fw-bold">Admin SI-BAGO</h3>
                        <p class="mb-0" style="opacity: 0.85;">Login untuk mengakses dashboard</p>
                    </div>
                    
                    <div class="login-body">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" id="loginForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #2C3E50;">
                                    <i class="fas fa-user"></i> Username
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           name="user" 
                                           class="form-control" 
                                           placeholder="Masukkan username" 
                                           required 
                                           autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" style="color: #2C3E50;">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           name="pass" 
                                           id="password" 
                                           class="form-control" 
                                           placeholder="Masukkan password" 
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            id="togglePassword"
                                            style="border-radius: 0 10px 10px 0; border-color: #e0e0e0; border-left: none;">
                                        <i class="fas fa-eye" style="color: #7AA0CD;"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe" style="color: #4A5A6A;">
                                    Ingat saya
                                </label>
                            </div>
                            
                            <button type="submit" name="login" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="back-to-home">
                    <a href="../index.php">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.querySelector('input[name="user"]').value.trim();
            const pass = document.querySelector('input[name="pass"]').value.trim();
            
            if (!username || !pass) {
                e.preventDefault();
                alert('Username dan password harus diisi!');
            }
        });
    </script>
</body>
</html>