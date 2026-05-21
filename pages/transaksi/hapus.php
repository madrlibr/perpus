<?php
require_once "../../konek.php";
proteksi_admin_petugas();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Opsional: Cek dulu apakah statusnya memang sudah 'kembali' demi keamanan
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status_pinjam FROM peminjaman WHERE id='$id'"));

    if ($cek['status_pinjam'] == 'kembali') {
        $delete = mysqli_query($conn, "DELETE FROM peminjaman WHERE id='$id'");
        if ($delete) {
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
        }
    } else {
        echo "<script>alert('Gagal! Buku masih dalam status dipinjam.'); window.location.href='index.php';</script>";
    }
}
?>