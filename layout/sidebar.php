<ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= BASE_URL; ?>pages/dashboard.php" class="nav-link text-white">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>
        
        <!-- Menu Semua Role -->
        <li>
            <a href="<?= BASE_URL; ?>pages/buku/index.php" class="nav-link text-white">
                <i class="fas fa-book me-2"></i> Data Buku
            </a>
        </li>

        <!-- Menu Admin & Petugas -->
        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas'): ?>
        <li>
            <a href="<?= BASE_URL; ?>pages/transaksi/index.php" class="nav-link text-white">
                <i class="fas fa-exchange-alt me-2"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL; ?>pages/anggota/index.php" class="nav-link text-white">
                <i class="fas fa-users me-2"></i> Anggota
            </a>
        </li>
        <?php endif; ?>

        <!-- Menu Khusus Admin Saja -->
        <?php if ($_SESSION['role'] == 'admin'): ?>
        <hr>
        <li>
            <a href="<?= BASE_URL; ?>pages/laporan/index.php" class="nav-link text-white">
                <i class="fas fa-file-alt me-2"></i> Laporan
            </a>
        </li>
        <!-- Bagian Navigasi Master Data -->
<li class="nav-item">
    <!-- Tombol Dropdown Utama -->
    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaster" aria-expanded="false" aria-controls="collapseMaster">
        <i class="fas fa-fw fa-database"></i>
        <span>Master Data</span>
        <i class="fas fa-angle-down float-end mt-1"></i>
    </a>
    
    <!-- Isi Dropdown (Sub-Menu) -->
    <div id="collapseMaster" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- Link ke Data Kategori -->
            <a class="collapse-item d-block text-decoration-none ps-3 py-1 text-dark" href="<?= BASE_URL; ?>pages/kategori/index.php">
                <i class="fas fa-tags me-2"></i> Data Kategori
            </a>
            
            <!-- Link ke Data Penulis -->
            <a class="collapse-item d-block text-decoration-none ps-3 py-1 text-dark" href="<?= BASE_URL; ?>pages/penulis/index.php">
                <i class="fas fa-user-edit me-2"></i> Data Penulis
            </a>

            <a class="collapse-item d-block text-decoration-none ps-3 py-1 text-dark" href="<?= BASE_URL; ?>pages/penerbit/index.php">
                <i class="fas fa-user-edit me-2"></i> Data Penerbit
            </a>

            <!-- Di bawah link Data Penerbit -->
            <a class="dropdown-item text-dark ps-3 py-1 d-block text-decoration-none" href="<?= BASE_URL; ?>pages/rak/index.php">
                <i class="fas fa-archive me-2"></i> Data Rak
            </a>

            <!-- Kamu bisa menambah data master lainnya di sini nanti -->
            <!-- Contoh: Data Rak, Penerbit, dll -->
        </div>
    </div>
</li>
        <?php endif; ?>

        <li class="mt-5">
            <a href="<?= BASE_URL; ?>logout.php" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt me-2"></i> Keluar
            </a>
        </li>

    </ul>
</div> <!-- Tutup Sidebar -->
<div class="content"> <!-- Buka Content Area -->