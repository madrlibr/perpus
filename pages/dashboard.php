<?php
require_once "../konek.php"; 
require_once "../layout/header.php"; 
require_once "../layout/sidebar.php";

// Mengambil data statistik
$buku      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
$anggota   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM anggota"));
$kategori  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kategori"));
$transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_peminjaman WHERE status_buku='dipinjam'"));

$tgl_sekarang = date('Y-m-d');

// FIX QUERY: Menghubungkan peminjaman ke detail_peminjaman untuk mendapatkan data buku
$sql_late = "SELECT p.id as id_peminjaman, p.tanggal_kembali_seharusnya, 
                    a.nama_anggota, a.no_telp, b.judul_buku, 
                    DATEDIFF('$tgl_sekarang', p.tanggal_kembali_seharusnya) as hari_terlambat
             FROM detail_peminjaman dp
             JOIN peminjaman p ON dp.id_peminjaman = p.id
             JOIN anggota a ON p.id_anggota = a.id
             JOIN buku b ON dp.id_buku = b.id
             WHERE dp.status_buku = 'dipinjam' 
             AND p.tanggal_kembali_seharusnya < '$tgl_sekarang'
             ORDER BY hari_terlambat DESC";

$query_late = mysqli_query($conn, $sql_late);
$jumlah_late = mysqli_num_rows($query_late);
?>

<div class="p-6">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-slate-800">Halo, <?= $_SESSION['username']; ?>! 👋</h2>
        <p class="text-slate-500">Selamat datang di panel <?= $_SESSION['role']; ?> Perpusku.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-book text-xl"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Buku</p>
            <h3 class="text-2xl font-black text-slate-800"><?= $buku; ?></h3>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-tags text-xl"></i>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Kategori</p>
            <h3 class="text-2xl font-black text-slate-800"><?= $kategori; ?></h3>
        </div>

        <?php if ($_SESSION['role'] != 'anggota') : ?>
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Anggota</p>
                <h3 class="text-2xl font-black text-slate-800"><?= $anggota; ?></h3>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Buku Dipinjam</p>
                <h3 class="text-2xl font-black text-slate-800"><?= $transaksi; ?></h3>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($_SESSION['role'] == 'anggota') : ?>
        <div class="mt-8 p-8 bg-blue-600 rounded-[2.5rem] text-white">
            <h3 class="text-xl font-bold mb-2">Ingin meminjam buku?</h3>
            <p class="opacity-80 text-sm">Silakan cari buku di menu Katalog, dan temui petugas untuk proses peminjaman.</p>
        </div>
    <?php endif; ?>

    <?php if ($jumlah_late > 0) : ?>
    <div class="mt-12 mb-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-red-500 rounded-full"></div>
            <h3 class="text-xl font-bold text-slate-800">Peringatan Keterlambatan</h3>
            <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-black rounded-full">
                <?= $jumlah_late; ?> PERLU TINDAKAN
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php while($late = mysqli_fetch_assoc($query_late)) : ?>
            <div class="bg-white border-2 border-red-50 border-l-red-500 border-l-4 p-5 rounded-2xl shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-3">
                    <span class="text-[10px] font-black text-red-500 uppercase tracking-widest bg-red-50 px-2 py-1 rounded">
                        Telat <?= $late['hari_terlambat']; ?> Hari
                    </span>
                    <a href="transaksi/detail.php?id=<?= $late['id_peminjaman']; ?>" class="text-slate-400 hover:text-blue-600 transition-colors">
                        <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
                
                <h4 class="font-bold text-slate-800 line-clamp-1"><?= $late['judul_buku']; ?></h4>
                <p class="text-slate-500 text-sm mb-4"><?= $late['nama_anggota']; ?></p>
                
                <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                    <div class="flex items-center gap-2">
                        <i class="fab fa-whatsapp text-emerald-500"></i>
                        <span class="text-xs font-bold text-slate-600"><?= $late['no_telp'] ?? '-'; ?></span>
                    </div>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $late['no_telp']); ?>?text=Halo%20<?= urlencode($late['nama_anggota']); ?>,%20kami%20dari%20Perpustakaan%20ingin%20mengingatkan%20untuk%20mengembalikan%20buku%20<?= urlencode($late['judul_buku']); ?>%20yang%20sudah%20telat%20<?= $late['hari_terlambat']; ?>%20hari.%20Terima%20kasih." 
                       target="_blank"
                       class="text-[10px] font-bold text-blue-600 hover:underline uppercase">
                        Hubungi
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php 
require_once "../layout/footer.php"; 
?>