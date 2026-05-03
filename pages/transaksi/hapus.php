<?php
require_once "../../konek.php";
proteksi_admin_petugas(); 
$id = $_GET['id'];

// 1. Ambil data untuk cek status & id_buku
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM peminjaman WHERE id = '$id'"));

if ($data) {
    // 2. Jika status masih 'dipinjam', kembalikan stok buku
    if ($data['status_pinjam'] == 'dipinjam') {
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = '{$data['id_buku']}'");
    }

    // 3. HAPUS DATA ANAK (pengembalian) terlebih dahulu
    mysqli_query($conn, "DELETE FROM pengembalian WHERE id_peminjaman = '$id'");

    // 4. BARU HAPUS DATA INDUK (peminjaman)
    $query = mysqli_query($conn, "DELETE FROM peminjaman WHERE id = '$id'");

    if ($query) {
        echo "<script>alert('Data transaksi berhasil dihapus sepenuhnya'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('Data tidak ditemukan'); window.location='index.php';</script>";
}