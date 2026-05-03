<?php 
require_once "../../konek.php"; 

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM rak WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data.'); window.location='index.php';</script>";
}
?>