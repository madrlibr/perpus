<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas(); // Satpam pengecekan role
$id = $_GET['id'];
$sql = "SELECT p.*, a.nama_anggota, a.nisn, b.judul_buku, b.isbn, u.nama_lengkap as petugas, k.tanggal_kembali_aktual, k.denda_terlambat
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON p.id_buku = b.id
        JOIN users u ON p.id_user = u.id
        LEFT JOIN pengembalian k ON p.id = k.id_peminjaman
        WHERE p.id = '$id'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>

<div class="card shadow-sm border-0 m-3">
    <div class="card-body">
        <h5>Detail Transaksi #<?= $data['id']; ?></h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Anggota:</strong> <?= $data['nama_anggota']; ?> (<?= $data['nisn']; ?>)</p>
                <p><strong>Buku:</strong> <?= $data['judul_buku']; ?></p>
                <p><strong>Petugas:</strong> <?= $data['petugas']; ?></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Tgl Pinjam:</strong> <?= $data['tanggal_pinjam']; ?></p>
                <p><strong>Status:</strong> <?= strtoupper($data['status_pinjam']); ?></p>
                <?php if($data['status_pinjam'] == 'kembali') : ?>
                    <p class="text-danger"><strong>Denda:</strong> Rp <?= number_format($data['denda_terlambat']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>