<?php
require_once "../../konek.php";
proteksi_admin_petugas();

$id_p = $_GET['id'];

// --- LOGIKA PENGEMBALIAN BUKU DENGAN KONDISI ---
if (isset($_POST['proses_kembalikan_buku'])) {
    $id_det = $_POST['id_detail'];
    $id_buku = $_POST['id_buku'];
    $kondisi_buku = $_POST['kondisi_buku'] ?? 'baik';
    $tgl_kembali_aktual = date('Y-m-d');
    
    // 1. Ambil batas tanggal kembali seharusnya
    $q_pinjam = mysqli_query($conn, "SELECT tanggal_kembali_seharusnya FROM peminjaman WHERE id = '$id_p'");
    $d_pinjam = mysqli_fetch_assoc($q_pinjam);
    $tgl_seharusnya = $d_pinjam['tanggal_kembali_seharusnya'];

    // 2. Ambil parameter denda terlambat aktif dari DB
    $q_denda = mysqli_query($conn, "SELECT harga_denda_per_hari FROM pengaturan_denda WHERE status_aktif = 1 LIMIT 1");
    $d_denda = mysqli_fetch_assoc($q_denda);
    $harga_denda_per_hari = $d_denda['harga_denda_per_hari'] ?? 0;

    // A. Hitung Denda Waktu Keterlambatan
    $denda_waktu = 0;
    if (strtotime($tgl_kembali_aktual) > strtotime($tgl_seharusnya)) {
        $selisih = strtotime($tgl_kembali_aktual) - strtotime($tgl_seharusnya);
        $jumlah_hari = floor($selisih / (60 * 60 * 24));
        $denda_waktu = $jumlah_hari * $harga_denda_per_hari;
    }

    // B. Hitung Tambahan Denda Fisik Sesuai Kondisi Buku
    $denda_fisik = 0;
    if ($kondisi_buku == 'rusak') {
        $denda_fisik = 20000; // Akumulasi jika buku rusak
    } elseif ($kondisi_buku == 'hilang') {
        $denda_fisik = 50000; // Akumulasi jika buku hilang
    }

    // C. Gabungkan Total Denda Akhir
    $total_denda_buku = $denda_waktu + $denda_fisik;

    mysqli_begin_transaction($conn);
    try {
        // 1. Update status di detail_peminjaman
        mysqli_query($conn, "UPDATE detail_peminjaman SET status_buku = 'kembali' WHERE id = '$id_det'");
        
        // 2. Simpan ke tabel pengembalian dengan kondisi ENUM baru & nominal total denda
        mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, tanggal_kembali_aktual, denda_terlambat, kondisi_buku) 
                             VALUES ('$id_p', '$tgl_kembali_aktual', '$total_denda_buku', '$kondisi_buku')");

        // 3. Kembalikan stok buku jika statusnya tidak 'hilang'
        if ($kondisi_buku != 'hilang') {
            mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = '$id_buku'");
        }
        
        // 4. Update status induk jika seluruh item buku dalam invoice ini sudah kembali
        $cek_sisa = mysqli_query($conn, "SELECT id FROM detail_peminjaman WHERE id_peminjaman = '$id_p' AND status_buku = 'dipinjam'");
        if(mysqli_num_rows($cek_sisa) == 0) {
            mysqli_query($conn, "UPDATE peminjaman SET status_pinjam = 'kembali' WHERE id = '$id_p'");
        }
        
        mysqli_commit($conn);
        header("Location: detail.php?id=$id_p");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Gagal memproses pengembalian: " . $e->getMessage());
    }
}

require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

// Ambil Data Utama Informasi Peminjam
$sql_utama = "SELECT p.*, a.nama_anggota, a.nisn, u.nama_lengkap as nama_user
              FROM peminjaman p 
              JOIN anggota a ON p.id_anggota = a.id 
              LEFT JOIN users u ON p.id_user = u.id 
              WHERE p.id = '$id_p'";
$p = mysqli_fetch_assoc(mysqli_query($conn, $sql_utama));

// Hitung Statistik Ringkas
$total_buku = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM detail_peminjaman WHERE id_peminjaman = '$id_p'"));
$buku_kembali = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM detail_peminjaman WHERE id_peminjaman = '$id_p' AND status_buku = 'kembali'"));
$total_denda_res = mysqli_query($conn, "SELECT SUM(denda_terlambat) as total FROM pengembalian WHERE id_peminjaman = '$id_p'");
$total_denda = mysqli_fetch_assoc($total_denda_res);
?>

