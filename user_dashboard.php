<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Ambil semua data inventaris
$stmt = $pdo->prepare("SELECT * FROM inventaris WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$inventaris = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total barang dan total nilai
$total_barang = 0;
$total_nilai = 0;
$last_update = null;

foreach ($inventaris as $item) {
    $total_barang += $item['jumlah'];
    $total_nilai += $item['harga'] * $item['jumlah'];
    if ($last_update === null || $item['updated_at'] > $last_update) {
        $last_update = $item['updated_at'];
    }
}
?>  

<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Dashboard Pengguna</title>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #007bff, #0056b3);
            --card-bg-light: #ffffff;
            --card-bg-dark: #2d3748;
            --transition-speed: 0.3s;
        }

        [data-bs-theme="dark"] {
            --primary-gradient: linear-gradient(135deg, #3182ce, #2c5282);
            color-scheme: dark;
        }

        body {
            min-height: 100vh;
            background-color: var(--bs-body-bg);
            transition: background-color var(--transition-speed);
        }

        .navbar {
            background: var(--primary-gradient);
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white !important;
        }

        .nav-link {
            position: relative;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: white;
            transition: width var(--transition-speed);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .theme-toggle {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all var(--transition-speed);
        }

        .theme-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .welcome-section {
            position: relative;
            padding: 3rem 0;
            background: var(--primary-gradient);
            color: white;
            margin-bottom: 2rem;
            border-radius: 0 0 2rem 2rem;
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            bottom: -2rem;
            left: 50%;
            transform: translateX(-50%);
            width: 4rem;
            height: 4rem;
            background: inherit;
            border-radius: 1rem;
            rotate: 45deg;
            z-index: -1;
        }

        .card-dashboard {
            border: none;
            border-radius: 1rem;
            background: var(--bs-body-bg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .dashboard-button {
            position: relative;
            overflow: hidden;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all var(--transition-speed);
            z-index: 1;
        }

        .dashboard-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            z-index: -1;
            transition: opacity var(--transition-speed);
            opacity: 0;
        }

        .dashboard-button:hover::before {
            opacity: 1;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: var(--bs-body-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .welcome-section {
                border-radius: 0 0 1rem 1rem;
                padding: 2rem 0;
            }

            .navbar-brand {
                font-size: 1.25rem;
            }

            .quick-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
</div>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-grid-fill me-2"></i>Dashboard Pengguna
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <div class="theme-toggle me-3" id="themeToggle">
                            <i class="bi bi-sun-fill theme-icon-light"></i>
                            <i class="bi bi-moon-fill theme-icon-dark d-none"></i>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="welcome-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-3">Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
                    <p class="lead mb-0">Kelola inventaris Anda dengan mudah dan efisien.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="quick-stats">
        <div class="stat-card">
            <h3 class="h5 mb-3">Total Barang</h3>
            <p class="h2 mb-0"><?php echo $total_barang; ?></p>
        </div>
    <div class="stat-card">
        <h3 class="h5 mb-3">Total Nilai</h3>
        <p class="h2 mb-0">Rp <?php echo number_format($total_nilai, 2, ',', '.'); ?></p>
    </div>
    <div class="stat-card">
        <h3 class="h5 mb-3">Update Terakhir</h3>
        <p class="h2 mb-0"><?php echo $last_update ? date('d-m-Y H:i:s', strtotime($last_update)) : '-'; ?></p>
    </div>


        <div class="card card-dashboard">
            <div class="card-body p-4">
                <div class="row g-4 text-center">
                    <div class="col-md-6">
                        <a href="tambah.php" class="btn btn-primary dashboard-button w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>Tambah Barang
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="lihat_inventaris.php" class="btn btn-info dashboard-button w-100">
                            <i class="bi bi-list-ul me-2"></i>Lihat Inventaris
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            const lightIcon = themeToggle.querySelector('.theme-icon-light');
            const darkIcon = themeToggle.querySelector('.theme-icon-dark');

            // Check for saved theme preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                html.setAttribute('data-bs-theme', savedTheme);
                updateThemeIcon(savedTheme);
            }

            themeToggle.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIcon(newTheme);
            });

            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    lightIcon.classList.add('d-none');
                    darkIcon.classList.remove('d-none');
                } else {
                    lightIcon.classList.remove('d-none');
                    darkIcon.classList.add('d-none');
                }
            }
        });
    </script>
</body>
</html>