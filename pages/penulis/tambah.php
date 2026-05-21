<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas();

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $namaPenulis = mysqli_real_escape_string($conn, $_POST['nama_penulis']);
    $b = mysqli_real_escape_string($conn, $_POST['biografi']);
    
    $query = mysqli_query($conn, "INSERT INTO penulis (nama_penulis, biografi) VALUES ('$namaPenulis', '$b')");
   
    
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
    } else {
       echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="max-w-2xl mx-auto p-6">
    <div class="mb-8 flex items-center gap-4">
        <a href="index.php" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-amber-600 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Penulis</h2>
            <p class="text-sm text-slate-500">Masukkan identitas penulis buku baru.</p>
        </div>
    </div>

    <form method="POST" action="" class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Nama Lengkap Penulis</label>
                <input type="text" name="nama_penulis" required placeholder="Contoh: Andrea Hirata" 
                       class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Biografi Singkat (Opsional)</label>
                <textarea name="biografi" rows="4" placeholder="Tulis sedikit tentang penulis ini..." 
                          class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all resize-none"></textarea>
            </div>

            <button type="submit" name="simpan" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-200 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save text-sm"></i> Simpan Data Penulis
            </button>
        </div>
    </form>
</div>

<?php require_once "../../layout/footer.php"; ?>