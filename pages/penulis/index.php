<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM penulis WHERE 1=1";
if ($search != '') {
    $sql .= " AND nama_penulis LIKE '%$search%'";
}
$sql .= " ORDER BY nama_penulis ASC";
$query = mysqli_query($conn, $sql);

?>

<div class="mb-8 bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm">
    <form method="GET" class="flex gap-3">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="<?= $search ?>" placeholder="Cari Penulis..." 
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
        </div>
        <button type="submit" class="bg-slate-800 text-white px-6 py-3 rounded-xl font-bold">Cari</button>
        <?php if($search != '') : ?>
            <a href="index.php" class="bg-red-50 text-red-600 px-4 py-3 rounded-xl flex items-center justify-center"><i class="fas fa-times"></i></a>
        <?php endif; ?>
    </form>
</div>

<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Penulis</h2>
            <p class="text-slate-500 mt-1">Total kontributor karya di perpustakaan.</p>
        </div>
        <a href="tambah.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-6 py-3 rounded-2xl transition-all shadow-lg shadow-amber-100 text-sm">
            <i class="fas fa-plus mr-2"></i> Tambah Penulis
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-8 py-5">Nama Penulis</th>
                    <th class="px-8 py-5">Biografi Singkat</th>
                    <th class="px-8 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php while($row = mysqli_fetch_assoc($query)) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center font-bold">
                                <?= substr($row['nama_penulis'], 0, 1) ?>
                            </div>
                            <span class="font-bold text-slate-700"><?= $row['nama_penulis'] ?></span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500 italic">
                        <?= $row['biografi'] ?: '<span class="text-slate-300">Tidak ada data</span>' ?>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><i class="fas fa-edit text-xs"></i></a>
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

<?php require_once "../../layout/footer.php"; ?>