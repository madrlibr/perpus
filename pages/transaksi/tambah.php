<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
proteksi_admin_petugas(); // Satpam pengecekan role
if (isset($_POST['simpan'])) {
    $id_anggota = $_POST['id_anggota'];
    $id_buku    = $_POST['id_buku'];
    $id_user    = $_SESSION['id_user']; // Sesuaikan dengan session loginmu
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days'));

    // Cek stok buku
    $cek_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id = '$id_buku'");
    $s = mysqli_fetch_assoc($cek_stok);

    if ($s['stok'] > 0) {
        // 1. Insert Peminjaman
        $query = mysqli_query($conn, "INSERT INTO peminjaman (id_anggota, id_buku, id_user, tanggal_pinjam, tanggal_kembali_seharusnya, status_pinjam) 
                  VALUES ('$id_anggota', '$id_buku', '$id_user', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')");
        
        // 2. Kurangi Stok
        mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id = '$id_buku'");

        echo "<script>alert('Berhasil pinjam!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Maaf, stok buku habis!');</script>";
    }
}
?>

<div class="card shadow-sm border-0 m-3">
    <div class="card-body">
        <h5>Tambah Peminjaman</h5>
        <form action="" method="POST">
            <div class="mb-3">
                <label>Pilih Anggota</label>
                <select name="id_anggota" class="form-control" required>
                    <?php 
                    $agt = mysqli_query($conn, "SELECT id, nama_anggota FROM anggota");
                    while($a = mysqli_fetch_assoc($agt)) echo "<option value='{$a['id']}'>{$a['nama_anggota']}</option>";
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Pilih Buku</label>
                    <select name="id_buku" class="form-control" required>
                        <option value="">-- Pilih Buku --</option>
                        <?php 
                        // Pastikan nama kolom sesuai: id, judul_buku, dan stok
                        $bku = mysqli_query($conn, "SELECT id, judul_buku, stok FROM buku WHERE stok > 0");
        
                        if(mysqli_num_rows($bku) > 0) {
                            while($b = mysqli_fetch_assoc($bku)) {
                                echo "<option value='{$b['id']}'>{$b['judul_buku']} (Tersedia: {$b['stok']})</option>";
                            }
                        } else {
                            echo "<option value=''>Buku tidak tersedia / stok habis</option>";
                        }
                        ?>
                </select>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>