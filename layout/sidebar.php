<?php
// Mendeteksi folder aktif untuk class 'active'
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$base_url = "http://localhost/library"; // Sesuaikan dengan URL lokalmu

$role = $_SESSION['role'] ?? 'anggota'; 
?>

<aside id="mainSidebar" class="fixed left-0 top-16 h-screen w-64 bg-white border-r border-slate-100 z-40 overflow-y-auto pb-20">
    <div class="p-4 space-y-2">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-2 opacity-50">Main Menu</p>
        
            <a href="<?= $base_url; ?>/pages/dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold <?= $current_dir == 'pages' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-600 hover:bg-slate-50' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg"><i class="fas fa-home-alt text-xs"></i></div>
                <span class="nav-label">Dashboard</span>
            </a>

        <?php if ($role == 'petugas' || $role == 'admin') : ?>
            <a href="<?= $base_url; ?>/pages/transaksi/index.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold <?= $current_dir == 'transaksi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-600 hover:bg-slate-50' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg"><i class="fas fa-exchange-alt text-xs"></i></div>
                <span class="nav-label">Transaksi</span>
            </a>

            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mt-6 mb-2 opacity-50">Manajemen Data</p>

            <a href="<?= $base_url; ?>/pages/buku/index.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold <?= $current_dir == 'buku' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-600 hover:bg-slate-50' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg"><i class="fas fa-book text-xs"></i></div>
                <span class="nav-label">Data Buku</span>
            </a>

            <a href="<?= $base_url; ?>/pages/anggota/index.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold <?= $current_dir == 'anggota' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-600 hover:bg-slate-50' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg"><i class="fas fa-users text-xs"></i></div>
                <span class="nav-label">Anggota</span>
            </a>

            <a href="<?= $base_url; ?>/pages/laporan/index.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold <?= $current_dir == 'laporan' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-600 hover:bg-slate-50' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg"><i class="fas fa-pen text-xs"></i></div>
                <span class="nav-label">Laporan</span>
            </a>

        <?php endif; ?> 

        <?php if ($role == 'anggota') : ?>
            <a href="<?= $base_url; ?>/pages/buku/index.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold <?= $current_dir == 'buku' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-600 hover:bg-slate-50' ?>">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg"><i class="fas fa-search text-xs"></i></div>
                <span class="nav-label">Katalog Buku</span>
            </a>
        <?php endif; ?>

        <?php if ($role == 'admin') : ?>
            <hr class="border-slate-50 my-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mt-6 mb-2 opacity-50">Master Data</p>
            <div class="grid grid-cols-2 gap-2 px-2">
                <a href="<?= $base_url; ?>/pages/kategori/index.php" class="text-[11px] font-bold p-2 bg-slate-50 rounded-xl text-center hover:bg-blue-50 hover:text-blue-600 transition-all">Kategori</a>
                <a href="<?= $base_url; ?>/pages/penulis/index.php" class="text-[11px] font-bold p-2 bg-slate-50 rounded-xl text-center hover:bg-amber-50 hover:text-amber-600 transition-all">Penulis</a>
                <a href="<?= $base_url; ?>/pages/penerbit/index.php" class="text-[11px] font-bold p-2 bg-slate-50 rounded-xl text-center hover:bg-purple-50 hover:text-purple-600 transition-all">Penerbit</a>
                <a href="<?= $base_url; ?>/pages/rak/index.php" class="text-[11px] font-bold p-2 bg-slate-50 rounded-xl text-center hover:bg-red-50 hover:text-red-600 transition-all">Rak</a>
            </div>

            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4 mt-6 mb-2 opacity-50">Special Tools</p>
                <a href="<?= $base_url; ?>/pages/quickadd/tambah.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all font-bold text-emerald-600 hover:bg-emerald-50">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-100"><i class="fas fa-bolt text-xs"></i></div>
                    <span class="nav-label">Quick Add</span>
                </a>
        <?php endif; ?>

        <button onclick="logoutKonfirmasi('<?= $base_url; ?>/logout.php')" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-500 hover:bg-red-50 transition-all font-bold group">
            <div class="w-8 h-8 flex items-center justify-center bg-red-50 group-hover:bg-red-100 rounded-lg transition-all">
                <i class="fas fa-power-off text-xs"></i>
            </div>
            <span class="nav-label">Logout</span>
        </button>
    </div>
</aside>
<?php require_once "footer.php"; ?>
<main id="mainContent" class="ml-64 pt-20 p-6 min-h-screen transition-all duration-300">
    