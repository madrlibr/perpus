<?php
require_once "../../konek.php";
proteksi_admin_petugas(); // Satpam pengecekan role
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM buku WHERE id='$id'")->fetch_assoc();
?>

<h2>Edit Buku</h2>

<form method="POST">
    Judul: <input type="text" name="judul_buku" value="<?= $data['judul_buku'] ?>"><br><br>
    ISBN: <input type="text" name="isbn" value="<?= $data['isbn'] ?>"><br><br>
    Stok: <input type="number" name="stok" value="<?= $data['stok'] ?>"><br><br>
    Tahun: <input type="number" name="tahun_terbit" value="<?= $data['tahun_terbit'] ?>"><br><br>
    Kategori: <input type="number" name="id_kategori" value="<?= $data['id_kategori'] ?>"><br><br>
    Penulis: <input type="number" name="id_penulis" value="<?= $data['id_penulis'] ?>"><br><br>
    Penerbit: <input type="number" name="id_penerbit" value="<?= $data['id_penerbit'] ?>"><br><br>
    Rak: <input type="number" name="id_rak" value="<?= $data['id_rak'] ?>"><br><br>

    <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $sql = "UPDATE buku SET
        judul_buku='$_POST[judul_buku]',
        isbn='$_POST[isbn]',
        stok='$_POST[stok]',
        tahun_terbit='$_POST[tahun_terbit]',
        id_kategori='$_POST[id_kategori]',
        id_penulis='$_POST[id_penulis]',
        id_penerbit='$_POST[id_penerbit]',
        id_rak='$_POST[id_rak]'
        WHERE id='$id'";

    $conn->query($sql);

    header("Location: index.php");
}
?>




