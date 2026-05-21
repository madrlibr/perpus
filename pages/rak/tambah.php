<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas();

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $nama_rak = mysqli_real_escape_string($conn, $_POST['nama_rak']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    
    $query = mysqli_query($conn, "INSERT INTO rak (nama_rak, lokasi) VALUES ('$nama_rak', '$lokasi')");
   
    
    if ($query) {
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

<div class="max-w-2xl mx-auto p-6">
    <div class="mb-8 flex items-center gap-4">
        <a href="index.php" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-600 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Konfigurasi Rak</h2>
            <p class="text-sm text-slate-500">Tentukan lokasi penyimpanan buku baru.</p>
        </div>
    </div>

    <form method="POST" action="" class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Label / Nama Rak</label>
                <input type="text" name="nama_rak" required placeholder="Contoh: RAK-01 atau SAINS-A" 
                       class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Lokasi Spesifik</label>
                <input type="text" name="lokasi" required placeholder="Contoh: Lantai 1, Pojok Kanan" 
                       class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all">
            </div>

            <button type="submit" name="simpan" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-rose-200 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-layer-group text-sm"></i> Tambahkan Rak Baru
            </button>
        </div>
    </form>
</div>

<?php require_once "../../layout/footer.php"; ?>