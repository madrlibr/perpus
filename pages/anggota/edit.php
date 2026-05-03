<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

// 1. Ambil ID dari URL
$id = $_GET['id'];
$query_lama = mysqli_query($conn, "SELECT * FROM anggota WHERE id = '$id'");
$data = mysqli_fetch_array($query_lama);

// 2. Logika jika tombol Update diklik
if (isset($_POST['update'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama_anggota'];
    $jk   = $_POST['jenis_kelamin'];
    $telp = $_POST['no_telp'];
    $almt = $_POST['alamat'];
    $tgl = $_POST['tanggal_mendaftar'];

    $update = mysqli_query($conn, "UPDATE anggota SET 
              nisn = '$nisn', 
              nama_anggota = '$nama', 
              jenis_kelamin = '$jk', 
              no_telp = '$telp', 
              alamat = '$almt',
              tanggal_mendaftar = '$tgl'
              WHERE id = '$id'");

    if ($update) {
        echo "<script>alert('Data anggota berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Edit Data Anggota</h5>
        <form action="" method="POST">
            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" value="<?= $data['nisn']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_anggota" class="form-control" value="<?= $data['nama_anggota']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="L" <?= ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>No. Telepon</label>
                <input type="number" name="no_telp" class="form-control" value="<?= $data['no_telp']; ?>">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"><?= $data['alamat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label>Tanggal Mendaftar</label>
                <textarea name="tanggal_mendaftar" class="form-control"><?= $data['tanggal_mendaftar']; ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-warning text-white">Update Anggota</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>