<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Data Kategori</h3>
    <a href="tambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kategori</a>
</div>

<table class="table table-bordered table-striped bg-white shadow-sm">
    <thead class="table-dark">
        <tr>
            <th width="5%">No</th>
            <th>Nama Kategori</th>
            <th width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        $query = mysqli_query($conn, "SELECT * FROM kategori");
        while($d = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama_kategori']; ?></td>
            <td>
                <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="hapus.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php require_once "../../layout/footer.php"; ?>