-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Des 2025 pada 03.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inventaris`
--

INSERT INTO `inventaris` (`id`, `nama_barang`, `jumlah`, `deskripsi`, `user_id`, `harga`, `updated_at`) VALUES
(11, 'Printer', 5, 'alat pendukung', 30, 2000000.00, '2025-12-10 22:09:13'),
(12, 'AC', 4, 'pendingin ruangan', 32, 4000000.00, '2025-12-10 22:11:37'),
(13, 'Meja Rapat', 13, 'alat kerja opsional', 32, 1000000.00, '2025-12-10 22:12:21'),
(14, 'Almari Besi', 3, 'furniture', 32, 5000000.00, '2025-12-10 22:13:03'),
(15, 'Komputer', 10, 'alat kerja ', 32, 10000000.00, '2025-12-10 22:13:49'),
(16, 'laptop', 5, 'alat kerja bantu', 32, 5000000.00, '2025-12-10 22:15:46'),
(17, 'Telepon', 2, 'alat komunikasi darurat', 24, 200000.00, '2025-12-10 22:16:28'),
(18, 'Kamera Digital', 2, 'alat dokumentasi', 24, 4000000.00, '2025-12-10 22:17:20'),
(19, 'Handycam', 3, 'aksessoris', 24, 1500000.00, '2025-12-10 22:18:32'),
(20, 'Kipas Angin', 4, 'furniture', 24, 175000.00, '2025-12-10 22:18:59'),
(21, 'Dispenser', 7, 'furniture', 24, 350000.00, '2025-12-10 22:19:38'),
(22, 'Android TV', 2, 'furniture', 24, 2250000.00, '2025-12-10 22:20:09'),
(23, 'WhiteBoard', 5, 'furniture', 24, 150000.00, '2025-12-10 22:21:15'),
(24, 'Vacum Cleaner', 2, 'Alat pembersih', 24, 1250000.00, '2025-12-10 22:22:03'),
(25, 'Earphone ', 4, 'elektronik', 25, 400000.00, '2025-12-10 22:23:09'),
(26, 'Speaker', 2, 'Pengeras suara', 25, 250000.00, '2025-12-10 22:23:32'),
(27, 'Amplifier', 1, 'alat pendukung opsional', 25, 300000.00, '2025-12-10 22:23:56'),
(28, 'Meja Laptop', 5, 'furniture', 25, 100000.00, '2025-12-10 22:24:19'),
(29, 'Kursi Kerja Kayu', 30, 'furniture', 25, 50000.00, '2025-12-10 22:24:47'),
(30, 'Terminal Listrik', 30, 'Elektronik', 25, 25000.00, '2025-12-10 22:25:14'),
(31, 'Kursi Putar', 10, 'furniture', 24, 400000.00, '2025-12-10 22:26:05'),
(32, 'Mobil', 4, 'Kendaraan', 24, 99999999.99, '2025-12-10 22:26:42'),
(33, 'Motor', 10, 'Kendaraan', 24, 30000000.00, '2025-12-10 22:27:02'),
(34, 'Proyektor', 3, 'Untuk presentasi rapat, meeting, presentasi klien.', 30, 3000000.00, '2025-12-10 22:36:15'),
(35, 'Rak Buku / Rak Arsip', 2, 'Rak terbuka untuk menyimpan buku, dokumen, folder.', 30, 700000.00, '2025-12-10 22:36:45'),
(36, 'Sofa Ruang Tunggu', 4, 'Kursi sofa kecil untuk ruang tunggu tamu atau klien.', 30, 3500000.00, '2025-12-10 22:37:04'),
(37, 'Kertas A4 (pak)', 10, 'Kertas ukuran A4 untuk cetak dokumen, surat, laporan.', 30, 120000.00, '2025-12-10 22:37:35'),
(38, 'UPS (Uninterruptible Power Supply) / Stabilizer', 1, 'Cadangan daya / stabilisir listrik untuk perangkat sensitif.', 30, 1200000.00, '2025-12-10 22:38:52'),
(39, 'Router / Switch / Access Point / Perangkat Jaringan', 4, 'Untuk koneksi internet & jaringan internal kantor.', 30, 500000.00, '2025-12-10 22:39:20'),
(40, 'Harddisk eksternal / SSD eksternal', 5, 'Backup data, penyimpanan eksternal.', 30, 1500000.00, '2025-12-10 22:39:52'),
(41, 'Kabel (HDMI / VGA / LAN / Power / Charger) & Power-strip', 10, 'Untuk koneksi dan suplai alat elektronik.', 30, 100000.00, '2025-12-10 22:40:22'),
(42, 'Kulkas mini', 2, 'Untuk menyimpan makanan/minuman staf.', 30, 1500000.00, '2025-12-10 22:41:36'),
(43, 'Gelas, piring, sendok, rak piring', 2, 'Peralatan makan/minum staf.', 30, 300000.00, '2025-12-10 22:42:11'),
(44, 'Parfum', 2, 'Alat Kecantikan', 24, 150000.00, '2025-12-10 23:35:56'),
(45, 'Deodorant', 1, 'Skincare', 24, 50000.00, '2025-12-10 23:40:14'),
(46, 'Sabun', 1, 'Alat Mandi', 24, 5000.00, '2025-12-10 23:40:29'),
(47, 'Shampo', 2, 'Alat Mandi', 24, 15000.00, '2025-12-10 23:40:42'),
(48, 'Odol', 1, 'Alat Mandi', 24, 10000.00, '2025-12-10 23:41:08'),
(49, 'Sikat Gigi', 10, 'Alat Mandi', 24, 5000.00, '2025-12-10 23:41:34'),
(50, 'Gayung', 1, 'Alat Mandi', 24, 15000.00, '2025-12-10 23:42:32'),
(52, 'Handphone', 10, 'Alat Elektronik', 24, 15000000.00, '2025-12-10 23:47:45'),
(53, 'Jam Tangan', 10, 'Aksesoris', 24, 150000.00, '2025-12-10 23:50:47'),
(54, 'Ikat Pinggang', 10, 'Aksesoris', 24, 70000.00, '2025-12-10 23:51:15'),
(55, 'Celana Jeans', 100, 'Pakaian', 24, 400000.00, '2025-12-10 23:52:00'),
(56, 'Kemeja', 19, 'Pakaian', 24, 150000.00, '2025-12-10 23:52:18'),
(57, 'Dompet', 20, 'Aksesoris', 24, 5000000.00, '2025-12-10 23:52:41'),
(58, 'Sepatu', 10, 'Pakaian', 24, 1500000.00, '2025-12-10 23:53:23'),
(59, 'Topi', 10, 'Aksesoris', 24, 100000.00, '2025-12-10 23:53:51'),
(60, 'Garam', 10, 'Bahan Masakan', 24, 5000.00, '2025-12-10 23:54:56'),
(61, 'Gula', 10, 'Bahan Masakan', 24, 15000.00, '2025-12-10 23:55:12'),
(62, 'Micin', 10, 'Bahan Masakan', 24, 10000.00, '2025-12-10 23:55:32'),
(63, 'Kopi', 1, 'Minuman', 24, 5000.00, '2025-12-10 23:55:58'),
(64, 'Teh', 1, 'Minuman', 24, 5000.00, '2025-12-10 23:56:19'),
(65, 'Pulpen', 10, 'Alat Tulis', 24, 15000.00, '2025-12-10 23:57:17'),
(66, 'Pensil', 10, 'Alat Tulis', 24, 10000.00, '2025-12-10 23:58:17'),
(67, 'Penggaris', 10, 'Alat Tulis', 24, 5000.00, '2025-12-10 23:58:37'),
(68, 'Tipe-x', 10, 'Alat Tulis', 24, 5000.00, '2025-12-11 00:01:33'),
(69, 'Papan Tulis', 2, 'Alat Tulis', 24, 150000.00, '2025-12-11 00:02:45'),
(70, 'Spidol ', 10, 'Alat Tulis', 24, 15000.00, '2025-12-11 00:02:57'),
(71, 'Kapur', 10, 'Alat Tulis', 24, 15000.00, '2025-12-11 00:03:11'),
(72, 'Penghapus', 10, 'Alat Tulis', 24, 10000.00, '2025-12-11 00:03:27'),
(73, 'Tumbler', 1, 'Alat Minum', 24, 300000.00, '2025-12-11 00:06:26'),
(74, 'Buku', 10, 'Alat Tulis', 24, 50000.00, '2025-12-11 00:06:52'),
(75, 'HVS', 10, 'Alat Tulis', 24, 200000.00, '2025-12-11 00:08:50'),
(76, 'Stabilo', 10, 'Alat Tulis', 24, 20000.00, '2025-12-11 00:09:35'),
(77, 'Kotak Bekal', 10, 'Alat Makan', 24, 50000.00, '2025-12-11 00:10:11'),
(78, 'Sendok', 10, 'Alat Makan', 24, 5000.00, '2025-12-11 00:11:10'),
(79, 'Garpu', 10, 'Alat Makan', 24, 5000.00, '2025-12-11 00:11:24'),
(80, 'Gelas', 10, 'Alat Minum', 24, 10000.00, '2025-12-11 00:11:37'),
(81, 'Headset', 10, 'Alat Elektronik', 24, 300000.00, '2025-12-11 00:12:40'),
(82, 'Mouse', 10, 'Alat Elektronik', 24, 300000.00, '2025-12-11 00:13:14'),
(83, 'Keyboard', 10, 'Alat Elektronik', 24, 500000.00, '2025-12-11 00:13:28'),
(84, 'Monitor', 10, 'Alat Elektronik', 24, 5000000.00, '2025-12-11 00:15:13'),
(85, 'Terminal', 10, 'Alat Elektronik', 24, 50000.00, '2025-12-11 00:16:10'),
(86, 'Hair Dryer', 1, 'Alat Elektronik', 24, 150000.00, '2025-12-11 00:19:29'),
(87, 'Kacamata', 10, 'Aksesoris', 24, 150000.00, '2025-12-11 00:23:33'),
(88, 'Cincin', 10, 'Aksesoris', 24, 100000.00, '2025-12-11 00:23:50'),
(89, 'Gelang', 10, 'Aksesoris', 24, 50000.00, '2025-12-11 00:24:04'),
(90, 'Kalung', 10, 'Aksesoris', 24, 50000.00, '2025-12-11 00:24:17'),
(91, 'Obeng', 10, 'Perkakas', 24, 15000.00, '2025-12-11 00:27:46'),
(92, 'Tang', 10, 'Perkakas', 24, 20000.00, '2025-12-11 00:28:08'),
(93, 'Kunci Inggris', 10, 'Perkakas', 24, 50000.00, '2025-12-11 00:28:30'),
(94, 'Palu', 10, 'Perkakas', 24, 50000.00, '2025-12-11 00:28:43'),
(95, 'Paku', 100, 'Perkakas', 24, 5000.00, '2025-12-11 00:29:31'),
(96, 'Dongkrak', 10, 'Perkakas', 24, 100000.00, '2025-12-11 00:29:50'),
(97, 'Sarung', 10, 'Alat Sholat', 24, 200000.00, '2025-12-11 00:30:43'),
(98, 'Sajadah', 10, 'Alat Sholat', 24, 100000.00, '2025-12-11 00:30:57'),
(99, 'Mukena', 10, 'Alat Sholat', 24, 200000.00, '2025-12-11 00:31:14'),
(100, 'Kotak P3K', 10, 'Alat Kesehatan', 24, 500000.00, '2025-12-11 00:33:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Rifqi', '$2y$10$3bKEOYYMH3Nyartc.o/e8u88bmrWQDpqbJ04cpoGShyFk4SU9QuvO', 'admin'),
(3, 'Dicky', '$2y$10$GoX9FhUImcDr4WRl5bCsKuel.dxEtaW9/kWv..K00kpFTbkVJRbSO', 'admin'),
(9, 'Zaidan', '$2y$10$BMwV3vM5F1fzMrieav2.cO1QahvrVnSkwm1TTfApltu3mme3fB1tS', 'user'),
(15, 'Hendra', '$2y$10$cF0IpDHno0LBJIxbINztbe1ETY.Mbi2q4VR1ojNqLer7qR9VzvqaO', 'user'),
(16, 'Rifqi Zaidan Akhmad', '$2y$10$ENJmBlzIgmoVgNV2I3YiduOtpNbC704rfpU/4JId5o.SjtSKGDRxm', 'user'),
(24, 'user', '$2y$10$aYuNgES4bsYffBFkCqKXkebRGqSPkDXZMyfwqUolgakJFruOtLxg.', 'user'),
(25, 'admin', '$2y$10$nqItObc5wLm3hANL3iCor.IqxIU.DT6SFe/L8Mx0oB4l2X9WXVQn6', 'admin'),
(30, 'hapis', '$2y$10$WqU9ZsMMvJVHgyhBRaaFKu.cK56tyLplNRuLJxwR.SLh8haci.Z5C', 'user'),
(31, 'dickyab27', '$2y$10$SsG3tWca6e3yHYrQzmjNsuHHnJC51/leHvaoQAmM.99HYfUzNA2cm', 'user'),
(32, 'dickyabd', '$2y$10$sZDsTQZrkA.5pzqCU8Q70uXTLMQXkCEIN3s/QPe.DPiQUbRVZfWiy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
