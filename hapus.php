<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM inventaris WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: index.php");
?>