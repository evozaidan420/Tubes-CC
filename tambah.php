<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Cek peran pengguna
$isAdmin = $_SESSION['role'] == 'admin';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    // Bersihkan format harga "1.000.000" → "1000000"
    $harga = str_replace('.', '', $_POST['harga']);

    $user_id = $_SESSION['user_id'];

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO inventaris (nama_barang, jumlah, deskripsi, harga, user_id) 
                           VALUES (:nama_barang, :jumlah, :deskripsi, :harga, :user_id)");
    $stmt->bindParam(':nama_barang', $nama_barang);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    if ($isAdmin) {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Tambah Barang</title>

    <style>
    body {
        background: linear-gradient(120deg, #f3f4f6, #d7e1ec);
        min-height: 100vh;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-radius: calc(1rem - 1px) calc(1rem - 1px) 0 0 !important;
    }

    .form-control {
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.2);
    }

    .form-control.is-invalid {
        animation: shake 0.5s;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-10px);
        }

        75% {
            transform: translateX(10px);
        }
    }

    .btn {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    </style>
</head>

<body class="bg-light">
    <div class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header text-white text-center py-3">
                        <h4 class="fw-bold mb-0">
                            <i class="bi bi-box-seam me-2"></i>Tambah Barang
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <form id="barangForm" method="post" class="needs-validation" novalidate>

                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                <label for="nama_barang">Nama Barang</label>
                                <div class="invalid-feedback">Nama barang harus diisi</div>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1">
                                <label for="jumlah">Jumlah</label>
                                <div class="invalid-feedback">Jumlah harus valid</div>
                            </div>

                            <div class="form-floating mb-4">
                                <textarea class="form-control" id="deskripsi" name="deskripsi" style="height: 100px"
                                    required></textarea>
                                <label for="deskripsi">Deskripsi</label>
                                <div class="invalid-feedback">Deskripsi harus diisi</div>
                            </div>

                            <!-- Harga dibuat TEXT supaya titik tidak error -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" id="harga" name="harga" required>
                                <label for="harga">Harga</label>
                                <div class="invalid-feedback">Harga harus valid</div>
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="bi bi-save me-2"></i>
                                    <span class="button-text">Simpan</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                </button>

                                <?php if ($isAdmin): ?>
                                <a href="admin_dashboard.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Dashboard Admin
                                </a>
                                <?php else: ?>
                                <a href="user_dashboard.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Dashboard User
                                </a>
                                <?php endif; ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('barangForm');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        const buttonText = submitBtn.querySelector('.button-text');
        const loadingOverlay = document.querySelector('.loading-overlay');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                submitBtn.disabled = true;
                buttonText.textContent = 'Menyimpan...';
                spinner.classList.remove('d-none');
                loadingOverlay.style.display = 'flex';
            }
            form.classList.add('was-validated');
        });

        // Input harga format Indonesia (1.000.000)
        const hargaInput = document.getElementById('harga');

        hargaInput.addEventListener('input', function() {
            let val = this.value.replace(/[^0-9]/g, '');

            if (val === '') {
                this.value = '';
                return;
            }

            let num = parseInt(val, 10);
            this.value = num.toLocaleString('id-ID');
        });

    });
    </script>

</body>

</html>