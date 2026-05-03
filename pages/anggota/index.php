<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Daftar Anggota</h4>
        <a href="tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Anggota</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Anggota</th>
                        <th>L/P</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Tanggal Mendaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id DESC");
                    while($row = mysqli_fetch_array($query)) :
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nisn']; ?></td>
                        <td><?= $row['nama_anggota']; ?></td>
                        <td><?= $row['jenis_kelamin']; ?></td>
                        <td><?= $row['no_telp']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['tanggal_mendaftar']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus anggota ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>