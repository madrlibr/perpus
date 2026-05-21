<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

$tgl_mulai = $_GET['tgl_mulai'] ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

// QUERY: Mengambil kolom id_peminjaman asli untuk kebutuhan penandaan hapus massal
$sql = "SELECT p.id as id_transaksi, p.tanggal_pinjam, a.nama_anggota, b.judul_buku, dp.status_buku, 
               peng.kondisi_buku, peng.denda_terlambat
        FROM detail_peminjaman dp
        JOIN peminjaman p ON dp.id_peminjaman = p.id
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON dp.id_buku = b.id
        LEFT JOIN pengembalian peng ON p.id = peng.id_peminjaman
        WHERE p.tanggal_pinjam BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        ORDER BY p.tanggal_pinjam DESC";

$query = mysqli_query($conn, $sql);
?>

<div class="p-6 pb-24 relative"> <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Perpus</h2>
            <p class="text-slate-500 mt-1">Generate dokumen formal sirkulasi buku.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 mb-8">
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Rentang Awal</label>
                <input type="date" name="tgl_mulai" value="<?= $tgl_mulai; ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none">
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Rentang Akhir</label>
                <input type="date" name="tgl_akhir" value="<?= $tgl_akhir; ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 text-white font-bold py-3.5 rounded-xl hover:bg-slate-900 transition-all">Refresh</button>
                <a href="cetak.php?tgl_mulai=<?= $tgl_mulai; ?>&tgl_akhir=<?= $tgl_akhir; ?>" target="_blank" class="flex-1 bg-blue-600 text-white font-bold py-3.5 rounded-xl text-center shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all">Cetak</a>
            </div>
        </form>
    </div>

    <form id="formBulkDelete" method="POST" action="hapus_massal.php" onsubmit="return confirm('Apakah kamu yakin ingin menghapus semua data transaksi terpilih?')">
        
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-4 w-12 text-center">
                                <input type="checkbox" id="checkAll" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Pinjam</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Peminjam</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Buku</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Kondisi</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(mysqli_num_rows($query) > 0) : ?>
                            <?php while($row = mysqli_fetch_assoc($query)) : ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" name="ids_peminjaman[]" value="<?= $row['id_transaksi']; ?>" class="checkItem w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                </td>
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
                                    <?php if($row['status_buku'] == 'kembali' || !empty($row['kondisi_buku'])) : ?>
                                        <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase <?= ($row['kondisi_buku'] ?? 'baik') == 'baik' ? 'bg-emerald-100 text-emerald-600' : (($row['kondisi_buku'] ?? '') == 'rusak' ? 'bg-orange-100 text-orange-600' : 'bg-red-100 text-red-600') ?>">
                                            <?= $row['kondisi_buku'] ?? 'baik'; ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase bg-amber-100 text-amber-600">Dipinjam</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-bold <?= ($row['denda_terlambat'] ?? 0) > 0 ? 'text-red-500' : 'text-slate-400' ?>">
                                    Rp <?= number_format($row['denda_terlambat'] ?? 0, 0, ',', '.'); ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">Tidak ada data pada rentang waktu ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="floatingBatchPanel" class="fixed bottom-6 left-1/2 -translate-x-1/2 transform scale-95 opacity-0 pointer-events-none transition-all duration-300 ease-out z-50 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-6 border border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-300 tracking-wide font-mono uppercase">
                    <span id="countSelected">0</span> Terpilih
                </span>
            </div>
            <div class="h-4 w-[1px] bg-slate-700"></div>
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-black text-xs uppercase tracking-wider px-4 py-2 rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-red-900/20">
                <i class="fas fa-trash-alt text-[10px]"></i> Hapus Sekaligus
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkAll = document.getElementById("checkAll");
    const checkItems = document.querySelectorAll(".checkItem");
    const floatingPanel = document.getElementById("floatingBatchPanel");
    const countSelected = document.getElementById("countSelected");

    function updatePanelVisibility() {
        // Hitung total item yang sedang dicentang saat ini
        const checkedCount = document.querySelectorAll(".checkItem:checked").length;
        countSelected.textContent = checkedCount;

        if (checkedCount > 0) {
            // Tampilkan floating panel dengan efek transisi Tailwind bergaya minimalis futuristik
            floatingPanel.classList.remove("opacity-0", "scale-95", "pointer-events-none");
            floatingPanel.classList.add("opacity-100", "scale-100", "pointer-events-all");
        } else {
            // Sembunyikan panel jika tidak ada checkbox yang aktif
            floatingPanel.classList.add("opacity-0", "scale-95", "pointer-events-none");
            floatingPanel.classList.remove("opacity-100", "scale-100", "pointer-events-all");
        }
    }

    // Event listener untuk checkbox Master (Pilih semua baris)
    checkAll.addEventListener("change", function () {
        checkItems.forEach(item => {
            item.checked = checkAll.checked;
        });
        updatePanelVisibility();
    });

    // Event listener untuk checkbox individual pada tiap baris data
    checkItems.forEach(item => {
        item.addEventListener("change", function () {
            // Jika ada satu baris saja yang dicentang lepas, matikan tanda cetak di checkbox master
            if (!this.checked) {
                checkAll.checked = false;
            } else {
                // Jika seluruh baris dicentang manual, otomatis nyalakan checkbox master
                const totalChecked = document.querySelectorAll(".checkItem:checked").length;
                if (totalChecked === checkItems.length) {
                    checkAll.checked = true;
                }
            }
            updatePanelVisibility();
        });
    });
});
</script>

<?php require_once "../../layout/footer.php"; ?>