<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Rak</h4>
        <a href="tambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Rak</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Rak</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM rak ORDER BY id DESC");
                    while($d = mysqli_fetch_array($query)) :
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $d['nama_rak']; ?></td>
                        <td><?= $d['lokasi']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>