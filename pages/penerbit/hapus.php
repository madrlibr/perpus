<?php 
require_once "../../konek.php"; 
proteksi_admin_petugas();

// Pastikan ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eksekusi hapus
    $hapus = mysqli_query($conn, "DELETE FROM penerbit WHERE id = '$id'");

if ($hapus) {
echo "
<!-- Load SweetAlert2 dari CDN -->
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data Berhasil Dihapus!',
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
} else {
    header("Location: index.php");
}
?>