SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Hapus pengaturan spesifik MySQL 8 jika ada
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin','petugas','anggota') DEFAULT 'anggota',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', 'admin123', 'admin lengkap', 'admin'),
(2, 'zahra', '3232', 'azzahra', 'anggota'),
(3, 'adril', '2112', 'adril muhammad', 'petugas');

-- --------------------------------------------------------
-- Table structure for table `kategori`
-- --------------------------------------------------------
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Sains & Teknologi'),
(2, 'Novel'),
(3, 'Sejarah'),
(4, 'Religius');

-- --------------------------------------------------------
-- Table structure for table `penulis`
-- --------------------------------------------------------
CREATE TABLE `penulis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penulis` varchar(100) NOT NULL,
  `biografi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `penulis` (`id`, `nama_penulis`, `biografi`) VALUES
(1, 'Tere Liyes', 'seorang penyair dari Jerman'),
(2, 'Andrea Hirata', NULL),
(3, 'Fiersa Besari', NULL),
(4, 'Habiburrahman El Shirazy', NULL);

-- --------------------------------------------------------
-- Table structure for table `penerbit`
-- --------------------------------------------------------
CREATE TABLE `penerbit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penerbit` varchar(100) NOT NULL,
  `alamat_penerbit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `penerbit` (`id`, `nama_penerbit`, `alamat_penerbit`) VALUES
(1, 'Gramedia Pustaka Utama', 'Jakarta Pusat'),
(2, 'Bentang Pustaka', 'Yogyakarta'),
(3, 'Republika', 'Jakarta Selatan');

-- --------------------------------------------------------
-- Table structure for table `rak`
-- --------------------------------------------------------
CREATE TABLE `rak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rak` (`id`, `nama_rak`, `lokasi`) VALUES
(1, 'Rak A1', 'Lantai 1 - Sayap Kiri'),
(2, 'Rak B2', 'Lantai 1 - Sayap Kanan'),
(3, 'Rak C3', 'Lantai 2 - Tengah');

-- --------------------------------------------------------
-- Table structure for table `anggota`
-- --------------------------------------------------------
CREATE TABLE `anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat` text,
  `tanggal_mendaftar` date DEFAULT curdate(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nisn` (`nisn`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `anggota` (`id`, `id_user`, `nisn`, `nama_anggota`, `jenis_kelamin`, `no_telp`, `alamat`, `tanggal_mendaftar`) VALUES
(1, NULL, '10203040', 'Budi Setiawan', 'L', '08123456789', 'Jl. Merdeka No. 12', '2026-05-01'),
(2, NULL, '10203041', 'Siti Aminah', 'P', '08987654321', 'Jl. Mawar No. 5', '2026-05-02');

-- --------------------------------------------------------
-- Table structure for table `buku`
-- --------------------------------------------------------
CREATE TABLE `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `tahun_terbit` year(4) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id_kategori`),
  KEY `id_penulis` (`id_penulis`),
  KEY `id_penerbit` (`id_penerbit`),
  KEY `id_rak` (`id_rak`),
  CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`),
  CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`),
  CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id`),
  CONSTRAINT `buku_ibfk_4` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `buku` (`id`, `judul_buku`, `isbn`, `stok`, `tahun_terbit`, `id_kategori`, `id_penulis`, `id_penerbit`, `id_rak`) VALUES
(1, 'Pemrograman Web Ahli', '978-602-001', 10, 2023, 1, 1, 1, 1),
(2, 'Laskar Pelangi', '978-602-002', 9, 2005, 2, 2, 2, 2),
(3, 'Ayat-Ayat Cinta', '978-602-003', 10, 2004, 4, 4, 3, 3),
(4, 'Antrophoida', '89343', 4, 1952, 3, 3, 2, 1);

-- --------------------------------------------------------
-- Table structure for table `peminjaman`
-- --------------------------------------------------------
CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali_seharusnya` date NOT NULL,
  `status_pinjam` enum('dipinjam','kembali') DEFAULT 'dipinjam',
  PRIMARY KEY (`id`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_buku`, `id_user`, `tanggal_pinjam`, `tanggal_kembali_seharusnya`, `status_pinjam`) VALUES
(15, 1, 2, 1, '2026-05-03', '2026-05-10', 'kembali'),
(16, 2, 2, 3, '2026-05-04', '2026-05-11', 'kembali'),
(17, 1, 2, 1, '2026-05-05', '2026-05-12', 'dipinjam');

-- --------------------------------------------------------
-- Table structure for table `laporan`
-- --------------------------------------------------------
CREATE TABLE `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `jenis_laporan` varchar(100) DEFAULT NULL,
  `isi_laporan` text,
  `tanggal_dibuat` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `laporan` (`id`, `id_user`, `jenis_laporan`, `isi_laporan`, `tanggal_dibuat`) VALUES
(1, 1, 'Laporan Sirkulasi', 'Mencetak laporan periode 2026-05-01 s/d 2026-05-05', '2026-05-05 08:09:41'),
(2, 1, 'Laporan Sirkulasi', 'Mencetak laporan periode 2026-05-01 s/d 2026-05-05', '2026-05-05 08:10:10');

-- Tambahkan tabel lainnya (pengembalian, denda, rak, dll sesuai pola di atas)
-- Selesaikan dengan COMMIT
COMMIT;