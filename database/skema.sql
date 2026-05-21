-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2026 at 03:17 AM
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
(1, NULL, '0067242604', 'Dewi A', 'P', '081241452805', 'Jl. Contoh Alamat No. 1', '2026-05-11'),
(2, NULL, '0079904233', 'Joko B', 'L', '081238501792', 'Jl. Contoh Alamat No. 2', '2026-05-11'),
(3, NULL, '0071476110', 'Bambang C', 'P', '081269784342', 'Jl. Contoh Alamat No. 3', '2026-05-11'),
(4, NULL, '0047337528', 'Dewi D', 'L', '081267744498', 'Jl. Contoh Alamat No. 4', '2026-05-11'),
(5, NULL, '0011089971', 'Andi E', 'P', '081249683997', 'Jl. Contoh Alamat No. 5', '2026-05-11'),
(6, NULL, '0062769225', 'Maya F', 'L', '081231302686', 'Jl. Contoh Alamat No. 6', '2026-05-11'),
(7, NULL, '0082370147', 'Rina G', 'P', '081277511162', 'Jl. Contoh Alamat No. 7', '2026-05-11'),
(8, NULL, '0032532179', 'Bambang H', 'L', '081241444156', 'Jl. Contoh Alamat No. 8', '2026-05-11'),
(9, NULL, '0076890828', 'Andi I', 'P', '081297586900', 'Jl. Contoh Alamat No. 9', '2026-05-11'),
(10, NULL, '0056801159', 'Bambang J', 'L', '081238197459', 'Jl. Contoh Alamat No. 10', '2026-05-11'),
(11, NULL, '0024385290', 'Maya K', 'P', '081220827473', 'Jl. Contoh Alamat No. 11', '2026-05-11'),
(12, NULL, '0096929240', 'Maya L', 'L', '081290077979', 'Jl. Contoh Alamat No. 12', '2026-05-11'),
(13, NULL, '0098057057', 'Bambang M', 'P', '081276685480', 'Jl. Contoh Alamat No. 13', '2026-05-11'),
(14, NULL, '0061691824', 'Joko N', 'L', '081215075108', 'Jl. Contoh Alamat No. 14', '2026-05-11'),
(15, NULL, '0076642566', 'Joko O', 'P', '081277550612', 'Jl. Contoh Alamat No. 15', '2026-05-11');

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
(1, 'Negeri 5 Menara Part 1', '978-602-391-19', 12, 2017, 4, 1, 1, 1),
(2, 'Laskar Pelangi Part 2', '978-602-809-53', 8, 2020, 5, 2, 3, 1),
(3, 'Pemrograman Web Part 3', '978-602-679-67', 3, 2016, 4, 1, 1, 1),
(4, 'Pemrograman Web Part 4', '978-602-530-81', 9, 2015, 1, 1, 2, 1),
(5, 'Laut Bercerita Part 5', '978-602-208-34', 3, 2018, 4, 1, 3, 1),
(6, 'Bumi Manusia Part 6', '978-602-372-25', 7, 2024, 4, 3, 1, 3),
(7, 'Laut Bercerita Part 7', '978-602-966-31', 5, 2020, 1, 2, 3, 2),
(8, 'Laut Bercerita Part 8', '978-602-855-67', 12, 2023, 4, 2, 3, 2),
(9, 'Filosofi Teras Part 9', '978-602-748-66', 15, 2024, 4, 2, 1, 2),
(10, 'Negeri 5 Menara Part 10', '978-602-711-13', 10, 2020, 4, 3, 3, 3),
(11, 'Negeri 5 Menara Part 11', '978-602-857-23', 15, 2023, 5, 1, 3, 2),
(12, 'Laut Bercerita Part 12', '978-602-661-83', 6, 2017, 4, 1, 3, 1),
(13, 'Laskar Pelangi Part 13', '978-602-722-95', 10, 2022, 4, 2, 2, 2),
(14, 'Laut Bercerita Part 14', '978-602-508-31', 8, 2024, 3, 1, 2, 2),
(15, 'Pulang Part 15', '978-602-717-36', 11, 2021, 4, 3, 3, 3),
(16, 'Laut Bercerita Part 16', '978-602-801-48', 3, 2019, 2, 1, 1, 1),
(17, 'Laskar Pelangi Part 17', '978-602-393-90', 14, 2018, 4, 3, 2, 2),
(18, 'Negeri 5 Menara Part 18', '978-602-467-34', 8, 2017, 2, 1, 2, 3),
(19, 'Laut Bercerita Part 19', '978-602-480-24', 10, 2020, 2, 3, 1, 2),
(20, 'Filosofi Teras Part 20', '978-602-505-52', 7, 2017, 2, 2, 2, 3),
(21, 'Sapiens De Salfisah', '978-602-0052134343', 32, 2009, 2, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id` int NOT NULL,
  `id_peminjaman` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL,
  `status_buku` enum('dipinjam','kembali') DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id`, `id_peminjaman`, `id_buku`, `status_buku`) VALUES
