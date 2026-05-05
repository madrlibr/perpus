<?php
require_once "../konek.php"; 
require_once "../layout/header.php"; 
require_once "../layout/sidebar.php";

// Mengambil data statistik
$buku      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
$anggota   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM anggota"));
$kategori  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kategori"));
$transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status_pinjam='dipinjam'"));
?>

<div class="p-6 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard</h2>
            <p class="text-slate-500 mt-1">Selamat datang kembali, <span class="font-semibold text-blue-600"><?= $_SESSION['username']; ?></span> 👋</p>
        </div>
        <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
            <div class="bg-blue-50 p-2 rounded-xl text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-sm font-medium text-slate-700 pr-4"><?= date('d F Y'); ?></span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Buku -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Buku</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1"><?= $buku; ?></h3>
                </div>
                <div class="bg-blue-500 text-white p-3 rounded-2xl shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform">
                    <i class="fas fa-book fa-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-blue-600">
                <span class="bg-blue-50 px-2 py-1 rounded-lg">Data Koleksi</span>
            </div>
        </div>

        <!-- Total Anggota -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-50 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Anggota</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1"><?= $anggota; ?></h3>
                </div>
                <div class="bg-emerald-500 text-white p-3 rounded-2xl shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                    <i class="fas fa-users fa-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-emerald-600">
                <span class="bg-emerald-50 px-2 py-1 rounded-lg">Siswa Terdaftar</span>
            </div>
        </div>

        <!-- Kategori -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-violet-50 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Kategori</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1"><?= $kategori; ?></h3>
                </div>
                <div class="bg-violet-500 text-white p-3 rounded-2xl shadow-lg shadow-violet-200 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tags fa-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-violet-600">
                <span class="bg-violet-50 px-2 py-1 rounded-lg">Genre Buku</span>
            </div>
        </div>

        <!-- Pinjaman Aktif -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-orange-50 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Pinjaman Aktif</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1"><?= $transaksi; ?></h3>
                </div>
                <div class="bg-orange-500 text-white p-3 rounded-2xl shadow-lg shadow-orange-200 group-hover:scale-110 transition-transform">
                    <i class="fas fa-exchange-alt fa-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-orange-600">
                <span class="bg-orange-50 px-2 py-1 rounded-lg">Buku Dipinjam</span>
            </div>
        </div>
    </div>

    <!-- Quick Info Section -->
    <div class="bg-slate-800 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-200">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-white/10 p-2 rounded-lg backdrop-blur-md">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <h4 class="text-xl font-bold">Petunjuk Cepat Sistem</h4>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                    <p class="text-sm text-slate-300 leading-relaxed">
                        <span class="text-blue-400 font-bold block mb-1">Master Data</span>
                        Kelola buku dan anggota melalui sidebar. Pastikan kategori sudah tersedia.
                    </p>
                </div>
                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                    <p class="text-sm text-slate-300 leading-relaxed">
                        <span class="text-emerald-400 font-bold block mb-1">Peminjaman</span>
                        Cek stok buku di menu transaksi sebelum mengizinkan peminjaman baru.
                    </p>
                </div>
                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                    <p class="text-sm text-slate-300 leading-relaxed">
                        <span class="text-orange-400 font-bold block mb-1">Laporan</span>
                        Gunakan menu laporan untuk rekapitulasi data per periode (Khusus Admin).
                    </p>
                </div>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl"></div>
    </div>
</div>

<?php 
require_once "../layout/footer.php"; 
?>