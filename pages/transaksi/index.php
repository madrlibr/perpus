<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

// Query disesuaikan dengan kolom: nama_anggota dan status_pinjam
$query = mysqli_query($conn, "SELECT peminjaman.*, anggota.nama_anggota, buku.judul_buku 
                              FROM peminjaman 
                              JOIN anggota ON peminjaman.id_anggota = anggota.id 
                              JOIN buku ON peminjaman.id_buku = buku.id 
                              ORDER BY peminjaman.id DESC");
?>

<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Transaksi</h2>
            <p class="text-slate-500 mt-1">Kelola peminjaman dan pengembalian buku pustaka.</p>
        </div>
        
        <?php if ($_SESSION['role'] !== 'anggota') : ?>
        <a href="tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-blue-200">
            <i class="fas fa-plus-circle text-sm"></i>
            Tambah Pinjaman
        </a>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Peminjam</th>l
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Batas Kembali</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while($row = mysqli_fetch_assoc($query)) : ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold text-xs">
                                    #<?= $row['id']; ?>
                                </div>
                                <h4 class="font-bold text-slate-800 leading-tight"><?= $row['judul_buku']; ?></h4>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-semibold text-slate-700"><?= $row['nama_anggota']; ?></p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-medium text-slate-600"><?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?></span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-medium text-slate-600"><?= date('d M Y', strtotime($row['tanggal_kembali_seharusnya'])); ?></span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if ($row['status_pinjam'] == 'dipinjam') : ?>
                                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider border border-amber-100">Dipinjam</span>
                            <?php else : ?>
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <!-- Tombol Kembali (Hanya jika masih dipinjam) -->
                                <?php if ($row['status_pinjam'] == 'dipinjam' && $_SESSION['role'] !== 'anggota') : ?>
                                <a href="kembali.php?id=<?= $row['id']; ?>" 
                                   onclick="return confirm('Konfirmasi pengembalian buku?')"
                                   class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-emerald-100">
                                    <i class="fas fa-check-circle mr-1"></i> Kembali
                                </a>
                                <?php endif; ?>

                                <!-- Tombol Hapus (Hanya jika status sudah kembali) -->
                                <?php if ($row['status_pinjam'] == 'kembali' && $_SESSION['role'] !== 'anggota') : ?>
                                <a href="hapus.php?id=<?= $row['id']; ?>" 
                                   onclick="return confirm('Hapus riwayat transaksi ini?')"
                                   class="p-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <?php endif; ?>
                                
                                <a href="detail.php?id=<?= $row['id']; ?>" class="p-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-500 rounded-lg transition-all">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>