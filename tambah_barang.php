<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $user_id = $_SESSION['user_id']; // ID pengguna yang menambah barang

    // Siapkan dan eksekusi pernyataan untuk menyimpan data
    $stmt = $pdo->prepare("INSERT INTO inventaris (nama_barang, jumlah, deskripsi, harga, user_id) VALUES (:nama_barang, :jumlah, :deskripsi, :harga, :user_id)");
    $stmt->bindParam(':nama_barang', $nama_barang);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        // Redirect ke halaman dashboard setelah menambahkan barang
        header("Location: admin_dashboard.php?success=1");
        exit();
    } else {
        $error = "Terjadi kesalahan saat menambahkan barang.";
    }
}
?>