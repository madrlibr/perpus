<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

// Query ambil data buku beserta kategorinya (asumsi ada join ke tabel kategori)
$query = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori 
                              FROM buku 
                              LEFT JOIN kategori ON buku.id_kategori = kategori.id 
                              ORDER BY buku.id DESC");
?>

<div class="p-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Koleksi Buku</h2>
            <p class="text-slate-500 mt-1">Kelola seluruh data pustaka dalam satu tempat.</p>
        </div>
        
        <?php if ($_SESSION['role'] !== 'anggota') : ?>
        <a href="tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95">
            <i class="fas fa-plus text-sm"></i>
            Tambah Buku Baru
        </a>
        <?php endif; ?>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Informasi Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($query)) : 
                    ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-5 text-sm text-slate-500 font-medium">
                            <?= $no++; ?>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors">
                                    <i class="fas fa-book fa-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 leading-tight mb-1"><?= $row['judul_buku']; ?></h4>
                                    <p class="text-xs text-slate-400 font-medium italic">Oleh: <?= $row['penulis'] ?? 'Anonim'; ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 rounded-full bg-violet-50 text-violet-600 text-xs font-bold">
                                <?= $row['nama_kategori'] ?? 'Umum'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-sm font-bold <?= $row['stok'] > 0 ? 'text-slate-700' : 'text-red-500'; ?>">
                                <?= $row['stok']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="detail.php?id=<?= $row['id']; ?>" class="p-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-500 rounded-xl transition-all" title="Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                
                                <?php if ($_SESSION['role'] !== 'anggota') : ?>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="p-2 bg-slate-100 hover:bg-amber-500 hover:text-white text-slate-500 rounded-xl transition-all" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" 
                                   class="p-2 bg-slate-100 hover:bg-red-600 hover:text-white text-slate-500 rounded-xl transition-all" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (mysqli_num_rows($query) == 0) : ?>
        <div class="p-20 text-center">
            <div class="bg-slate-50 inline-flex p-6 rounded-full mb-4">
                <i class="fas fa-folder-open fa-3x text-slate-200"></i>
            </div>
            <p class="text-slate-400 font-medium">Belum ada data buku yang tersimpan.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>