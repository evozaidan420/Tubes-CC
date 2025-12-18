<!-- <?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil semua data inventaris
$stmt = $pdo->query("SELECT * FROM inventaris");
$inventaris = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $user_id = $_SESSION['user_id'];

    // Siapkan dan eksekusi pernyataan untuk menyimpan data
    $stmt = $pdo->prepare("INSERT INTO inventaris (nama_barang, jumlah, deskripsi, harga, user_id) VALUES (:nama_barang, :jumlah, :deskripsi, :harga, :user_id)");
    $stmt->bindParam(':nama_barang', $nama_barang);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Redirect ke halaman dashboard setelah menambahkan barang
    if ($isAdmin) {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}
?> -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" role="alert">
        Barang berhasil ditambahkan!
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4154f1;
            --secondary-color: #717ff5;
            --success-color: #2eca6a;
            --danger-color: #ff4444;
        }

        body {
            background-color: #f6f9ff;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 0.8rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .nav-item .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .dropdown-item {
            padding: 0.7rem 1.5rem;
        }

        .dropdown-item i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            margin: 1rem 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            transition: transform 0.2s;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem;
        }

        .card-title {
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Table Styling */
        .table {
            margin: 0;
        }

        .table th {
            background: #f8f9fa;
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid #ebeef4;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: translateX(5px);
        }

        /* Button Styling */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(65, 84, 241, 0.2);
        }

        .btn-danger {
            background: var(--danger-color);
            border: none;
        }

        .btn-danger:hover {
            background: #ff1111;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 68, 68, 0.2);
        }

        .btn-info {
            background: var(--secondary-color);
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: #8892f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(113, 127, 245, 0.2);
        }

        /* Loading Spinner */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 15px 15px 0 0;
        }

        .modal-title {
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }

            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="loadingSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt me-2"></i>
                Admin Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Inventaris</li>
            </ol>
        </nav>

        <!-- Content Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0 text-gray-800">Daftar Inventaris</h2>
            <div>
                <a href="tambah.php" class="btn btn-primary ">
                <i class="fas fa-plus me-1"></i> Tambah Barang
                </a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusSemuaModal">
                    <i class="fas fa-trash me-1"></i> Hapus Semua
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="card">
            <div class="card-body">
                <table id="inventarisTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventaris as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['nama_barang']; ?></td>
                            <td><?php echo $item['jumlah']; ?></td>
                            <td><?php echo $item['deskripsi']; ?></td>
                            <td>Rp <?php echo number_format($item['harga'], 2, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="editItem(<?php echo $item['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteItem(<?php echo $item['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="hapusSemuaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus semua data inventaris? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="hapus_semua.php" class="btn btn-danger">Hapus Semua</a>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Tambah Barang -->
<div class="card card-dashboard">
            <div class="card-body p-4">
                <div class="row g-4 text-center">
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            // Hide loading spinner
            $('#loadingSpinner').fadeOut();

            // Initialize DataTable
            $('#inventarisTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json'
                },
                pageLength: 10,
                order: [[0, 'asc']]
            });
        });

        // Functions for edit and delete
        function editItem(id) {
            window.location.href = `edit_barang.php?id=${id}`;
        }

        function deleteItem(id) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                window.location.href = `hapus_barang.php?id=${id}`;
            }
        }

        // Add loading animation to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('modal-trigger')) {
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                    this.disabled = true;
                }
            });
        });
    </script>
</body>
</html>