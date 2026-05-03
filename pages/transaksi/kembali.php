<?php
require_once "../../konek.php";
proteksi_admin_petugas(); // Satpam pengecekan role
if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];
    $tgl_aktual = date('Y-m-d');

    // 1. Ambil data pinjam & pengaturan denda
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM peminjaman WHERE id = '$id_peminjaman'"));
    $d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga_denda_per_hari FROM pengaturan_denda WHERE status_aktif = 1 LIMIT 1"));
    
    // 2. Hitung Denda
    $denda = 0;
    $tgl_seharusnya = strtotime($p['tanggal_kembali_seharusnya']);
    $tgl_kembali = strtotime($tgl_aktual);

    if ($tgl_kembali > $tgl_seharusnya) {
        $selisih = ($tgl_kembali - $tgl_seharusnya) / (60 * 60 * 24);
        $denda = $selisih * $d['harga_denda_per_hari'];
    }

    // 3. Simpan ke tabel pengembalian
    mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, tanggal_kembali_aktual, denda_terlambat, kondisi_buku) 
                         VALUES ('$id_peminjaman', '$tgl_aktual', '$denda', 'Baik')");

    // 4. Update status & kembalikan stok
    mysqli_query($conn, "UPDATE peminjaman SET status_pinjam = 'kembali' WHERE id = '$id_peminjaman'");
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = '{$p['id_buku']}'");

    echo "<script>alert('Buku dikembalikan. Denda: Rp " . number_format($denda) . "'); window.location='index.php';</script>";
}