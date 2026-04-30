<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

// Logika Simpan Data
if (isset($_POST['simpan'])) {
    $namaPenulis = mysqli_real_escape_string($conn, $_POST['nama_penulis']);
    $b = mysqli_real_escape_string($conn, $_POST['biografi']);
    
    $query = mysqli_query($conn, "INSERT INTO penulis (nama_penulis, biografi) VALUES ('$namaPenulis', '$b')");
   
    
    if ($query) {
        echo "<script>alert('Data berhasil ditambah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data.');</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Tambah Penulis Baru</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Penulis</label>
                <input type="text" name="nama_penulis" class="form-control" placeholder="Contoh: adril, fadli, zahra, riska" required>
            </div>

             <div class="mb-3">
                <label class="form-label fw-bold">Biografi</label>
                <input type="text" name="biografi" class="form-control" placeholder="Contoh: menceritakan riwayat cerita" required>
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