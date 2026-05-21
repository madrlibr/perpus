<?php
require_once "../../konek.php";
proteksi_admin_petugas(); // Hanya admin/petugas yang boleh akses
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

// 1. Ambil data denda yang sedang aktif
$query = mysqli_query($conn, "SELECT * FROM pengaturan_denda WHERE status_aktif = 1 LIMIT 1");
$data_denda = mysqli_fetch_assoc($query);

// 2. Proses Update Denda
if (isset($_POST['update_denda'])) {
    $harga_baru = $_POST['harga_denda'];
    
    // Opsional: Matikan semua status_aktif yang lama (jika ingin menyimpan riwayat)
    // mysqli_query($conn, "UPDATE pengaturan_denda SET status_aktif = 0");
    
    // Update harga denda yang sedang aktif
    $update = mysqli_query($conn, "UPDATE pengaturan_denda SET harga_denda_per_hari = '$harga_baru' WHERE status_aktif = 1");

    if ($update) {
        $_SESSION['notif'] = [
            'tipe' => 'success',
            'judul' => 'Berhasil!',
            'pesan' => 'Tarif denda berhasil diperbarui menjadi Rp ' . number_format($harga_baru, 0, ',', '.')
        ];
        echo "<script>window.location.href='pengaturan.php';</script>";
        exit;
    }
}
?>

<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="index.php" class="text-blue-600 hover:underline text-sm font-medium mb-2 inline-block">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Transaksi
        </a>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Konfigurasi Denda</h2>
        <p class="text-slate-500">Atur besaran denda keterlambatan pengembalian buku.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1">
            <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-coins fa-2x"></i>
                </div>
                
                <form action="" method="POST">
                    <div class="mb-6">
                        <label class="block text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Tarif Denda (Per Hari)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                            <input type="number" name="harga_denda" 
                                   value="<?= $data_denda['harga_denda_per_hari'] ?? 0; ?>" 
                                   class="w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all font-black text-xl text-slate-800" 
                                   required>
                        </div>
                    </div>
                    
                    <button type="submit" name="update_denda" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden h-full">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-4">Bagaimana denda bekerja?</h3>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li class="flex gap-3">
                            <div class="mt-1 w-5 h-5 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 shrink-0">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>
                            <p>Sistem akan menghitung selisih hari antara <span class="text-white">Tanggal Kembali Seharusnya</span> dengan hari ini.</p>
                        </li>
                        <li class="flex gap-3">
                            <div class="mt-1 w-5 h-5 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 shrink-0">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>
                            <p>Denda hanya akan muncul jika buku dikembalikan <span class="text-white">melewati batas waktu</span> yang ditentukan.</p>
                        </li>
                        <li class="flex gap-3">
                            <div class="mt-1 w-5 h-5 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 shrink-0">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>
                            <p>Perubahan tarif denda hanya akan berlaku untuk transaksi pengembalian <span class="text-white">setelah</span> tombol simpan ditekan.</p>
                        </li>
                    </ul>

                    <div class="mt-8 p-4 bg-white/5 border border-white/10 rounded-2xl">
                        <p class="text-xs font-medium text-slate-400">Tarif Saat Ini:</p>
                        <p class="text-2xl font-black text-blue-400">Rp <?= number_format($data_denda['harga_denda_per_hari'] ?? 0, 0, ',', '.'); ?> <span class="text-xs text-slate-500 font-normal">/ hari keterlambatan</span></p>
                    </div>
                </div>
                
                <i class="fas fa-calculator absolute -right-8 -bottom-8 text-white/5 fa-9x -rotate-12"></i>
            </div>
        </div>

    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>