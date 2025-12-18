<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Ambil inventaris milik user yang sedang login
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM inventaris WHERE user_id = ?");
$stmt->execute([$user_id]);
$inventaris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>

    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
    :root {
        --primary-gradient: linear-gradient(to right, #4CAF50, #45a049);
        --secondary-gradient: linear-gradient(to right, #2196F3, #1976D2);
        --danger-gradient: linear-gradient(to right, #f44336, #d32f2f);
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .navbar {
        background: var(--primary-gradient);
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        color: white !important;
        font-weight: 600;
        font-size: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: white !important;
        transform: translateY(-2px);
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin: 2rem 0;
        overflow: hidden;
    }

    .card-header {
        background: var(--secondary-gradient);
        color: white;
        padding: 1.5rem;
        font-size: 1.25rem;
        font-weight: 600;
        border: none;
    }

    .card-body {
        padding: 2rem;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px 12px;
        margin-left: 8px;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 6px 8px;
    }

    table.dataTable thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 15px;
        border-bottom: 2px solid #dee2e6;
    }

    table.dataTable tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
        transition: background-color 0.2s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        table.dataTable {
            font-size: 0.9rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 120px;
        }

        .navbar-brand {
            font-size: 1.2rem;
        }
    }

    /* Loading Spinner */
    .spinner-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
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

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-warehouse me-2"></i>
                Inventory Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user_dashboard.php">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-boxes me-2"></i>
                Daftar Inventaris
            </div>
            <div class="card-body">
                <table id="inventarisTable" class="table table-hover table-bordered w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventaris as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['nama_barang']; ?></td>
                            <td><?php echo $item['jumlah']; ?></td>
                            <td><?php echo $item['deskripsi']; ?></td>
                            <td><?php echo number_format($item['harga'], 2, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        // Hide loading spinner
        $('#loadingSpinner').fadeOut();

        // Initialize DataTable
        $('#inventarisTable').DataTable({
            responsive: true,
            language: {
                search: "Pencarian:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            order: [
                [0, 'asc']
            ]
        });
    });
    </script>
</body>

</html>