<?php
require_once "../../konek.php";
proteksi_admin_petugas();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil id_buku terlebih dahulu untuk mengembalikan stok
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id='$id'"));
    $id_buku = $data['id_buku'];

    // Update status peminjaman menjadi 'kembali'
    $update = mysqli_query($conn, "UPDATE peminjaman SET status_pinjam = 'kembali' WHERE id='$id'");

    if ($update) {
        // Tambahkan stok buku kembali
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id='$id_buku'");
        echo "<script>alert('Buku telah dikembalikan!'); window.location.href='index.php';</script>";
    }
}
?>