<div class="p-6 max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <nav class="flex text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">
                <a href="index.php" class="hover:text-blue-600">Transaksi</a>
                <span class="mx-2">/</span>
                <span class="text-slate-800">Detail #<?= $id_p ?></span>
            </nav>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Detail Peminjaman</h2>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-all">
                <i class="fas fa-print mr-2"></i> Cetak
            </button>
            <a href="index.php" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-black transition-all">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Total Buku</p>
                    <p class="text-xl font-black text-slate-800"><?= $total_buku ?> Item</p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Status</p>
                    <p class="text-xl font-black <?= $p['status_pinjam'] == 'dipinjam' ? 'text-amber-500' : 'text-emerald-500' ?>">
                        <?= strtoupper($p['status_pinjam']) ?>
                    </p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Tgl Pinjam</p>
                    <p class="text-sm font-bold text-slate-700"><?= date('d/m/Y', strtotime($p['tanggal_pinjam'])) ?></p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Total Denda</p>
                    <p class="text-xl font-black text-red-600">Rp <?= number_format($total_denda['total'] ?? 0, 0, ',', '.') ?></p>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Daftar Item Buku</h3>
                    <span class="text-[10px] font-bold px-2 py-1 bg-slate-100 rounded-lg text-slate-500"><?= $buku_kembali ?>/<?= $total_buku ?> Dikembalikan</span>
                </div>
                <table class="w-full">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-left">Informasi Buku</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-left">Kondisi Pengembalian</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase text-right">Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php 
                        $det = mysqli_query($conn, "SELECT d.*, b.judul_buku, b.isbn FROM detail_peminjaman d JOIN buku b ON d.id_buku = b.id WHERE d.id_peminjaman = '$id_p'");
                        while($d = mysqli_fetch_assoc($det)) : 
                        ?>
                        <tr>
                            <td class="px-6 py-5">
                                <p class="font-bold text-slate-800"><?= $d['judul_buku'] ?></p>
                                <p class="text-xs text-slate-400">ISBN: <?= $d['isbn'] ?></p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <?php if($d['status_buku'] == 'dipinjam') : ?>
                                    <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full">DIPINJAM</span>
                                <?php else : ?>
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full">KEMBALI</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5">
                                <?php if($d['status_buku'] == 'dipinjam') : ?>
                                    <form method="POST" action="" onsubmit="return confirm('Proses pengembalian buku ini?')" class="flex items-center gap-2">
                                        <input type="hidden" name="id_detail" value="<?= $d['id'] ?>">
                                        <input type="hidden" name="id_buku" value="<?= $d['id_buku'] ?>">
                                        
                                        <select name="kondisi_buku" class="px-2 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg outline-none font-semibold text-slate-700 focus:border-blue-400">
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak (+20k)</option>
                                            <option value="hilang">Hilang (+50k)</option>
                                        </select>
                                        
                                        <button type="submit" name="proses_kembalikan_buku" class="bg-emerald-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-600 transition-all shadow-sm">
                                            Simpan
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <span class="text-emerald-500 text-xs font-bold"><i class="fas fa-check-circle mr-1"></i> Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5 text-right font-semibold text-slate-600 text-xs">
                                <?php if($d['status_buku'] == 'kembali') : ?>
                                    <span class="text-xs font-medium text-slate-500 font-mono">
                                        <i class="far fa-calendar-check mr-1 text-emerald-500"></i> 
                                        <?= date('d/m/Y'); ?>
                                    </span>
                                <?php else : ?>
                                    <span class="text-xs text-slate-300 italic font-normal">- Belum Kembali -</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">Peminjam</p>
                        <h3 class="text-xl font-black leading-tight"><?= $p['nama_anggota'] ?></h3>
                    </div>
                </div>
                <div class="space-y-4 border-t border-white/10 pt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-blue-100 italic">NISN</span>
                        <span class="font-bold tracking-wider"><?= $p['nisn'] ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-blue-100 italic">Batas Waktu</span>
                        <span class="font-bold text-amber-300"><?= date('d M Y', strtotime($p['tanggal_kembali_seharusnya'])) ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase mb-4 tracking-widest text-center">Petugas Terkait</h4>
                <div class="flex items-center justify-center gap-3">
                    <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                        <i class="fas fa-user-shield text-xs"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-700"><?= $p['nama_user'] ?? 'Administrator' ?></p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>