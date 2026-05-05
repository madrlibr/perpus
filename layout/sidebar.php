<!-- Sidebar Container -->
<aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col shadow-xl">
    <div class="p-6">
        <div class="flex items-center gap-3 text-white mb-8">
            <div class="bg-blue-600 p-2 rounded-lg">
                <i class="fas fa-book-open"></i>
            </div>
            <span class="text-xl font-bold tracking-wider">PERPUS NURIS</span>
        </div>

        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="<?= BASE_URL; ?>pages/dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <i class="fas fa-home w-5 group-hover:text-blue-400"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Data Buku -->
            <a href="<?= BASE_URL; ?>pages/buku/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <i class="fas fa-book w-5 group-hover:text-blue-400"></i>
                <span class="font-medium">Data Buku</span>
            </a>

            <!-- Menu Admin & Petugas -->
            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas'): ?>
            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-slate-500 uppercase px-4 tracking-widest">Manajemen</p>
            </div>
            
            <a href="<?= BASE_URL; ?>pages/transaksi/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <i class="fas fa-exchange-alt w-5 group-hover:text-blue-400"></i>
                <span class="font-medium">Transaksi</span>
            </a>
            
            <a href="<?= BASE_URL; ?>pages/anggota/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <i class="fas fa-users w-5 group-hover:text-blue-400"></i>
                <span class="font-medium">Anggota</span>
            </a>
            <?php endif; ?>

            <!-- Menu Khusus Admin -->
            <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-slate-500 uppercase px-4 tracking-widest">Administrator</p>
            </div>

            <a href="<?= BASE_URL; ?>pages/laporan/index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <i class="fas fa-file-alt w-5 group-hover:text-blue-400"></i>
                <span class="font-medium">Laporan</span>
            </a>

            <!-- Master Data Dropdown -->
            <div class="relative">
                <button onclick="toggleDropdown()" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-database w-5 group-hover:text-blue-400"></i>
                        <span class="font-medium">Master Data</span>
                    </div>
                    <i id="arrow-icon" class="fas fa-angle-down text-xs transition-transform duration-300"></i>
                </button>
                
                <div id="dropdown-master" class="hidden flex-col mt-2 ml-4 border-l-2 border-slate-800 space-y-1">
                    <a href="<?= BASE_URL; ?>pages/kategori/index.php" class="pl-8 py-2 text-sm hover:text-blue-400 transition-colors">Data Kategori</a>
                    <a href="<?= BASE_URL; ?>pages/penulis/index.php" class="pl-8 py-2 text-sm hover:text-blue-400 transition-colors">Data Penulis</a>
                    <a href="<?= BASE_URL; ?>pages/penerbit/index.php" class="pl-8 py-2 text-sm hover:text-blue-400 transition-colors">Data Penerbit</a>
                    <a href="<?= BASE_URL; ?>pages/rak/index.php" class="pl-8 py-2 text-sm hover:text-blue-400 transition-colors">Data Rak</a>
                </div>
            </div>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Logout at Bottom -->
    <div class="mt-auto p-6 border-t border-slate-800">
        <a href="<?= BASE_URL; ?>logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all group">
            <i class="fas fa-sign-out-alt w-5"></i>
            <span class="font-bold">Keluar</span>
        </a>
    </div>
</aside>

<!-- Script Dropdown Sidebar -->
<script>
function toggleDropdown() {
    const dropdown = document.getElementById('dropdown-master');
    const arrow = document.getElementById('arrow-icon');
    dropdown.classList.toggle('hidden');
    dropdown.classList.toggle('flex');
    arrow.classList.toggle('rotate-180');
}
</script>

<!-- Content Area Wrapper -->
<main class="flex-1 overflow-y-auto bg-slate-50 h-screen">