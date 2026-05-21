<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

// Mengambil input search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query Menggunakan Subquery untuk menghitung jumlah buku
// Pencarian dilakukan pada nama_anggota atau nisn
$sql = "SELECT p.*, a.nama_anggota, a.nisn,
        (SELECT COUNT(*) FROM detail_peminjaman WHERE id_peminjaman = p.id) as total_qty,
        (SELECT COUNT(*) FROM detail_peminjaman WHERE id_peminjaman = p.id AND status_buku = 'dipinjam') as sisa_qty
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id";

if ($search != '') {
    $sql .= " WHERE a.nama_anggota LIKE '%$search%' OR a.nisn LIKE '%$search%'";
}

$sql .= " ORDER BY p.id DESC";

$query = mysqli_query($conn, $sql);
?>

<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Riwayat Transaksi</h2>
            <p class="text-slate-500">Kelola peminjaman multi-buku secara efisien.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="pengaturan.php" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:shadow-sm transition-all" title="Pengaturan Laporan">
                <i class="fas fa-cog"></i>
            </a>
            <a href="scan.php" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg"><i class="fas fa-qrcode mr-2"></i> Scan</a>
            <a href="tambah.php" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg"><i class="fas fa-plus-circle mr-2"></i> Pinjam Baru</a>
        </div>
    </div>

    <!-- Fitur Search -->
    <div class="mb-6">
        <form action="" method="GET" class="relative max-w-md">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                   placeholder="Cari nama anggota atau NISN..." 
                   class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-50 focus:border-blue-400 transition-all shadow-sm">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <i class="fas fa-search"></i>
            </div>
            <?php if($search != ''): ?>
                <a href="index.php" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500">
                    <i class="fas fa-times-circle"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Peminjam</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase">Jumlah Buku</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Batas Kembali</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if(mysqli_num_rows($query) > 0) : ?>
                    <?php while($row = mysqli_fetch_assoc($query)) : ?>
                    <tr class="hover:bg-slate-50/50 transition-all">
                        <td class="px-6 py-5">
                            <div class="font-bold text-slate-700"><?= $row['nama_anggota'] ?></div>
                            <div class="text-[10px] text-slate-400 tracking-widest uppercase"><?= $row['nisn'] ?></div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-black">
                                <?= $row['total_qty'] ?> BUKU
                            </span>
                            <?php if($row['sisa_qty'] > 0) : ?>
                                <span class="text-[10px] text-slate-400 ml-1">Sisa <?= $row['sisa_qty'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-5 text-center text-xs font-bold text-slate-500">
                            <?= date('d M Y', strtotime($row['tanggal_kembali_seharusnya'])) ?>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if($row['sisa_qty'] > 0) : ?>
                                <span class="text-[10px] font-black text-amber-500 bg-amber-50 px-2 py-1 rounded-md uppercase">Dipinjam</span>
                            <?php else : ?>
                                <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md uppercase">Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end gap-2">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="px-4 py-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 rounded-xl transition-all text-xs font-bold flex items-center gap-2">
                                    <i class="fas fa-list-ul"></i> Detail
                                </a>
                                <button onclick="konfirmasiHapus('hapus.php?id=<?= $row['id'] ?>')" 
                                        class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="text-slate-300 mb-4"><i class="fas fa-search fa-3x"></i></div>
                            <div class="text-slate-500 font-bold">Data tidak ditemukan</div>
                            <div class="text-slate-400 text-sm">Coba kata kunci lain atau bersihkan pencarian</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>