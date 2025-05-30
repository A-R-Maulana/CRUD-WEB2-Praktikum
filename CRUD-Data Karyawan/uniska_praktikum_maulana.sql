-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2025 pada 15.59
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
-- Database: `uniska_praktikum_maulana`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_id` int(11) DEFAULT 1,
  `nik` char(16) DEFAULT NULL,
  `nama` varchar(32) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tempat_lahir` varchar(32) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `created_at`, `updated_at`, `status_id`, `nik`, `nama`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`) VALUES
(19, '2025-05-26 19:18:36', '2025-05-26 19:18:36', 1, '002', 'Sunan', 'Sebamban', 'Satui', '2003-07-25', 'Laki-laki'),
(20, '2025-05-27 12:42:45', '2025-05-28 11:57:10', 0, '009', 'Syahid', 'Surabaya', 'Sungai ulin', '2025-05-02', 'Laki-laki'),
(24, '2025-05-27 21:08:52', '2025-05-27 21:08:52', 1, '11', 'Oline', 'London', 'Chelsea', '2002-02-28', 'Perempuan'),
(25, '2025-05-28 06:53:39', '2025-05-28 06:53:39', 1, '001', 'Hasan', 'Tanggerang', 'Matsuru', '2025-06-03', 'Laki-laki'),
(26, '2025-05-28 13:31:58', '2025-05-28 13:31:58', 0, '004', 'Ayub', 'Isekai', 'Surabaya', '2025-06-20', 'Laki-laki');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
