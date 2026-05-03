<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas(); // Satpam pengecekan role
// Logika Simpan
if (isset($_POST['simpan'])) {
    // Ambil data dan bersihkan sedikit
    $judul    = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $isbn     = $_POST['isbn'];
    $stok     = $_POST['stok'];
    $tahun    = $_POST['tahun_terbit'];
    $kategori = $_POST['id_kategori'];
    $penulis  = $_POST['id_penulis'];
    $penerbit = $_POST['id_penerbit'];
    $rak      = $_POST['id_rak'];

    $sql = "INSERT INTO buku (judul_buku, isbn, stok, tahun_terbit, id_kategori, id_penulis, id_penerbit, id_rak) 
            VALUES ('$judul', '$isbn', '$stok', '$tahun', '$kategori', '$penulis', '$penerbit', '$rak')";

    if ($conn->query($sql)) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah buku: " . $conn->error . "');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Koleksi Buku Baru</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Judul Buku</label>
                                    <input type="text" name="judul_buku" class="form-control" placeholder="Contoh: Laskar Pelangi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" name="isbn" class="form-control" placeholder="978-..." required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Stok</label>
                                            <input type="number" name="stok" class="form-control" value="0" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tahun Terbit</label>
                                            <input type="number" name="tahun_terbit" class="form-control" placeholder="YYYY" min="1900" max="2100" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="id_kategori" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php
                                        $res = $conn->query("SELECT * FROM kategori");
                                        while($d = $res->fetch_assoc()) echo "<option value='$d[id]'>$d[nama_kategori]</option>";
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penulis</label>
                                    <select name="id_penulis" class="form-select" required>
                                        <option value="">-- Pilih Penulis --</option>
                                        <?php
                                        $res = $conn->query("SELECT * FROM penulis");
                                        while($d = $res->fetch_assoc()) echo "<option value='$d[id]'>$d[nama_penulis]</option>";
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penerbit</label>
                                    <select name="id_penerbit" class="form-select" required>
                                        <option value="">-- Pilih Penerbit --</option>
                                        <?php
                                        $res = $conn->query("SELECT * FROM penerbit");
                                        while($d = $res->fetch_assoc()) echo "<option value='$d[id]'>$d[nama_penerbit]</option>";
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi Rak</label>
                                    <select name="id_rak" class="form-select" required>
                                        <option value="">-- Pilih Rak --</option>
                                        <?php
                                        $res = $conn->query("SELECT * FROM rak");
                                        while($d = $res->fetch_assoc()) echo "<option value='$d[id]'>$d[nama_rak] ($d[lokasi])</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="simpan" class="btn btn-primary px-4">Simpan Buku</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Info Card (Opsional) -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6><i class="fas fa-info-circle text-primary"></i> Tips Petugas</h6>
                    <small class="text-muted">
                        Pastikan data master (Kategori, Penulis, dll) sudah diisi sebelum menambah buku. Jika belum ada, silakan ke menu Master Data terlebih dahulu.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>