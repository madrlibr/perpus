<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

// Logika Simpan
if (isset($_POST['pinjam'])) {
    $id_anggota = $_POST['id_anggota'];
    $id_user = $_SESSION['id_user'] ?? $_SESSION['id'];
    $tgl_pinjam = $_POST['tanggal_pinjam'];
    $tgl_kembali = $_POST['tanggal_kembali_seharusnya'];
    $daftar_buku = $_POST['id_buku']; // Berupa Array

    mysqli_begin_transaction($conn);
    try {
        // 1. Simpan ke tabel Peminjaman (Header)
        $query_p = "INSERT INTO peminjaman (id_anggota, id_user, tanggal_pinjam, tanggal_kembali_seharusnya, status_pinjam) 
                    VALUES ('$id_anggota', '$id_user', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')";
        mysqli_query($conn, $query_p);
        $id_peminjaman = mysqli_insert_id($conn);

        // 2. Simpan ke tabel Detail_Peminjaman (Multi-Baris)
        foreach ($daftar_buku as $id_buku) {
            if(!empty($id_buku)) {
                mysqli_query($conn, "INSERT INTO detail_peminjaman (id_peminjaman, id_buku, status_buku) VALUES ('$id_peminjaman', '$id_buku', 'dipinjam')");
                // Potong Stok
                mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id = '$id_buku'");
            }
        }

        mysqli_commit($conn);
        $_SESSION['notif'] = ['tipe' => 'success', 'judul' => 'Berhasil!', 'pesan' => 'Peminjaman multi-buku berhasil dicatat.'];
        echo "<script>window.location.href='index.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="p-6 max-w-5xl mx-auto">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-slate-800">Transaksi Baru</h2>
        <p class="text-slate-500">Petugas dapat menginput lebih dari satu buku dalam satu sesi.</p>
    </div>

    <form action="" method="POST" class="space-y-6">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Pilih Anggota</label>
                    <select name="id_anggota" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Cari Nama --</option>
                        <?php 
                        $ang = mysqli_query($conn, "SELECT * FROM anggota");
                        while($a = mysqli_fetch_assoc($ang)) echo "<option value='".$a['id']."'>".$a['nama_anggota']."</option>";
                        ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2">Tgl Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" class="w-full p-3 bg-slate-50 border rounded-xl outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2">Batas Kembali</label>
                        <input type="date" name="tanggal_kembali_seharusnya" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" class="w-full p-3 bg-slate-50 border rounded-xl outline-none">
                    </div>
                </div>
            </div>

            <div id="wrapper-buku" class="space-y-4">
                <label class="block text-xs font-black text-slate-400 uppercase mb-2">Daftar Buku yang Dipinjam</label>
                <div class="flex gap-3 item-buku">
                    <select name="id_buku[]" required class="flex-1 p-3 bg-slate-50 border rounded-xl outline-none">
                        <option value="">-- Pilih Buku --</option>
                        <?php 
                        $buku = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0");
                        while($b = mysqli_fetch_assoc($buku)) echo "<option value='".$b['id']."'>".$b['judul_buku']." (Stok: ".$b['stok'].")</option>";
                        ?>
                    </select>
                    <button type="button" onclick="tambahBaris()" class="w-12 h-12 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="mt-10 flex gap-4">
                <button type="submit" name="pinjam" class="flex-1 bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-black transition-all">Simpan Transaksi</button>
                <a href="index.php" class="px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl">Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
function tambahBaris() {
    const wrapper = document.getElementById('wrapper-buku');
    const newDiv = document.createElement('div');
    newDiv.className = 'flex gap-3 item-buku mt-3 animate-in fade-in slide-in-from-top-2 duration-300';
    newDiv.innerHTML = `
        <select name="id_buku[]" required class="flex-1 p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
            ${document.querySelector('select[name="id_buku[]"]').innerHTML}
        </select>
        <button type="button" onclick="this.parentElement.remove()" class="w-12 h-12 bg-red-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
    wrapper.appendChild(newDiv);
}
</script>