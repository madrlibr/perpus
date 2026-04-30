<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    
    $query = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
    
    if ($query) {
        echo "<script>alert('Data berhasil ditambah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data.');</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Tambah Kategori Baru</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Teknologi, Sejarah, Novel" required>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>