<?php
require_once "../../konek.php";
proteksi_admin_petugas();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Opsional: Cek dulu apakah statusnya memang sudah 'kembali' demi keamanan
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status_pinjam FROM peminjaman WHERE id='$id'"));

    if ($cek['status_pinjam'] == 'kembali') {
        $delete = mysqli_query($conn, "DELETE FROM peminjaman WHERE id='$id'");
        if ($delete) {
            echo "<script>alert('Riwayat transaksi berhasil dihapus!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal! Buku masih dalam status dipinjam.'); window.location.href='index.php';</script>";
    }
}
?>