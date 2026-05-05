<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas(); 

$id = $_GET['id'];
$sql = "SELECT p.*, a.nama_anggota, a.nisn, b.judul_buku, b.isbn, u.nama_lengkap as petugas, k.tanggal_kembali_aktual, k.denda_terlambat
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON p.id_buku = b.id
        JOIN users u ON p.id_user = u.id
        LEFT JOIN pengembalian k ON p.id = k.id_peminjaman
        WHERE p.id = '$id'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if (!$data) {
    echo "<script>alert('Data transaksi tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}
?>

<div class="p-6 max-w-4xl mx-auto">
    <!-- Header & Navigation -->
    <div class="flex items-center justify-between mb-8">
        <a href="index.php" class="group flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors">
            <div class="p-2 rounded-full group-hover:bg-blue-50 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            <span class="font-medium">Kembali ke Riwayat</span>
        </a>
        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                <i class="fas fa-print"></i> Cetak Detail
            </button>
        </div>
    </div>

    <!-- Main Invoice Card -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <!-- Top Status Bar -->
        <div class="bg-slate-900 p-8 text-white flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                    <i class="fas fa-receipt fa-lg"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">ID Transaksi</p>
                    <h2 class="text-2xl font-black italic">#TRX-<?= str_pad($data['id'], 5, '0', STR_PAD_LEFT); ?></h2>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Status Peminjaman</p>
                <?php if ($data['status_pinjam'] == 'dipinjam') : ?>
                    <span class="px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 text-xs font-black uppercase tracking-tighter">Sedang Dipinjam</span>
                <?php else : ?>
                    <span class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-xs font-black uppercase tracking-tighter">Sudah Kembali</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Kolom Peminjam & Petugas -->
                <div class="space-y-8">
                    <div>
                        <h4 class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-4 border-b pb-2">Informasi Peminjam</h4>
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-slate-100 rounded-xl text-slate-500"><i class="fas fa-user"></i></div>
                            <div>
                                <p class="text-slate-800 font-black text-lg leading-tight"><?= $data['nama_anggota']; ?></p>
                                <p class="text-slate-500 text-sm font-medium mt-1">NISN: <?= $data['nisn']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-4 border-b pb-2">Petugas Penanggung Jawab</h4>
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-slate-100 rounded-xl text-slate-500"><i class="fas fa-user-shield"></i></div>
                            <div>
                                <p class="text-slate-800 font-bold"><?= $data['petugas']; ?></p>
                                <p class="text-slate-400 text-xs uppercase font-bold tracking-tighter">Staff Perpustakaan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Waktu -->
                <div class="space-y-8">
                    <div>
                        <h4 class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-4 border-b pb-2">Timeline Transaksi</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Tanggal Pinjam</p>
                                <p class="text-slate-800 font-bold text-sm"><?= date('d M Y', strtotime($data['tanggal_pinjam'])); ?></p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border-l-4 border-blue-500">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Batas Kembali</p>
                                <p class="text-slate-800 font-bold text-sm"><?= date('d M Y', strtotime($data['tanggal_kembali_seharusnya'])); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if($data['status_pinjam'] == 'kembali') : ?>
                    <div>
                        <h4 class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-4 border-b pb-2">Detail Pengembalian</h4>
                        <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                            <div>
                                <p class="text-[10px] font-black text-emerald-600 uppercase">Tanggal Kembali</p>
                                <p class="text-emerald-900 font-bold"><?= date('d M Y', strtotime($data['tanggal_kembali_seharusnya'])); ?></p>
                            </div>
                            <i class="fas fa-calendar-check text-emerald-200 fa-2x"></i>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bagian Buku -->
            <div class="mt-12 bg-slate-50 rounded-3xl p-6 border border-slate-100 relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-4">Item Yang Dipinjam</h4>
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-20 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-book fa-2x opacity-50"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 leading-tight"><?= $data['judul_buku']; ?></h3>
                            <p class="text-slate-500 font-medium text-sm mt-1">ISBN: <?= $data['isbn']; ?></p>
                        </div>
                    </div>
                </div>
                <i class="fas fa-bookmark absolute -right-4 -top-4 text-slate-200/50 fa-6x rotate-12"></i>
            </div>

            <!-- Bagian Denda -->
            <?php if($data['status_pinjam'] == 'kembali' && $data['denda_terlambat'] > 0) : ?>
            <div class="mt-8 bg-red-50 border-2 border-dashed border-red-200 rounded-3xl p-6 flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-4 mb-4 md:mb-0">
                    <div class="p-4 bg-red-500 text-white rounded-2xl shadow-lg shadow-red-200">
                        <i class="fas fa-hand-holding-usd fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-red-600 font-black text-xs uppercase tracking-widest">Informasi Denda</p>
                        <p class="text-red-400 text-sm font-medium">Terlambat mengembalikan dari batas waktu</p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <h2 class="text-3xl font-black text-red-600">Rp <?= number_format($data['denda_terlambat'], 0, ',', '.'); ?></h2>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .navbar, .flex.items-center.justify-between.mb-8 {
        display: none !important;
    }
    .p-6 {
        padding: 0 !important;
    }
    .bg-white {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

<?php require_once "../../layout/footer.php"; ?>