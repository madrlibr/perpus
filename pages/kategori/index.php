<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

$query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id DESC");
?>

<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kategori Buku</h2>
            <p class="text-slate-500 mt-1">Kelola pengelompokan koleksi buku perpustakaan.</p>
        </div>
        <a href="tambah.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-2xl transition-all flex items-center gap-2 shadow-lg shadow-blue-200">
            <i class="fas fa-plus text-xs"></i> Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-20">ID</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Kategori</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php while($row = mysqli_fetch_assoc($query)) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-bold text-slate-400">#<?= $row['id']; ?></td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800"><?= $row['nama_kategori']; ?></td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus kategori ini?')" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                            <i class="fas fa-trash text-xs"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>