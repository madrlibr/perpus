<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

if(isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $insert = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
    if($insert) echo "<script>window.location='index.php';</script>";
}
?>

<div class="p-6 max-w-2xl">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Kategori</h2>
        <a href="index.php" class="text-blue-600 text-sm font-bold flex items-center gap-2 mt-2 hover:underline">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke daftar kategori
        </a>

        <a href="../buku/tambah.php" class="text-blue-600 text-sm font-bold flex items-center gap-2 mt-2 hover:underline">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke daftar Buku
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
        <form method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" placeholder="Contoh: Fiksi, Sains, Sejarah" required autofocus
                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium">
            </div>
            <button type="submit" name="simpan" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-slate-200">
                Simpan Kategori Baru
            </button>
        </form>
    </div>
</div>