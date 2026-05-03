<?php
require_once "../../konek.php";
proteksi_admin_petugas(); // Satpam pengecekan role
$id = $_GET['id'];

$conn->query("DELETE FROM buku WHERE id='$id'");

header("Location: index.php");
?>