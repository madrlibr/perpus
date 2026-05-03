<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $nama_rak = mysqli_real_escape_string($conn, $_POST['nama_rak']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    
    $query = mysqli_query($conn, "INSERT INTO rak (nama_rak, lokasi) VALUES ('$nama_rak', '$lokasi')");
   
    
    if ($query) {
        echo "<script>alert('Data berhasil ditambah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data.');</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Tambah Rak Baru</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Rak</label>
                <input type="text" name="nama_rak" class="form-control" placeholder="Contoh: A1, B1, c1" required>
            </div>

             <div class="mb-3">
                <label class="form-label fw-bold">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: lantai 1" required>
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