<?php
$host = "localhost";
$user = "root";
$pass = "Cons10DI";
$db   = "perpus";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

define('BASE_URL', 'http://localhost/perpustakaan/');
?>