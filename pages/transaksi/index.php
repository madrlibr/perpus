<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php";
proteksi_admin_petugas(); // Satpam pengecekan role
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Data Transaksi</h4>
        <a href="tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Pinjam Buku</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $sql = "SELECT p.*, a.nama_anggota, b.judul_buku 
                                FROM peminjaman p
                                JOIN anggota a ON p.id_anggota = a.id
                                JOIN buku b ON p.id_buku = b.id
                                ORDER BY p.id DESC";
                        $query = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($query)) :
                            $status = $row['status_pinjam'];
                            $badge = ($status == 'dipinjam') ? 'bg-warning' : 'bg-success';
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_anggota']; ?></td>
                            <td><?= $row['judul_buku']; ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])); ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_kembali_seharusnya'])); ?></td>
                            <td><span class="badge <?= $badge; ?>"><?= $status; ?></span></td>
                            <td>
                                <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-light border"><i class="fas fa-eye"></i></a>
                                <?php if($status == 'dipinjam') : ?>
                                    <a href="kembali.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white" onclick="return confirm('Proses pengembalian buku?')">
                                        <i class="fas fa-undo"></i> Kembali
                                    </a>
                                <?php endif; ?>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>