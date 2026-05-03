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

function proteksi_admin_petugas() {
    // Pastikan session sudah dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Logika: Jika role BUKAN admin DAN role juga BUKAN petugas, maka blokir
    if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
        echo "<script>
                alert('Akses Ditolak! Anggota hanya diperbolehkan melihat data.');
                window.location.href = '../dashboard.php';
              </script>";
        exit();
    }
}
?>