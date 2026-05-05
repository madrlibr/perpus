<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

// Mencegah error Undefined Index dengan null coalescing operator
$tgl_mulai = $_GET['tgl_mulai'] ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

// Query tetap mengambil data transaksi untuk ditampilkan di tabel preview
$sql = "SELECT p.*, a.nama_anggota, b.judul_buku, u.nama_lengkap as petugas 
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON p.id_buku = b.id
        JOIN users u ON p.id_user = u.id
        WHERE p.tanggal_pinjam BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        ORDER BY p.tanggal_pinjam DESC";

$query = mysqli_query($conn, $sql);
?>

<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Perpus</h2>
                <p class="text-slate-500 mt-1">Generate dokumen formal sirkulasi buku.</p>
            </div>
            <!-- Tombol Pengaturan Baru -->
            <a href="pengaturan.php" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:shadow-sm transition-all" title="Pengaturan Laporan">
                <i class="fas fa-cog"></i>
            </a>
        </div>
        <div class="hidden md:block bg-blue-50 px-4 py-2 rounded-2xl border border-blue-100">
            <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">Database Linked</span>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 mb-8">
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Rentang Awal</label>
                <input type="date" name="tgl_mulai" value="<?= $tgl_mulai; ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Rentang Akhir</label>
                <input type="date" name="tgl_akhir" value="<?= $tgl_akhir; ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-sync-alt text-xs"></i> Refresh
                </button>
                <a href="cetak.php?tgl_mulai=<?= $tgl_mulai; ?>&tgl_akhir=<?= $tgl_akhir; ?>" target="_blank" 
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-200">
                    <i class="fas fa-file-invoice text-xs"></i> Cetak
                </a>
            </div>
        </form>
    </div>

    <!-- Table Preview -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Peminjam</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Buku</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(mysqli_num_rows($query) > 0) : ?>
                        <?php while($row = mysqli_fetch_assoc($query)) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600 font-mono">
                                <?= date('d/m/Y', strtotime($row['tanggal_pinjam'])); ?>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-800"><?= $row['nama_anggota']; ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 italic">"<?= $row['judul_buku']; ?>"</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-tighter <?= $row['status_pinjam'] == 'kembali' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' ?>">
                                    <?= $row['status_pinjam']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">
                                <i class="fas fa-folder-open block text-3xl mb-2 opacity-20"></i>
                                Tidak ada data pada rentang waktu ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>