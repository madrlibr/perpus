<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

$query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY nama_anggota ASC");
?>

<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data Anggota</h2>
            <p class="text-slate-500 mt-1">Manajemen database siswa dan member perpustakaan.</p>
        </div>
        
        <a href="tambah.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-blue-200">
            <i class="fas fa-user-plus text-sm"></i>
            Tambah Anggota
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Profil Anggota</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">NISN</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Gender</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while($row = mysqli_fetch_assoc($query)) : ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-inner">
                                    <?= strtoupper(substr($row['nama_anggota'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 leading-tight"><?= $row['nama_anggota']; ?></h4>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter mt-1">Terdaftar: <?= date('d M Y', strtotime($row['tanggal_mendaftar'])); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-mono font-bold"><?= $row['nisn']; ?></span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if ($row['jenis_kelamin'] == 'L') : ?>
                                <span class="text-blue-500 bg-blue-50 px-2 py-1 rounded text-xs font-bold">Laki-laki</span>
                            <?php else : ?>
                                <span class="text-pink-500 bg-pink-50 px-2 py-1 rounded text-xs font-bold">Perempuan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <p class="text-xs font-medium text-slate-600"><?= $row['no_telp']; ?></p>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus anggota ini?')" class="p-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                                    <i class="fas fa-trash-alt text-sm"></i>
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