<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

if (isset($_POST['simpan'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $isbn     = $_POST['isbn'];
    $stok     = $_POST['stok'];
    $tahun    = $_POST['tahun_terbit'];
    $kategori = $_POST['id_kategori'];
    $penulis  = $_POST['id_penulis'];
    $penerbit = $_POST['id_penerbit'];
    $rak      = $_POST['id_rak'];

    $query = mysqli_query($conn, "INSERT INTO buku (judul_buku, isbn, stok, tahun_terbit, id_kategori, id_penulis, id_penerbit, id_rak) 
                                  VALUES ('$judul', '$isbn', '$stok', '$tahun', '$kategori', '$penulis', '$penerbit', '$rak')");

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
        echo "
        <!-- Load SweetAlert2 dari CDN -->
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Buku Gagal Ditambahkan!',
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
}
?>

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-3xl font-extrabold text-slate-800 mb-8">Tambah Koleksi Buku</h2>

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
        <form action="" method="POST" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Judul & ISBN -->
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Buku</label>
                <input type="text" name="judul_buku" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">ISBN</label>
                <input type="text" name="isbn" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Dropdown Relasi -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Penulis</label>
                <select name="id_penulis" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white">
                    <option value="">Pilih Penulis</option>
                    <?php 
                    $pnl = mysqli_query($conn, "SELECT * FROM penulis");
                    while($p = mysqli_fetch_assoc($pnl)) echo "<option value='".$p['id']."'>".$p['nama_penulis']."</option>";
                    ?>
                </select>

                <a href="../penulis/tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1.5 rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95">
                    <i class="fas fa-plus text-xs"></i>
                    Tambah Penulis
                </a>

            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Penerbit</label>
                <select name="id_penerbit" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white">
                    <option value="">Pilih Penerbit</option>
                    <?php 
                    $pnb = mysqli_query($conn, "SELECT * FROM penerbit");
                    while($pb = mysqli_fetch_assoc($pnb)) echo "<option value='".$pb['id']."'>".$pb['nama_penerbit']."</option>";
                    ?>
                </select>

                <a href="../penerbit/tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1.5 rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95">
                    <i class="fas fa-plus text-xs"></i>
                    Tambah Penerbit
                </a>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                <select name="id_kategori" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white">
                    <option value="">Pilih Kategori</option>
                    <?php 
                    $kat = mysqli_query($conn, "SELECT * FROM kategori");
                    while($k = mysqli_fetch_assoc($kat)) echo "<option value='".$k['id']."'>".$k['nama_kategori']."</option>";
                    ?>
                </select>

                <a href="../kategori/tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1.5 rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95">
                    <i class="fas fa-plus text-xs"></i>
                    Tambah Kategori
                </a>

            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Rak Simpan</label>
                <select name="id_rak" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white">
                    <option value="">Pilih Rak</option>
                    <?php 
                    $rak_q = mysqli_query($conn, "SELECT * FROM rak");
                    while($r = mysqli_fetch_assoc($rak_q)) echo "<option value='".$r['id']."'>".$r['nama_rak']."</option>";
                    ?>
                </select>

                <a href="../rak/tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1.5 rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95">
                    <i class="fas fa-plus text-xs"></i>
                    Tambah Rak
                </a>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Stok</label>
                <input type="number" name="stok" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="md:col-span-2 pt-4 flex gap-3">
                <button type="submit" name="simpan" class="flex-1 bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200">Simpan Buku</button>
                <a href="index.php" class="flex-1 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl text-center">Batal</a>
            </div>
        </form>
    </div>
</div>