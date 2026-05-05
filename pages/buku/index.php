<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
proteksi_admin_petugas();

// Ambil parameter filter
$search   = $_GET['search'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$penulis  = $_GET['penulis'] ?? '';

// Build Query dengan Filter
$sql = "SELECT b.*, k.nama_kategori, p.nama_penulis, pr.nama_penerbit, r.nama_rak 
        FROM buku b
        LEFT JOIN kategori k ON b.id_kategori = k.id
        LEFT JOIN penulis p ON b.id_penulis = p.id
        LEFT JOIN penerbit pr ON b.id_penerbit = pr.id
        LEFT JOIN rak r ON b.id_rak = r.id
        WHERE 1=1";

if ($search != '') {
    $sql .= " AND (b.judul_buku LIKE '%$search%' OR b.isbn LIKE '%$search%')";
}
if ($kategori != '') {
    $sql .= " AND b.id_kategori = '$kategori'";
}
if ($penulis != '') {
    $sql .= " AND b.id_penulis = '$penulis'";
}

$sql .= " ORDER BY b.id DESC";
$query = mysqli_query($conn, $sql);
?>

<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Koleksi Buku</h2>
            <p class="text-slate-500 mt-1">Manajemen data buku dan stok perpustakaan.</p>
        </div>
        <a href="tambah.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-2xl transition-all flex items-center gap-2 shadow-lg shadow-blue-200 text-sm">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-6 mb-8">
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search Text -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Cari Judul / ISBN</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="<?= $search; ?>" placeholder="Masukkan kata kunci..."
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm">
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Kategori</label>
                <select name="kategori" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm appearance-none">
                    <option value="">Semua Kategori</option>
                    <?php
                    $kat_opt = mysqli_query($conn, "SELECT * FROM kategori");
                    while($k = mysqli_fetch_assoc($kat_opt)) :
                    ?>
                        <option value="<?= $k['id']; ?>" <?= $kategori == $k['id'] ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Filter Penulis -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Penulis</label>
                <select name="penulis" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm appearance-none">
                    <option value="">Semua Penulis</option>
                    <?php
                    $pen_opt = mysqli_query($conn, "SELECT * FROM penulis");
                    while($p = mysqli_fetch_assoc($pen_opt)) :
                    ?>
                        <option value="<?= $p['id']; ?>" <?= $penulis == $p['id'] ? 'selected' : ''; ?>><?= $p['nama_penulis']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-xl transition-all text-sm">
                    Filter
                </button>
                <?php if($search != '' || $kategori != '' || $penulis != '') : ?>
                    <a href="index.php" class="w-12 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center rounded-xl transition-all">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Buku -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Buku</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori & Rak</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(mysqli_num_rows($query) > 0) : ?>
                        <?php while($row = mysqli_fetch_assoc($query)) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 mb-1"><?= $row['judul_buku']; ?></div>
                                <div class="text-[11px] text-slate-400 flex items-center gap-2">
                                    <span class="bg-slate-100 px-1.5 py-0.5 rounded">ISBN: <?= $row['isbn'] ?: '-'; ?></span>
                                    <span>&bull;</span>
                                    <span class="italic"><?= $row['nama_penulis'] ?: 'Tanpa Penulis'; ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-black <?= $row['stok'] > 0 ? 'text-emerald-600' : 'text-red-500' ?>">
                                    <?= $row['stok']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-600">
                                <div class="flex flex-col gap-1">
                                    <span class="text-blue-600"><?= $row['nama_kategori'] ?: 'Umum'; ?></span>
                                    <span class="text-slate-400 italic"><?= $row['nama_rak'] ?: 'Belum diatur'; ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus buku ini?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                        <i class="fas fa-trash text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                <i class="fas fa-search block text-4xl mb-4 opacity-10"></i>
                                <p class="font-medium">Buku tidak ditemukan.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>