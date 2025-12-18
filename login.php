<!-- <?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan peran
        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?> -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body.login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Source Sans 3', sans-serif;
        }

        .login-box {
            width: 400px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo a {
            color: white;
            font-size: 2.5rem;
            text-decoration: none;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .login-logo i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: white;
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2.5rem;
        }

        .login-box-msg {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            position: relative;
            text-align: center;
        }

        .login-box-msg::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #fff, transparent);
            margin: 1rem auto 0;
        }

        .input-group {
            margin-bottom: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .form-control {
            border: none;
            padding: 0.8rem 1.2rem;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: white;
            box-shadow: none;
            transform: translateX(5px);
        }

        .input-group-text {
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #666;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-group-text {
            background: white;
            color: #007bff;
        }

        .btn-primary {
            padding: 0.8rem 2rem;
            background: linear-gradient(45deg, #007bff, #00c6ff);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,123,255,0.5);
            background: linear-gradient(45deg, #0056b3, #007bff);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .form-check {
            padding-left: 2rem;
        }

        .form-check-input {
            border-color: rgba(255,255,255,0.5);
        }

        .form-check-label {
            color: white;
        }

        .register-link {
            color: white;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
        }

        .register-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: white;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .register-link:hover::after {
            transform: scaleX(1);
        }

        .error {
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            text-align: center;
            backdrop-filter: blur(5px);
            animation: fadeInUp 0.5s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-box {
                width: 90%;
                padding: 0 1rem;
            }

            .login-logo a {
                font-size: 2rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .btn-primary {
                padding: 0.6rem 1.5rem;
            }
        }

        /* Loading Animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255,255,255,0.5);
            border-top-color: white;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }
    </style>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <i class="bi bi-shield-lock"></i>
            <a href="#">Welcome To <span class="fw-normal">System Inventaris Manajemen Berbasis Web</span></a>
        </div>

        <div class="card">
            <div class="card-body">
                <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

                <?php if (isset($error)): ?>
                    <div class="error">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="" id="loginForm">
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Username" required>
                        <div class="input-group-text">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <div class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Login <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>

                <p class="text-center mb-0">
                    <a href="register.php" class="register-link">
                        Belum punya akun? Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.classList.add('btn-loading');
            button.innerHTML = '';
        });

        // Add focus animation to input groups
        document.querySelectorAll('.input-group').forEach(group => {
            const input = group.querySelector('.form-control');
            const icon = group.querySelector('.input-group-text i');

            input.addEventListener('focus', () => {
                icon.style.transform = 'scale(1.2)';
            });

            input.addEventListener('blur', () => {
                icon.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>