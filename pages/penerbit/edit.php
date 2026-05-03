<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data lama dari database
$ambil_data = mysqli_query($conn, "SELECT * FROM penerbit WHERE id='$id'");
$data = mysqli_fetch_assoc($ambil_data);

// 3. Logika Update Data
if (isset($_POST['update'])) {
    // Perbaikan: Samakan nama variabel agar konsisten
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penerbit']);
    $b = mysqli_real_escape_string($conn, $_POST['alamat_penerbit']);
    
    // Perbaikan: Ganti 'kategori' menjadi 'penulis'
    $query = mysqli_query($conn, "UPDATE penerbit SET nama_penerbit='$nama', alamat_penerbit='$b' WHERE id='$id'");
    
    if ($query) {
        echo "<script>alert('Data berhasil diubah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Edit Penerbit</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Penerbit</label>
                <input type="text" name="nama_penerbit" class="form-control" value="<?= $data['nama_penerbit']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Alamat Penerbit</label>
                <!-- Gunakan textarea jika biografi isinya panjang -->
                <textarea name="alamat_penerbit" class="form-control" rows="4" required><?= $data['alamat_penerbit']; ?></textarea>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" name="update" class="btn btn-warning text-white">Update Data</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>