<?php 
require_once "../../konek.php"; 
proteksi_admin_petugas(); // Satpam pengecekan role
$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Perpustakaan</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css"> <!-- Sesuaikan path CSS kamu -->
    <style>
        body { font-family: sans-serif; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container mt-4">
        <h3 class="text-center">LAPORAN PEMINJAMAN BUKU</h3>
        <p class="text-center">Periode: <?= date('d/m/Y', strtotime($tgl_awal)); ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)); ?></p>
        <hr>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $sql = "SELECT p.*, a.nama_anggota, b.judul_buku 
                        FROM peminjaman p
                        JOIN anggota a ON p.id_anggota = a.id
                        JOIN buku b ON p.id_buku = b.id
                        WHERE p.tanggal_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir'
                        ORDER BY p.tanggal_pinjam ASC";
                $query = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>
                                <td>".$no++."</td>
                                <td>".$row['nama_anggota']."</td>
                                <td>".$row['judul_buku']."</td>
                                <td>".date('d/m/Y', strtotime($row['tanggal_pinjam']))."</td>
                                <td>".date('d/m/Y', strtotime($row['tanggal_kembali_seharusnya']))."</td>
                                <td>".ucfirst($row['status_pinjam'])."</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data pada periode ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="row mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Tasikmalaya, <?= date('d F Y'); ?></p>
                <p>Petugas Perpustakaan,</p>
                <br><br><br>
                <p><strong>( ________________ )</strong></p>
            </div>
        </div>
    </div>
    
    <div class="text-center no-print mt-3">
        <button onclick="window.print()" class="btn btn-primary">Klik Cetak Lagi</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>