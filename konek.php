<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$user = "root";
$pass = "Cons10DI";
$db   = "perpus";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

define('BASE_URL', 'http://localhost/library/');

function proteksi_admin_petugas() {
    // Logika: Jika role BUKAN admin DAN role juga BUKAN petugas, maka blokir
    if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak!',
            text: 'Anggota hanya diperbolehkan melihat data.',
            confirmButtonColor: '#3b82f6'
        }).then(() => {
            window.location.href = '../dashboard.php';
        });
    });
</script>";
        exit();
    }
}
?>