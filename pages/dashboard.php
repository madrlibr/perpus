<?php
require_once "../konek.php"; 
require_once "../layout/header.php"; 
require_once "../layout/sidebar.php";

// Mengambil data statistik dari database
$buku      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
$anggota   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM anggota"));
$kategori  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kategori"));
// Contoh menghitung transaksi yang belum kembali
$transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status_pinjam='dipinjam'"));
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Dashboard</h2>
            <p class="text-muted">Selamat datang, <strong><?= $_SESSION['username']; ?></strong>. Berikut adalah ringkasan perpustakaan hari ini.</p>
        </div>
    </div>

    <div class="row">
        <!-- Card Total Buku -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small">Total Buku</h6>
                            <h2 class="mb-0"><?= $buku; ?></h2>
                        </div>
                        <i class="fas fa-book fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Anggota -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small">Total Anggota</h6>
                            <h2 class="mb-0"><?= $anggota; ?></h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Kategori -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small">Kategori</h6>
                            <h2 class="mb-0"><?= $kategori; ?></h2>
                        </div>
                        <i class="fas fa-tags fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Transaksi Aktif -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small">Pinjaman Aktif</h6>
                            <h2 class="mb-0"><?= $transaksi; ?></h2>
                        </div>
                        <i class="fas fa-exchange-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Baru untuk Pesan Selamat Datang atau Petunjuk -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="alert alert-light border shadow-sm">
                <h5><i class="fas fa-info-circle me-2 text-primary"></i> Petunjuk Cepat</h5>
                <hr>
                <ul>
                    <li>Gunakan menu samping untuk mengelola <strong>Data Buku</strong> dan <strong>Anggota</strong>.</li>
                    <li>Pastikan data <strong>Kategori</strong> dan <strong>Penulis</strong> sudah terisi sebelum menambah buku baru.</li>
                    <li>Laporan transaksi dapat diakses melalui menu Laporan (Hanya Admin).</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php 
require_once "../layout/footer.php"; 
?>