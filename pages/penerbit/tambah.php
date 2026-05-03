<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penerbit']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat_penerbit']);
    
    $query = mysqli_query($conn, "INSERT INTO penerbit (nama_penerbit, alamat_penerbit) VALUES ('$nama', '$alamat')");
    
    if ($query) {
        echo "<script>alert('Penerbit berhasil ditambah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data.');</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h5 class="mb-0">Tambah Penerbit</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Penerbit</label>
                <input type="text" name="nama_penerbit" class="form-control" placeholder="Contoh: Gramedia" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Alamat</label>
                <textarea name="alamat_penerbit" class="form-control" rows="3" required></textarea>
            </div>
            <hr>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>