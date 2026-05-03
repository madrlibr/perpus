<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas(); // Satpam pengecekan role
?>

<div class="container-fluid">
    <h4 class="mb-4">Laporan Peminjaman</h4>
    
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="cetak.php" method="GET" target="_blank">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Cetak Laporan (PDF/Print)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>