<?php 
require_once "../../konek.php"; 
require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 

if (isset($_POST['simpan'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama_anggota'];
    $jk   = $_POST['jenis_kelamin'];
    $telp = $_POST['no_telp'];
    $almt = $_POST['alamat'];
    $tgl  = date('Y-m-d'); // Otomatis tanggal hari ini

    $insert = mysqli_query($conn, "INSERT INTO anggota (nisn, nama_anggota, jenis_kelamin, no_telp, alamat, tanggal_mendaftar) 
              VALUES ('$nisn', '$nama', '$jk', '$telp', '$almt', '$tgl')");

    if ($insert) {
        echo "<script>alert('Anggota berhasil didaftarkan!'); window.location='index.php';</script>";
    }
}
?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5>Tambah Anggota Baru</h5>
        <form action="" method="POST">
            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_anggota" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>No. Telepon</label>
                <input type="number" name="no_telp" class="form-control">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Tanggal Mendaftar</label>
                <textarea name="tanggal_mendafatar" class="form-control"></textarea>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan Anggota</button>
        </form>
    </div>
</div>