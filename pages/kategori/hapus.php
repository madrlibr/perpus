<?php
require_once "../../konek.php";
proteksi_admin_petugas();

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");

if($query) {
    echo "<script>alert('Kategori berhasil dihapus!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus! Kategori mungkin masih digunakan oleh data buku.'); window.location='index.php';</script>";
}