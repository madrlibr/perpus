<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

$pesan = "";
if (isset($_POST['simpan_semua'])) {
    // Ambil semua input
    $kat = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $pen = mysqli_real_escape_string($conn, $_POST['nama_penulis']);
    $pbt = mysqli_real_escape_string($conn, $_POST['nama_penerbit']);
    $rak = mysqli_real_escape_string($conn, $_POST['nama_rak']);
    $lok = mysqli_real_escape_string($conn, $_POST['lokasi']);

    // Mulai Transaksi agar jika satu gagal, semua batal (opsional tapi bagus)
    mysqli_begin_transaction($conn);

    try {
        if(!empty($kat)) mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$kat')");
        if(!empty($pen)) mysqli_query($conn, "INSERT INTO penulis (nama_penulis) VALUES ('$pen')");
        if(!empty($pbt)) mysqli_query($conn, "INSERT INTO penerbit (nama_penerbit) VALUES ('$pbt')");
        if(!empty($rak)) mysqli_query($conn, "INSERT INTO rak (nama_rak, lokasi) VALUES ('$rak', '$lok')");

        mysqli_commit($conn);
        $pesan = "Semua data yang diisi berhasil disimpan!";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $pesan = "Gagal menyimpan: " . $e->getMessage();
    }
}
?>

<div class="p-6">
    <form method="POST" action="">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800">Quick Master Center</h2>
                <p class="text-slate-500">Isi kolom yang diperlukan lalu klik simpan sekaligus.</p>
            </div>
            <button type="submit" name="simpan_semua" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3 rounded-2xl transition-all shadow-lg shadow-emerald-100 flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Semua Data
            </button>
        </div>

        <?php if ($pesan != ""): ?>
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-2xl">
                <i class="fas fa-info-circle mr-2"></i> <?= $pesan ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Box Kategori -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <label class="block text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Kategori Baru</label>
                <input type="text" name="nama_kategori" placeholder="Contoh: Teknologi, Komik..." 
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Box Penulis -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <label class="block text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Penulis Baru</label>
                <input type="text" name="nama_penulis" placeholder="Nama lengkap penulis..." 
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-amber-500 outline-none">
            </div>

            <!-- Box Penerbit -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <label class="block text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Penerbit Baru</label>
                <input type="text" name="nama_penerbit" placeholder="Nama perusahaan penerbit..." 
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-purple-500 outline-none">
            </div>

            <!-- Box Rak -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <label class="block text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Informasi Rak</label>
                <div class="flex gap-3">
                    <input type="text" name="nama_rak" placeholder="Kode Rak" 
                           class="w-1/3 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-rose-500 outline-none">
                    <input type="text" name="lokasi" placeholder="Lokasi Spesifik" 
                           class="w-2/3 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-rose-500 outline-none">
                </div>
            </div>
        </div>
    </form>
</div>