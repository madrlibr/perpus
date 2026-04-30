<?php 
require_once "../../konek.php";
$id_penulis = $_GET['id'];
mysqli_query($conn, "DELETE FROM penulis WHERE id='$id_penulis'");
header("location:index.php?pesan=hapus");
?>