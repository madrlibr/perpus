-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2026 at 05:46 AM
-- Server version: 8.0.44
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat` text,
  `tanggal_mendaftar` date DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `id_user`, `nisn`, `nama_anggota`, `jenis_kelamin`, `no_telp`, `alamat`, `tanggal_mendaftar`) VALUES
(1, NULL, '10203040', 'Budi Setiawan', 'L', '08123456789', 'Jl. Merdeka No. 12', '2026-05-01'),
(2, NULL, '10203041', 'Siti Aminah', 'P', '08987654321', 'Jl. Mawar No. 5', '2026-05-02');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `stok` int DEFAULT '0',
  `tahun_terbit` year DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_penulis` int DEFAULT NULL,
  `id_penerbit` int DEFAULT NULL,
  `id_rak` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul_buku`, `isbn`, `stok`, `tahun_terbit`, `id_kategori`, `id_penulis`, `id_penerbit`, `id_rak`) VALUES
(1, 'Pemrograman Web Ahli', '978-602-001', 10, 2023, 1, 1, 1, 1),
(2, 'Laskar Pelangi', '978-602-002', 9, 2005, 2, 2, 2, 2),
(3, 'Ayat-Ayat Cinta', '978-602-003', 10, 2004, 4, 4, 3, 3),
(4, 'Antrophoida', '89343', 4, 1952, 3, 3, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id` int NOT NULL,
  `id_peminjaman` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Sains & Teknologi'),
(2, 'Novel'),
(3, 'Sejarah'),
(4, 'Religius');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `jenis_laporan` varchar(100) DEFAULT NULL,
  `isi_laporan` text,
  `tanggal_dibuat` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `id_user`, `jenis_laporan`, `isi_laporan`, `tanggal_dibuat`) VALUES
(1, 1, 'Laporan Sirkulasi', 'Mencetak laporan periode 2026-05-01 s/d 2026-05-05', '2026-05-05 08:09:41'),
(2, 1, 'Laporan Sirkulasi', 'Mencetak laporan periode 2026-05-01 s/d 2026-05-05', '2026-05-05 08:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `id_anggota` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali_seharusnya` date NOT NULL,
  `status_pinjam` enum('dipinjam','kembali') DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_buku`, `id_user`, `tanggal_pinjam`, `tanggal_kembali_seharusnya`, `status_pinjam`) VALUES
(15, 1, 2, 1, '2026-05-03', '2026-05-10', 'kembali'),
(16, 2, 2, 3, '2026-05-04', '2026-05-11', 'kembali'),
(17, 1, 2, 1, '2026-05-05', '2026-05-12', 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id` int NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  `alamat_penerbit` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id`, `nama_penerbit`, `alamat_penerbit`) VALUES
(1, 'Gramedia Pustaka Utama', 'Jakarta Pusat'),
(2, 'Bentang Pustaka', 'Yogyakarta'),
(3, 'Republika', 'Jakarta Selatan');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_denda`
--

CREATE TABLE `pengaturan_denda` (
  `id` int NOT NULL,
  `harga_denda_per_hari` decimal(10,2) NOT NULL,
  `status_aktif` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaturan_denda`
--

INSERT INTO `pengaturan_denda` (`id`, `harga_denda_per_hari`, `status_aktif`) VALUES
(1, '1000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int NOT NULL,
  `id_peminjaman` int DEFAULT NULL,
  `tanggal_kembali_aktual` date NOT NULL,
  `denda_terlambat` decimal(10,2) DEFAULT '0.00',
  `kondisi_buku` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id` int NOT NULL,
  `nama_penulis` varchar(100) NOT NULL,
  `biografi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id`, `nama_penulis`, `biografi`) VALUES
(1, 'Tere Liyes', 'seorang penyair dari Jerman'),
(2, 'Andrea Hirata', NULL),
(3, 'Fiersa Besari', NULL),
(4, 'Habiburrahman El Shirazy', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `id` int NOT NULL,
  `nama_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`id`, `nama_rak`, `lokasi`) VALUES
(1, 'Rak A1', 'Lantai 1 - Sayap Kiri'),
(2, 'Rak B2', 'Lantai 1 - Sayap Kanan'),
(3, 'Rak C3', 'Lantai 2 - Tengah');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin','petugas','anggota') DEFAULT 'anggota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', 'admin123', 'admin lengkap', 'admin'),
(2, 'zahra', '3232', 'azzahra', 'anggota'),
(3, 'adril', '2112', 'adril muhammad', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_penulis` (`id_penulis`),
  ADD KEY `id_penerbit` (`id_penerbit`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengembalian_ibfk_1` (`id_peminjaman`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`),
  ADD CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id`),
  ADD CONSTRAINT `buku_ibfk_4` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id`);

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
