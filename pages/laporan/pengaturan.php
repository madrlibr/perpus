<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

// Logika Hapus Seluruh Riwayat Laporan
if (isset($_POST['clear_log'])) {
    $query = mysqli_query($conn, "TRUNCATE TABLE laporan");

    if ($query) {
        $status = "success";
        $pesan = "Seluruh riwayat laporan berhasil dibersihkan!";
    } else {
        $status = "error";
        $pesan = "Gagal membersihkan riwayat: " . mysqli_error($conn);
    }
}

// Ambil jumlah log saat ini untuk statistik
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan");
$total_log = mysqli_fetch_assoc($count_query)['total'];
?>

<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Pengaturan Laporan</h2>
        <p class="text-slate-500 mt-1">Kelola pemeliharaan data dan log sistem laporan.</p>
    </div>

    <?php if (isset($status)) : ?>
        <div class="mb-6 p-4 rounded-2xl flex items-center gap-3 <?= $status == 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' ?>">
            <i class="fas <?= $status == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
            <span class="font-bold text-sm"><?= $pesan; ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Statistik -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-database"></i>
            </div>
            <h4 class="text-slate-400 font-black text-[10px] uppercase tracking-widest mb-1">Total Riwayat Saat Ini</h4>
            <h2 class="text-4xl font-black text-slate-800"><?= number_format($total_log); ?> <span class="text-lg font-medium text-slate-400">Log</span></h2>
            <p class="text-slate-400 text-xs mt-4 leading-relaxed">Setiap kali laporan dicetak, sistem akan mencatat aktivitas tersebut ke dalam database untuk keperluan audit.</p>
        </div>

        <!-- Card Aksi Pembersihan -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-trash-alt"></i>
            </div>
            <h4 class="text-slate-800 font-bold text-lg mb-2">Kosongkan Log</h4>
            <p class="text-slate-500 text-sm mb-6">Menghapus seluruh catatan aktivitas cetak laporan secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
            
            <form action="" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH riwayat laporan? Tindakan ini tidak bisa dibatalkan!')">
                <button type="submit" name="clear_log" 
                        class="w-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2"
                        <?= $total_log == 0 ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : ''; ?>>
                    <i class="fas fa-eraser"></i> Clear All Logs
                </button>
            </form>
        </div>
    </div>

    <!-- Info Tambahan -->
    <div class="mt-8 bg-slate-800 rounded-[2rem] p-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h4 class="font-bold mb-2">Tips Pemeliharaan</h4>
            <p class="text-slate-400 text-sm leading-relaxed max-w-xl">
                Sebaiknya bersihkan log secara berkala (misalnya setiap akhir semester) untuk menjaga performa database tetap optimal jika data transaksi sudah mencapai puluhan ribu baris.
            </p>
        </div>
        <i class="fas fa-shield-alt absolute -right-4 -bottom-4 text-white/5 fa-6x rotate-12"></i>
    </div>
</div>

<!-- Tambahkan ini di bagian paling bawah pengaturan.php untuk melihat isi log -->
<div class="mt-8 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50">
        <h3 class="font-bold text-slate-800">Riwayat Aktivitas Cetak (Log)</h3>
    </div>
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase">Waktu</th>
                <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase">Petugas</th>
                <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase">Aktivitas</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php
            $logs = mysqli_query($conn, "SELECT l.*, u.nama_lengkap FROM laporan l JOIN users u ON l.id_user = u.id ORDER BY l.tanggal_dibuat DESC LIMIT 5");
            while($log = mysqli_fetch_assoc($logs)):
            ?>
            <tr>
                <td class="px-6 py-4 text-xs text-slate-500"><?= $log['tanggal_dibuat']; ?></td>
                <td class="px-6 py-4 text-xs font-bold text-slate-700"><?= $log['nama_lengkap']; ?></td>
                <td class="px-6 py-4 text-xs text-slate-600"><?= $log['isi_laporan']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once "../../layout/footer.php"; ?>