(4, 5, 2, 'kembali'),
(5, 6, 3, 'kembali'),
(6, 6, 14, 'kembali'),
(7, 6, 16, 'kembali'),
(8, 7, 3, 'kembali'),
(9, 7, 15, 'kembali'),
(10, 7, 20, 'kembali'),
(11, 8, 6, 'kembali'),
(12, 9, 5, 'dipinjam'),
(13, 9, 15, 'dipinjam'),
(14, 10, 3, 'dipinjam'),
(15, 10, 16, 'dipinjam'),
(16, 10, 16, 'dipinjam');

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
(1, 'Sains'),
(2, 'Teknologi'),
(3, 'Fiksi'),
(4, 'Sejarah'),
(5, 'Agama');

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
(1, 1, 'Laporan Sirkulasi', 'Mencetak laporan periode 2026-05-01 s/d 2026-05-12', '2026-05-12 07:58:51'),
(2, 1, 'Laporan Sirkulasi', 'Mencetak laporan periode 2026-05-01 s/d 2026-05-12', '2026-05-12 08:41:31');

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
(5, 1, NULL, 1, '2026-05-12', '2018-02-14', 'kembali'),
(6, 2, NULL, 1, '2026-05-12', '2018-02-14', 'kembali'),
(7, 4, NULL, 1, '2026-05-12', '2022-02-02', 'kembali'),
(8, 3, NULL, 1, '2026-05-12', '2026-05-19', 'kembali'),
(9, 3, NULL, 1, '2026-05-12', '2026-05-19', 'dipinjam'),
(10, 5, NULL, 1, '2026-05-12', '2026-05-19', 'dipinjam');

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
(1, 'Gramedia', 'Jakarta Pusat'),
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
(1, '45.00', 1);

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

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `id_peminjaman`, `tanggal_kembali_aktual`, `denda_terlambat`, `kondisi_buku`) VALUES
(4, 5, '2026-05-12', '135405.00', 'Baik'),
(5, 6, '2026-05-12', '135405.00', 'Baik'),
(6, 6, '2026-05-12', '135405.00', 'Baik'),
(7, 6, '2026-05-12', '135405.00', 'Baik'),
(8, 7, '2026-05-12', '70200.00', 'Baik'),
(9, 7, '2026-05-12', '70200.00', 'Baik'),
(10, 7, '2026-05-12', '70200.00', 'Baik'),
(11, 8, '2026-05-12', '0.00', 'Baik');

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
(1, 'Tere Liye', 'Penulis novel produktif Indonesia.'),
(2, 'Pramoedya Ananta Toer', 'Sastrawan legendaris Indonesia.'),
(3, 'Dee Lestari', 'Penulis seri Supernova.'),
(4, 'fsfsfs', '');

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
(1, 'A1', 'Lantai 1 - Rak Sains'),
(2, 'B1', 'Lantai 1 - Rak Fiksi'),
(3, 'C2', 'Lantai 2 - Rak Sejarah');

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
(1, 'admin', '123', 'Administrator Utama', 'admin'),
(2, 'anggota', '123', 'Anggota', 'anggota'),
(3, 'petugas1', '123', 'Budi Staff', 'petugas');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
