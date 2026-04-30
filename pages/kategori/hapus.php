<?php 
require_once "../../konek.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kategori WHERE id='$id'");
header("location:index.php?pesan=hapus");
?>