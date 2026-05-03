<?php
require_once "../../konek.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
?>

<h2>Data Buku</h2>
<a href="tambah.php">+ Tambah Buku</a>

<table border="1" cellpadding="10">
<tr>
    <th>No</th>
    <th>Judul</th>
    <th>ISBN</th>
    <th>Stok</th>
    <th>Tahun</th>
    <th>Kategori</th>
    <th>Penulis</th>
    <th>Penerbit</th>
    <th>Rak</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;
$result = $conn->query("SELECT * FROM buku");

while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['judul_buku'] ?></td>
    <td><?= $row['isbn'] ?></td>
    <td><?= $row['stok'] ?></td>
    <td><?= $row['tahun_terbit'] ?></td>
    <td><?= $row['id_kategori'] ?></td>
    <td><?= $row['id_penulis'] ?></td>
    <td><?= $row['id_penerbit'] ?></td>
    <td><?= $row['id_rak'] ?></td>
    <td>
    <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Detail</a>
        <?php if ($_SESSION['role'] !== 'anggota') : ?>
            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
        <?php endif; ?>
    </td>
</tr>
<?php } ?>

</table>