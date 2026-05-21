<?php
require_once "../../konek.php";
proteksi_admin_petugas();

if (isset($_POST['ids_peminjaman']) && is_array($_POST['ids_peminjaman'])) {
    $ids = $_POST['ids_peminjaman'];
    
    // Validasi agar isi array berupa angka (mencegah SQL Injection)
    $ids_aman = array_map('intval', $ids);
    $string_ids = implode(",", $ids_aman);

    mysqli_begin_transaction($conn);
    try {
        // 1. Hapus data dari tabel detail_peminjaman terlebih dahulu (Foreign Key Safe)
        mysqli_query($conn, "DELETE FROM detail_peminjaman WHERE id_peminjaman IN ($string_ids)");
        
        // 2. Hapus data dari tabel pengembalian jika ada relasi terkait
        mysqli_query($conn, "DELETE FROM pengembalian WHERE id_peminjaman IN ($string_ids)");

        // 3. Hapus data utama di tabel peminjaman
        mysqli_query($conn, "DELETE FROM peminjaman WHERE id IN ($string_ids)");

        mysqli_commit($conn);
        
        session_start();
        $_SESSION['notif'] = [
            'tipe' => 'success',
            'judul' => 'Berhasil',
            'pesan' => count($ids_aman) . ' data transaksi berhasil dihapus sekaligus.'
        ];
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Gagal menghapus data massal: " . $e->getMessage());
    }
}

header("Location: index.php");
exit;