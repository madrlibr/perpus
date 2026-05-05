<?php
require_once "../../konek.php";
proteksi_admin_petugas();

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_akhir = $_GET['tgl_akhir'];
$id_user   = $_SESSION['id'] ?? $_SESSION['id_user'];

// 1. Simpan ke riwayat tabel laporan (Sesuai Skema Kamu)
$jenis = "Laporan Sirkulasi";
$isi   = "Mencetak laporan periode $tgl_mulai s/d $tgl_akhir";
mysqli_query($conn, "INSERT INTO laporan (id_user, jenis_laporan, isi_laporan) VALUES ('$id_user', '$jenis', '$isi')");

// 2. Ambil data untuk tabel laporan
$sql = "SELECT p.*, a.nama_anggota, a.nisn, b.judul_buku, u.nama_lengkap as petugas 
        FROM peminjaman p
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON p.id_buku = b.id
        JOIN users u ON p.id_user = u.id
        WHERE p.tanggal_pinjam BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        ORDER BY p.tanggal_pinjam ASC";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan - Perpus</title>
    <style>
        @page { size: A4; margin: 1.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #111; }
        .kop { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .kop p { margin: 5px 0 0; font-size: 10pt; font-style: italic; }
        .judul { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #000; }
        th { padding: 10px; background: #f2f2f2; font-size: 10pt; }
        td { padding: 8px; font-size: 10pt; }
        .footer { float: right; width: 250px; text-align: center; margin-top: 30px; }
        .space { height: 80px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="kop">
        <h1>Perpustakaan SMKS NURUL ISLAM</h1>
        <p>Jl. Raya bandung, Cianjur, Jawa Barat - Indonesia</p>
    </div>

    <div class="judul">LAPORAN PEMINJAMAN BUKU</div>
    
    <p style="font-size: 10pt;">
        Periode: <strong><?= date('d M Y', strtotime($tgl_mulai)); ?></strong> s/d <strong><?= date('d M Y', strtotime($tgl_akhir)); ?></strong>
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Peminjam (NISN)</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td align="center"><?= $no++; ?></td>
                <td align="center"><?= date('d/m/y', strtotime($row['tanggal_pinjam'])); ?></td>
                <td><?= $row['nama_anggota']; ?> (<?= $row['nisn']; ?>)</td>
                <td><?= $row['judul_buku']; ?></td>
                <td align="center"><?= ucfirst($row['status_pinjam']); ?></td>
                <td><?= $row['petugas']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="footer">
        Cianjur, <?= date('d F Y'); ?><br>
        Mengetahui, Petugas Perpustakaan
        <div class="space"></div>
        ( <strong><?= $_SESSION['nama_lengkap'] ?? 'Admin Perpus'; ?></strong> )
    </div>
</body>
</html>