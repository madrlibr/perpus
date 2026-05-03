<?php 
require_once "../../konek.php"; 

// Pastikan ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eksekusi hapus
    $hapus = mysqli_query($conn, "DELETE FROM anggota WHERE id = '$id'");

    if ($hapus) {
        echo "<script>alert('Anggota berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data. Data mungkin sedang digunakan di tabel lain.'); window.location='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
?>