<?php
session_start();
include 'db.php';

// Ambil data inventaris
$stmt = $pdo->query("SELECT * FROM inventaris");
$inventaris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sistem Manajemen Inventaris</title>
</head>
<body>
    <h1>Daftar Inventaris</h1>
    <a href="tambah.php">Tambah Barang</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($inventaris as $item): ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['nama_barang']; ?></td>
            <td><?php echo $item['jumlah']; ?></td>
            <td><?php echo $item['deskripsi']; ?></td>
            <td>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="edit.php?id=<?php echo $item['id']; ?>">Edit</a> |
                    <a href="hapus.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">Hapus</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>