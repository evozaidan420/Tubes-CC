<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Hapus semua data dari tabel inventaris
$stmt = $pdo->prepare("DELETE FROM inventaris");
$stmt->execute();

// Reset auto increment
$stmt = $pdo->prepare("ALTER TABLE inventaris AUTO_INCREMENT = 1");
$stmt->execute();

// Redirect ke dashboard setelah menghapus semua data
header("Location: admin_dashboard.php");
exit();
?>