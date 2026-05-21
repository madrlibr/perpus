<?php
require_once "../../konek.php";
proteksi_admin_petugas();

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");

if ($query) {
echo "
<!-- Load SweetAlert2 dari CDN -->
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Buku Berhasil Dihapus!',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Oke'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    });
</script>";
} else {
   echo "Error: " . mysqli_error($conn);
}