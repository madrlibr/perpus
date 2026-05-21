<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM rak WHERE 1=1";
if ($search != '') {
    $sql .= " AND nama_rak LIKE '%$search%'";
}
$sql .= " ORDER BY nama_rak ASC";
$query = mysqli_query($conn, $sql);

?>

<div class="mb-8 bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm">
    <form method="GET" class="flex gap-3">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="<?= $search ?>" placeholder="Cari Rak..." 
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
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Manajemen Rak</h2>
            <p class="text-slate-500 mt-1">Atur penempatan buku berdasarkan kategori.</p>
        </div>
        <a href="tambah.php" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-6 py-3 rounded-2xl transition-all shadow-lg shadow-rose-100 text-sm">
            <i class="fas fa-layer-group mr-2"></i> Tambah Rak
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while($row = mysqli_fetch_assoc($query)) : ?>
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-columns"></i>
                </div>
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="edit.php?id=<?= $row['id'] ?>" class="text-slate-400 hover:text-rose-600"><i class="fas fa-edit"></i></a>
                    <button onclick="konfirmasiHapus('hapus.php?id=<?= $row['id'] ?>')" 
                            class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                      <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-1"><?= $row['nama_rak'] ?></h3>
            <p class="text-sm text-slate-500 flex items-center gap-2">
                <i class="fas fa-map-pin text-rose-300"></i> <?= $row['lokasi'] ?>
            </p>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>