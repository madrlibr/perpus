<?php
require_once "../konek.php";

// Matikan pengecekan Foreign Key agar bisa menghapus tabel yang saling berelasi
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

$tables = [
    'pengembalian', 'detail_peminjaman', 'peminjaman', 'laporan', 
    'anggota', 'buku', 'kategori', 'penulis', 'penerbit', 
    'rak', 'pengaturan_denda', 'users'
];

foreach ($tables as $table) {
    if (mysqli_query($conn, "TRUNCATE TABLE $table")) {
        echo "Tabel $table berhasil dikosongkan.<br>";
    } else {
        echo "Gagal mengosongkan $table: " . mysqli_error($conn) . "<br>";
    }
}

// Aktifkan kembali pengecekan Foreign Key
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

echo "<strong>Database berhasil di-reset total!</strong>
    <br>
    <a href='../pages/dashboard.php'>Kembali ke Dashboard!</a>";
?>