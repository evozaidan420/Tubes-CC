<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Cek apakah ID barang ada di URL
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];

// Siapkan dan eksekusi pernyataan untuk menghapus data
$stmt = $pdo->prepare("DELETE FROM inventaris WHERE id = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    // Redirect ke halaman dashboard setelah menghapus barang
    header("Location: admin_dashboard.php");
    exit();
} else {
    // Tangani kesalahan
    echo "Error: " . $stmt->errorInfo()[2];
}
?>