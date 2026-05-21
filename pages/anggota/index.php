<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

$search = $_GET['search'] ?? '';

// Query Dasar
$sql = "SELECT * FROM anggota WHERE 1=1";

if ($search != '') {
    $sql .= " AND (nama_anggota LIKE '%$search%' OR nisn LIKE '%$search%')";
}

$sql .= " ORDER BY nama_anggota ASC";
$query = mysqli_query($conn, $sql);

?>

<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data Anggota</h2>
            <p class="text-slate-500 mt-1">Kelola informasi siswa dan anggota perpustakaan.</p>
        </div>
        <a href="tambah.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-2xl transition-all shadow-lg shadow-blue-200 text-sm">
            <i class="fas fa-user-plus mr-2"></i> Tambah Anggota
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 mb-8">
        <form method="GET" action="" class="flex gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="<?= $search; ?>" placeholder="Cari Nama Anggota atau NISN..." 
                       class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-900 transition-all">Cari</button>
            <?php if($search != '') : ?>
                <a href="index.php" class="bg-red-50 text-red-600 px-4 py-3 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                    <i class="fas fa-times"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Table Anggota -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-6 py-4">NISN</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Kontak & Alamat</th>
                    <th class="px-6 py-4">Jenis Kelamin</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php while($row = mysqli_fetch_assoc($query)) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-blue-600 font-bold"><?= $row['nisn']; ?></td>
                    <td class="px-6 py-4 font-bold text-slate-800"><?= $row['nama_anggota']; ?></td>
                    <td class="px-6 py-4 text-xs text-slate-500">
                        <div><i class="fas fa-phone mr-1"></i> <?= $row['no_telp'] ?: '-'; ?></div>
                        <div class="italic"><i class="fas fa-map-marker-alt mr-1"></i> <?= $row['alamat'] ?: '-'; ?></div>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-800"><?= $row['jenis_kelamin']; ?></td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><i class="fas fa-edit text-xs"></i></a>
                            <button onclick="konfirmasiHapus('hapus.php?id=<?= $row['id'] ?>')" 
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>