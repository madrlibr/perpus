<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

$id = $_GET['id'];

// Query dengan JOIN lengkap agar semua nama muncul, bukan sekadar ID
$query = mysqli_query($conn, "SELECT buku.*, 
                                     kategori.nama_kategori, 
                                     penulis.nama_penulis, 
                                     penerbit.nama_penerbit, 
                                     rak.nama_rak
                              FROM buku 
                              LEFT JOIN kategori ON buku.id_kategori = kategori.id 
                              LEFT JOIN penulis ON buku.id_penulis = penulis.id
                              LEFT JOIN penerbit ON buku.id_penerbit = penerbit.id
                              LEFT JOIN rak ON buku.id_rak = rak.id
                              WHERE buku.id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}
?>

<div class="p-6 max-w-5xl mx-auto">
    <!-- Action Header -->
    <div class="flex items-center justify-between mb-8">
        <a href="index.php" class="group flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors">
            <div class="p-2 rounded-full group-hover:bg-blue-50 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </div>
            <span class="font-medium">Kembali ke Daftar</span>
        </a>
        
        <?php if ($_SESSION['role'] !== 'anggota') : ?>
        <div class="flex gap-3">
            <a href="edit.php?id=<?= $id; ?>" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-amber-100 flex items-center gap-2">
                <i class="fas fa-edit text-sm"></i> Edit Buku
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Visual/Cover Mockup -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center">
                <div class="w-48 h-64 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-2xl flex items-center justify-center text-white mb-6 relative overflow-hidden group">
                    <i class="fas fa-book fa-5x opacity-30 group-hover:scale-110 transition-transform duration-500"></i>
                    <div class="absolute bottom-4 left-4 right-4 bg-white/20 backdrop-blur-md p-2 rounded-lg text-[10px] uppercase tracking-tighter text-center">
                        ISBN: <?= $data['isbn']; ?>
                    </div>
                </div>
                <span class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-extrabold uppercase tracking-widest">
                    <?= $data['nama_kategori'] ?? 'Umum'; ?>
                </span>
                <h3 class="mt-4 text-center font-bold text-slate-800 text-xl leading-snug"><?= $data['judul_buku']; ?></h3>
                <p class="text-slate-400 text-sm mt-2 font-medium italic">Tahun Terbit: <?= $data['tahun_terbit']; ?></p>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Informasi -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h4 class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mb-6 border-b border-slate-50 pb-4">Spesifikasi Buku</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                    <div class="space-y-1">
                        <p class="text-slate-400 text-xs font-bold uppercase">Penulis</p>
                        <p class="text-slate-800 font-bold text-lg"><?= $data['nama_penulis'] ?? '-'; ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-slate-400 text-xs font-bold uppercase">Penerbit</p>
                        <p class="text-slate-800 font-bold text-lg"><?= $data['nama_penerbit'] ?? '-'; ?></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-slate-400 text-xs font-bold uppercase">Lokasi Rak</p>
                        <div class="flex items-center gap-2">
                             <span class="p-1.5 bg-slate-100 rounded-lg text-slate-500"><i class="fas fa-layer-group text-xs"></i></span>
                             <p class="text-slate-800 font-bold text-lg"><?= $data['nama_rak'] ?? '-'; ?></p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-slate-400 text-xs font-bold uppercase">Status Ketersediaan</p>
                        <?php if ($data['stok'] > 0) : ?>
                            <div class="flex items-center gap-2 text-emerald-600 font-bold text-lg">
                                <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                Tersedia
                            </div>
                        <?php else : ?>
                            <div class="flex items-center gap-2 text-red-500 font-bold text-lg">
                                <span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                                Kosong
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Card Statistik Stok -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white flex items-center justify-between overflow-hidden relative group">
                <div class="relative z-10">
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-1">Total Stok Tersedia</p>
                    <h2 class="text-5xl font-black italic"><?= $data['stok']; ?> <span class="text-xl font-normal not-italic text-slate-500">Buku</span></h2>
                </div>
                <div class="p-6 bg-white/10 rounded-3xl backdrop-blur-md relative z-10">
                    <i class="fas fa-boxes fa-3x text-blue-400 group-hover:rotate-12 transition-transform"></i>
                </div>
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/20 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>