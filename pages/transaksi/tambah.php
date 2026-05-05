<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

if (isset($_POST['pinjam'])) {
    $id_anggota = $_POST['id_anggota'];
    $id_buku    = $_POST['id_buku'];
    
    // Perbaikan: Pastikan session ID ada. 
    // Coba ganti ['id'] menjadi ['id_user'] jika di login.php kamu pakai nama itu.
    $id_user    = $_SESSION['id'] ?? $_SESSION['id_user'] ?? null; 
    
    if (!$id_user) {
        echo "<script>alert('Sesi petugas habis, silakan login ulang!'); window.location.href='../../login.php';</script>";
        exit;
    }

    $tgl_pinjam  = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days')); 
    $status      = 'dipinjam'; 

    $cek_stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM buku WHERE id='$id_buku'"));
    
    if ($cek_stok['stok'] > 0) {
        // Gunakan prepared statement atau pastikan variabel terisi
        $query_text = "INSERT INTO peminjaman 
                       (id_anggota, id_buku, id_user, tanggal_pinjam, tanggal_kembali_seharusnya, status_pinjam) 
                       VALUES 
                       ('$id_anggota', '$id_buku', '$id_user', '$tgl_pinjam', '$tgl_kembali', '$status')";
        
        $insert = mysqli_query($conn, $query_text);
        
        if ($insert) {
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id='$id_buku'");
            echo "<script>alert('Peminjaman Berhasil!'); window.location.href='index.php';</script>";
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Maaf, Stok Buku Habis!');</script>";
    }
}
?>

<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Input Peminjaman Baru</h2>
        <p class="text-slate-500 mt-2">Pastikan data anggota dan buku sudah benar sebelum memproses.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
        <form action="" method="POST" class="p-10 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Pilih Anggota -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 ml-1">Pilih Anggota</label>
                    <div class="relative">
                        <select name="id_anggota" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none">
                            <option value="">-- Cari Nama Anggota --</option>
                            <?php 
                            $ang = mysqli_query($conn, "SELECT * FROM anggota");
                            while($a = mysqli_fetch_assoc($ang)) echo "<option value='".$a['id']."'>".$a['nama_anggota']."</option>";
                            ?>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Pilih Buku -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 ml-1">Pilih Buku</label>
                    <div class="relative">
                        <select name="id_buku" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none">
                            <option value="">-- Cari Judul Buku --</option>
                            <?php 
                            $bku = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0");
                            while($b = mysqli_fetch_assoc($bku)) echo "<option value='".$b['id']."'>".$b['judul_buku']." (Stok: ".$b['stok'].")</option>";
                            ?>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Info Otomatis -->
            <div class="p-6 bg-indigo-50 rounded-2xl border border-indigo-100 flex items-start gap-4">
                <div class="p-3 bg-indigo-500 text-white rounded-xl shadow-lg">
                    <i class="fas fa-calendar-check fa-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-1">Durasi Peminjaman</p>
                    <p class="text-sm text-indigo-900 leading-relaxed">Sistem menetapkan batas pengembalian **7 hari** secara otomatis. Keterlambatan dapat dikenakan denda sesuai kebijakan perpustakaan.</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 pt-4">
                <button type="submit" name="pinjam" class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95">
                    Konfirmasi & Simpan Transaksi
                </button>
                <a href="index.php" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-4 rounded-2xl text-center transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>