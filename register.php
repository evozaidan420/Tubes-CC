<?php
session_start();
include 'db.php';

// Aktifkan error (sementara) untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if ($username != "" && $password != "" && $role != "") {

        // Cek apakah username sudah ada
        $check = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $check->bindParam(':username', $username);
        $check->execute();

        if ($check->rowCount() > 0) {
            $error = "Username sudah digunakan, silakan pilih username lain.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) 
                                   VALUES (:username, :password, :role)");

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = "Registrasi gagal! Terjadi kesalahan server.";
            }
        }
    } else {
        $error = "Semua field wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- CSS yang kamu buat, tidak saya ubah -->
    <style>
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        display: flex;
        align-items: center;
        padding: 20px;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        text-align: center;
        padding: 2rem 1rem;
        border-bottom: none;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        transform: translateY(-2px);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.2);
        background: linear-gradient(135deg, #0056b3, #004094);
    }

    .alert {
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .login-link {
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .login-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .password-toggle {
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: #007bff;
    }

    @media (max-width: 576px) {
        .card {
            margin: 0;
        }

        .btn-primary {
            width: 100%;
        }
    }
    </style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h3 mb-0">Form Registrasi</h2>
                        <p class="mb-0 mt-2 text-light">Silakan daftar untuk membuat akun baru</p>
                    </div>
                    <div class="card-body p-4">

                        <!-- Tampilkan error -->
                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php endif; ?>

                        <form method="post" action="" class="needs-validation" novalidate>

                            <div class="mb-4">
                                <label for="username" class="form-label">
                                    <i class="bi bi-person-fill me-2"></i>Username
                                </label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="invalid-feedback">
                                    Mohon masukkan username.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock-fill me-2"></i>Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <i class="bi bi-eye-slash password-toggle" id="togglePassword"></i>
                                </div>
                                <div class="invalid-feedback">
                                    Mohon masukkan password.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label">
                                    <i class="bi bi-person-badge-fill me-2"></i>Role
                                </label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" selected disabled>Pilih role</option>
                                    <option value="user">Pengguna Biasa</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <div class="invalid-feedback">
                                    Mohon pilih role.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <i class="bi bi-person-plus-fill me-2"></i>Registrasi
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">
                                Sudah punya akun?
                                <a href="login.php" class="login-link">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Login di sini
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Toggle password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Loading button
        form.addEventListener('submit', function() {
            if (form.checkValidity()) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                submitBtn.disabled = true;
            }
        });
    });
    </script>

</body>

</html>