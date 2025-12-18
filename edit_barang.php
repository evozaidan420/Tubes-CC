<!-- <?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM inventaris WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $pdo->prepare("UPDATE inventaris SET nama_barang = :nama_barang, jumlah = :jumlah, deskripsi = :deskripsi WHERE id = :id");
    $stmt->bindParam(':nama_barang', $nama_barang);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?> -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            padding: 20px;
        }

        .edit-container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .edit-container:hover {
            transform: translateY(-5px);
        }

        .edit-header {
            background: linear-gradient(135deg, #2575fc, #1e5bbf);
            color: white;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-content {
            padding: 0 2rem 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #2575fc;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 0 0.25rem rgba(37, 117, 252, 0.15);
            transform: translateY(-2px);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-update {
            background: linear-gradient(135deg, #2575fc, #1e5bbf);
            border: none;
            color: white;
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(37, 117, 252, 0.2);
            background: linear-gradient(135deg, #1e5bbf, #164392);
        }

        .btn-secondary, .btn-danger {
            border: none;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-danger {
            background: #dc3545;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .edit-container {
                margin: 0;
            }

            .edit-header {
                padding: 1.5rem;
            }

            .form-content {
                padding: 0 1rem 1rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }
        }

        .loading-spinner {
            display: none;
            margin-right: 0.5rem;
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

        .alert {
            animation: slideDown 0.3s ease-out;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-container">
            <div class="edit-header">
                <h2 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Barang
                </h2>
            </div>
            
            <div class="form-content">
                <form method="post" action="" id="editForm">
                    <div class="mb-4">
                        <label for="nama_barang" class="form-label">
                            <i class="bi bi-box-seam"></i>
                            Nama Barang
                        </label>
                        <input type="text" 
                               id="nama_barang" 
                               name="nama_barang" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($item['nama_barang']); ?>" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="jumlah" class="form-label">
                            <i class="bi bi-123"></i>
                            Jumlah
                        </label>
                        <input type="number" 
                               id="jumlah" 
                               name="jumlah" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($item['jumlah']); ?>" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">
                            <i class="bi bi-card-text"></i>
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" 
                                  name="deskripsi" 
                                  class="form-control" 
                                  rows="4" 
                                  required><?php echo htmlspecialchars($item['deskripsi']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-update" id="updateBtn">
                        <span class="spinner-border spinner-border-sm loading-spinner" role="status"></span>
                        <i class="bi bi-check2-circle me-2"></i>Update
                    </button>

                    <div class="action-buttons">
                        <a href="admin_dashboard.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle me-2"></i>Kembali
                        </a>
                        <a href="logout.php" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editForm');
            const updateBtn = document.getElementById('updateBtn');
            const spinner = document.querySelector('.loading-spinner');

            form.addEventListener('submit', function(e) {
                if (form.checkValidity()) {
                    // Show loading state
                    updateBtn.disabled = true;
                    spinner.style.display = 'inline-block';
                    updateBtn.querySelector('i').style.display = 'none';
                    updateBtn.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Memperbarui...
                    `;
                }
            });

            // Add floating label effect
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });

                // Set initial state
                if (input.value) {
                    input.parentElement.classList.add('focused');
                }
            });
        });
    </script>
</body>
</html>