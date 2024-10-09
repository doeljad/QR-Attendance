-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 08 Jul 2024 pada 07.39
-- Versi server: 8.2.0
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perusahaan_xyz`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemen`
--

DROP TABLE IF EXISTS `departemen`;
CREATE TABLE IF NOT EXISTS `departemen` (
  `id_departemen` int NOT NULL AUTO_INCREMENT,
  `nama_departemen` varchar(255) NOT NULL,
  PRIMARY KEY (`id_departemen`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `departemen`
--

INSERT INTO `departemen` (`id_departemen`, `nama_departemen`) VALUES
(1, 'HRD'),
(2, 'GA (K3)'),
(3, 'CMO'),
(4, 'MARKETING BENANG'),
(5, 'MARKETING KAIN'),
(6, 'TOKO SRITEX'),
(7, 'INTERNAL AUDIT'),
(8, 'PREAUDIT'),
(9, 'EDP'),
(10, 'EXIM GARMEN'),
(11, 'PPIC SPINNING'),
(12, 'PPMC GARMEN'),
(13, 'IE'),
(14, 'QA GARMEN'),
(15, 'LAB PRINTING'),
(16, 'R&D FINISHING'),
(17, 'MTC FINISHING'),
(18, 'SPINING I/II'),
(19, 'SPINING III'),
(20, 'SPINING V'),
(21, 'SPINING VI'),
(22, 'SPINING VII'),
(23, 'SPINING VIII'),
(24, 'SPINING IX'),
(25, 'SPINING X'),
(26, 'SPINING XI'),
(27, 'SPINING XII'),
(28, 'WEAVING II'),
(29, 'WEAVING III'),
(30, 'WEAVING IV'),
(31, 'SENANG KHARISMA II'),
(32, 'SUKOHARJOTEX'),
(33, 'GARMEN I'),
(34, 'GARMEN II'),
(35, 'GARMEN III'),
(36, 'GARMEN V'),
(37, 'GARMEN VI'),
(38, 'GARMEN VII'),
(39, 'GARMEN VIII'),
(40, 'GARMEN X');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `id_peserta` int NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_peserta`, `hari`, `waktu_mulai`, `waktu_selesai`, `created_at`) VALUES
(1, 1, 'Senin', '15:00:00', '17:00:00', '2024-07-01 22:40:57'),
(2, 2, 'Selasa', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(3, 3, 'Rabu', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(4, 4, 'Kamis', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(5, 5, 'Jumat', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(6, 6, 'Sabtu', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(7, 7, 'Minggu', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(8, 8, 'Senin', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(9, 9, 'Selasa', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(10, 10, 'Rabu', '08:00:00', '17:00:00', '2024-07-01 22:40:57'),
(11, 11, 'Senin', '08:00:00', '17:00:00', '2024-07-08 07:07:04'),
(12, 11, 'Selasa', '08:00:00', '17:00:00', '2024-07-08 07:07:04'),
(13, 11, 'Rabu', '08:00:00', '17:00:00', '2024-07-08 07:07:04'),
(14, 11, 'Kamis', '08:00:00', '17:00:00', '2024-07-08 07:07:04'),
(15, 11, 'Jumat', '08:00:00', '17:00:00', '2024-07-08 07:07:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

DROP TABLE IF EXISTS `kehadiran`;
CREATE TABLE IF NOT EXISTS `kehadiran` (
  `id_kehadiran` int NOT NULL AUTO_INCREMENT,
  `id_peserta` int DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kehadiran`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`id_kehadiran`, `id_peserta`, `check_in`, `check_out`, `tanggal`, `created_at`) VALUES
(1, 1, '08:05:00', '17:00:00', '2023-01-01', '2024-07-01 22:40:57'),
(2, 2, '08:10:00', '17:00:00', '2023-01-02', '2024-07-01 22:40:57'),
(3, 3, '08:00:00', '17:00:00', '2023-01-03', '2024-07-01 22:40:57'),
(4, 4, '08:15:00', '17:00:00', '2023-01-04', '2024-07-01 22:40:57'),
(5, 5, '08:20:00', '17:00:00', '2023-01-05', '2024-07-01 22:40:57'),
(6, 6, '08:05:00', '17:00:00', '2023-01-06', '2024-07-01 22:40:57'),
(7, 7, '08:10:00', '17:00:00', '2023-01-07', '2024-07-01 22:40:57'),
(8, 8, '08:00:00', '17:00:00', '2023-01-08', '2024-07-01 22:40:57'),
(9, 9, '08:15:00', '17:00:00', '2023-01-09', '2024-07-01 22:40:57'),
(10, 10, '08:20:00', '17:00:00', '2023-01-10', '2024-07-01 22:40:57'),
(17, 9, '05:12:42', '14:12:55', '2024-07-02', '2024-07-02 07:39:46'),
(16, 2, '19:14:53', '19:15:01', '2024-07-02', '2024-07-02 12:14:53'),
(18, 3, '08:53:57', '11:59:52', '2024-07-03', '2024-07-03 01:53:57'),
(19, 10, '11:56:46', '11:58:10', '2024-07-03', '2024-07-03 04:56:46'),
(20, 6, NULL, NULL, '2024-07-06', '2024-07-06 02:57:49'),
(21, 7, '22:24:29', NULL, '2024-07-07', '2024-07-07 15:24:29'),
(22, 1, '14:00:30', NULL, '2024-07-08', '2024-07-08 07:00:30'),
(23, 8, NULL, NULL, '2024-07-08', '2024-07-08 06:56:13'),
(24, 11, '14:08:37', NULL, '2024-07-08', '2024-07-08 07:08:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `logbook`
--

DROP TABLE IF EXISTS `logbook`;
CREATE TABLE IF NOT EXISTS `logbook` (
  `id_logbook` int NOT NULL AUTO_INCREMENT,
  `id_peserta` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `kegiatan` text NOT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_logbook`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `logbook`
--

INSERT INTO `logbook` (`id_logbook`, `id_peserta`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `kegiatan`, `catatan`, `created_at`) VALUES
(1, 1, '2023-01-01', '08:00:00', '12:00:00', 'Mengerjakan tugas 1', 'Tidak ada', '2024-07-01 22:40:57'),
(2, 2, '2023-01-02', '08:00:00', '12:00:00', 'Mengerjakan tugas 2', 'Tidak ada', '2024-07-01 22:40:57'),
(3, 3, '2023-01-03', '08:00:00', '12:00:00', 'Mengerjakan tugas 3', 'Tidak ada', '2024-07-01 22:40:57'),
(4, 4, '2023-01-04', '08:00:00', '12:00:00', 'Mengerjakan tugas 4', 'Tidak ada', '2024-07-01 22:40:57'),
(5, 5, '2023-01-05', '08:00:00', '12:00:00', 'Mengerjakan tugas 5', 'Tidak ada', '2024-07-01 22:40:57'),
(6, 6, '2023-01-06', '08:00:00', '12:00:00', 'Mengerjakan tugas 6', 'Tidak ada', '2024-07-01 22:40:57'),
(7, 7, '2023-01-07', '08:00:00', '12:00:00', 'Mengerjakan tugas 7', 'Tidak ada', '2024-07-01 22:40:57'),
(8, 8, '2023-01-08', '08:00:00', '12:00:00', 'Mengerjakan tugas 8', 'Tidak ada', '2024-07-01 22:40:57'),
(9, 9, '2023-01-09', '08:00:00', '12:00:00', 'Mengerjakan tugas 9', 'Tidak ada', '2024-07-01 22:40:57'),
(10, 10, '2023-01-10', '08:00:00', '12:00:00', 'Membuat Dataflow ', 'Deserta magang ditugaskan untuk membuat dataflow perusahaan\r\n', '2024-07-01 22:40:57'),
(13, 2, '2024-07-02', '08:00:00', '10:00:00', 'Menggambar', 'Saya dan teman teman menggambar hunung fuji', '2024-07-02 13:42:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta_magang`
--

DROP TABLE IF EXISTS `peserta_magang`;
CREATE TABLE IF NOT EXISTS `peserta_magang` (
  `id_peserta` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_departemen` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_peserta`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `peserta_magang`
--

INSERT INTO `peserta_magang` (`id_peserta`, `id_user`, `id_departemen`, `nama`, `email`, `telepon`, `tanggal_mulai`, `tanggal_selesai`, `created_at`) VALUES
(1, 1, 1, 'Ahmad Fauzan', 'ahmad@example.com', '081234567890', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(2, 2, 2, 'Budi Santoso', 'budi@example.com', '081234567891', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(3, 3, 3, 'Citra Lestari', 'citra@example.com', '081234567892', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(4, 4, 4, 'Dewi Sartika', 'dewi@example.com', '081234567893', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(5, 5, 5, 'Eka Putra', 'eka@example.com', '081234567894', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(6, 6, 6, 'Fitri Ayu', 'fitri@example.com', '081234567895', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(7, 7, 7, 'Gilang Permana', 'gilang@example.com', '081234567896', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(8, 8, 8, 'Hani Wijaya', 'hani@example.com', '081234567897', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(9, 9, 9, 'Ivan Maulana', 'ivan@example.com', '081234567898', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(10, 10, 10, 'Joko Widodo', 'joko@example.com', '081234567899', '2023-01-01', '2023-12-31', '2024-07-01 22:40:57'),
(11, 12, 1, 'Abdullah Sajad', 'doel.@gmail.com', '081334900662', '2024-07-08', '2024-09-30', '2024-07-08 07:07:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `qr_code`
--

DROP TABLE IF EXISTS `qr_code`;
CREATE TABLE IF NOT EXISTS `qr_code` (
  `id_qrcode` int NOT NULL AUTO_INCREMENT,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_qrcode`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `qr_code`
--

INSERT INTO `qr_code` (`id_qrcode`, `password`, `updated_at`) VALUES
(1, '31cff2696206ba0368f5da2e64f4b16390f848acf416b2f6927b27a43f5f10508e5c46473fb6b13b941fb4742d1e352ddf208fd5d32773474d9ba0cd81600ab6', '2024-07-08 07:39:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sertifikat`
--

DROP TABLE IF EXISTS `sertifikat`;
CREATE TABLE IF NOT EXISTS `sertifikat` (
  `id_sertifikat` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sertifikat`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sertifikat`
--

INSERT INTO `sertifikat` (`id_sertifikat`, `file_name`, `judul`, `tanggal_terbit`, `created_at`) VALUES
(12, 'Tes Sertif 2024_66855da966717.pdf', 'Sertifikat Magang', '2024-07-03', '2024-07-03 14:18:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Ahmad Fauzan', 'ahmadf', '$2y$10$UWn/tMRbehiv15wy3k5Q6unZd.CTxF/DqUQ4hNFC4/ZbaFd8UcGiq', '2', '2024-07-01 22:40:57'),
(2, 'Budi Santoso', 'budis', '$2y$10$AqjQO88iYResStpSTtiplOJ7fEQJTKTwbrpgzTJxwcxqRu/PA34fu', '2', '2024-07-01 22:40:57'),
(3, 'Citra Lestari', 'citral', '$2y$10$NFLB5NdbSbbjtmi0rmsYwe4hNxFyXM1/0tVek3p152cdlROdCXDm6', '2', '2024-07-01 22:40:57'),
(4, 'Dewi Sartika', 'dewis', '$2y$10$igGvWl/fTl2W6UqsX46SFOwxtkTI8hPpHyv62C96D33iB3JcycHa6', '2', '2024-07-01 22:40:57'),
(5, 'Eka Putra', 'ekap', '$2y$10$0EhICXQoJtNX9WjJUX9iz.4HxuMzKuSJgainBCma1xPnPBHE1hZwS', '2', '2024-07-01 22:40:57'),
(6, 'Fitri Ayu', 'fitria', '$2y$10$cbghrmi6IDw1heqgFRtp9udJ3bG51Q3YYuszLe45QG6ZWv5YTGRO.', '2', '2024-07-01 22:40:57'),
(7, 'Gilang Permana', 'gilangp', '$2y$10$7lN.TJ1oxX8jTpAH.db7Tu3vpKVQZ1wasWhvzF/eDyWNG1P8tSZum', '2', '2024-07-01 22:40:57'),
(8, 'Hani Wijaya', 'haniw', '$2y$10$kixaSwiDht40z3XPXF3bLO08YiqsY9kJB/3DS2YpFaVhcKbZP1oLW', '2', '2024-07-01 22:40:57'),
(9, 'Ivan Maulana', 'ivanm', '$2y$10$swO97IMSRghcvxCQOtuY3uGn6k6PaH1Xc477KxyKxazzdXdvxVbGO', '2', '2024-07-01 22:40:57'),
(10, 'Joko Widodo', 'jokow', '$2y$10$eG/x3ILqyyrtcJqNYjhOP.7z0oaxC7iLJfCviQ4tk1IOTPaHGF3J2', '2', '2024-07-01 22:40:57'),
(11, 'Admin', 'admin', '$2y$10$x4DIfEvvHv3L8nhbLddglOiM/uVKXLtrBmlC7BJEuYJ3bMb30qyAe', '1', '2024-06-28 05:53:28'),
(12, 'Abdullah Sajad', 'doeljad', '$2y$10$.abq7DYGaK79NwvZHHLIFOxQ0Twl5FRi8bWt7EkbJJjHrHpW2Tn1K', '2', '2024-07-08 07:07:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
