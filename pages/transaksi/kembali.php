<?php
require_once "../../konek.php";
proteksi_admin_petugas();

if (isset($_GET['id'])) {
    $id_pinjam = $_GET['id'];
    $tgl_kembali_aktual = date('Y-m-d');

    // 1. Ambil data peminjaman & harga denda aktif
    $query_pinjam = mysqli_query($conn, "SELECT id_buku, tanggal_kembali_seharusnya FROM peminjaman WHERE id='$id_pinjam'");
    $data_pinjam  = mysqli_fetch_assoc($query_pinjam);
    
    $query_denda  = mysqli_query($conn, "SELECT harga_denda_per_hari FROM pengaturan_denda WHERE status_aktif = 1 LIMIT 1");
    $data_denda   = mysqli_fetch_assoc($query_denda);

    if (!$data_pinjam) {
        header("Location: index.php");
        exit;
    }

    $id_buku = $data_pinjam['id_buku'];
    $tgl_seharusnya = $data_pinjam['tanggal_kembali_seharusnya'];
    $harga_denda_per_hari = $data_denda['harga_denda_per_hari'] ?? 0;

    // 2. Hitung Selisih Hari & Total Denda
    $denda_total = 0;
    if (strtotime($tgl_kembali_aktual) > strtotime($tgl_seharusnya)) {
        $selisih = strtotime($tgl_kembali_aktual) - strtotime($tgl_seharusnya);
        $jumlah_hari = floor($selisih / (60 * 60 * 24)); // Konversi detik ke hari
        $denda_total = $jumlah_hari * $harga_denda_per_hari;
    }

    // 3. Mulai Proses Update (Gunakan Transaction agar aman)
    mysqli_begin_transaction($conn);

    try {
        // A. Update status di tabel peminjaman
        mysqli_query($conn, "UPDATE peminjaman SET status_pinjam = 'kembali' WHERE id='$id_pinjam'");

        // B. Tambah data ke tabel pengembalian
        mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, tanggal_kembali_aktual, denda_terlambat, kondisi_buku) 
                             VALUES ('$id_pinjam', '$tgl_kembali_aktual', '$denda_total', 'Baik')");

        // C. Kembalikan stok buku
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id='$id_buku'");

        mysqli_commit($conn);

        // Siapkan pesan notifikasi
        $pesan = ($denda_total > 0) 
            ? "Buku dikembalikan. Terlambat $jumlah_hari hari, denda: Rp " . number_format($denda_total, 0, ',', '.') 
            : "Buku dikembalikan tepat waktu. Terima kasih!";

        session_start();
        $_SESSION['notif'] = [
            'tipe' => ($denda_total > 0 ? 'warning' : 'success'),
            'judul' => 'Proses Berhasil',
            'pesan' => $pesan
        ];
        
        header("Location: index.php");
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Gagal memproses pengembalian: " . $e->getMessage();
    }
}
?>