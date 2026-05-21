<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

if (isset($_POST['simpan'])) {
    $nisn          = $_POST['nisn'];
    $nama_anggota  = $_POST['nama_anggota'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp       = $_POST['no_telp'];
    $alamat        = $_POST['alamat'];
    $id_user       = $_SESSION['id'] ?? $_SESSION['id_user']; // ID petugas yang menginput

    $insert = mysqli_query($conn, "INSERT INTO anggota (nisn, nama_anggota, jenis_kelamin, no_telp, alamat, id_user) 
                                   VALUES ('$nisn', '$nama_anggota', '$jenis_kelamin', '$no_telp', '$alamat', '$id_user')");

    if ($insert) {
    echo "
    <!-- Load SweetAlert2 dari CDN -->
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Buku Berhasil Ditambahkan!',
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
    }else{
       echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-3xl font-extrabold text-slate-800 mb-8 tracking-tight">Registrasi Anggota Baru</h2>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
        <form action="" method="POST" class="p-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">NISN</label>
                    <input type="text" name="nisn" required placeholder="Contoh: 008123456" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                    <input type="text" name="nama_anggota" required placeholder="Nama sesuai kartu pelajar" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telp" required placeholder="08xxxxxxxx" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required placeholder="Alamat domisili saat ini" 
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" name="simpan" class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                    Simpan Data Anggota
                </button>
                <a href="index.php" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-4 rounded-2xl text-center transition-all flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>