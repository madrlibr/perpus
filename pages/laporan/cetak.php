<?php
require_once "../../konek.php";
proteksi_admin_petugas();

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_akhir = $_GET['tgl_akhir'];

// QUERY: Ambil detail peminjaman gabung dengan catatan kondisi pengembalian fisik buku
$sql = "SELECT p.tanggal_pinjam, a.nama_anggota, a.nisn, b.judul_buku, dp.status_buku,
               peng.kondisi_buku, peng.denda_terlambat, u.nama_lengkap as petugas 
        FROM detail_peminjaman dp
        JOIN peminjaman p ON dp.id_peminjaman = p.id
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON dp.id_buku = b.id
        JOIN users u ON p.id_user = u.id
        LEFT JOIN pengembalian peng ON p.id = peng.id_peminjaman
        WHERE p.tanggal_pinjam BETWEEN '$tgl_mulai' AND '$tgl_akhir'
        ORDER BY p.tanggal_pinjam ASC";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Sirkulasi</title>
    <style>
        @page { size: A4; margin: 1.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; color: #111; }
        .kop { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .kop p { margin: 5px 0 0; font-size: 10pt; font-style: italic; }
        .judul { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; font-size: 14pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #000; }
        th { padding: 8px; background: #f2f2f2; font-size: 10pt; text-transform: uppercase; }
        td { padding: 7px; font-size: 10pt; }
        .footer { float: right; width: 250px; text-align: center; margin-top: 30px; }
        .space { height: 70px; }
    </style>
</head>
<body onload="window.print()">
    <div class="kop">
        <h1>Perpustakaan SMKS NURUL ISLAM</h1>
        <p>Jl. Raya bandung, Cianjur, Jawa Barat - Indonesia</p>
    </div>

    <div class="judul">LAPORAN SIRKULASI & KONDISI BUKU</div>
    
    <p style="font-size: 10pt;">
        Periode: <strong><?= date('d M Y', strtotime($tgl_mulai)); ?></strong> s/d <strong><?= date('d M Y', strtotime($tgl_akhir)); ?></strong>
    </p>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 22%;">Peminjam (NISN)</th>
                <th style="width: 32%;">Judul Buku</th>
                <th style="width: 10%;">Kondisi</th>
                <th style="width: 10%;">Denda</th>
                <th style="width: 10%;">Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; $total_seluruh_denda = 0; while($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td align="center"><?= $no++; ?></td>
                <td align="center"><?= date('d/m/y', strtotime($row['tanggal_pinjam'])); ?></td>
                <td><?= $row['nama_anggota']; ?> (<?= $row['nisn']; ?>)</td>
                <td><?= $row['judul_buku']; ?></td>
                <td align="center">
                    <?= $row['status_buku'] == 'kembali' ? ucfirst($row['kondisi_buku']) : 'Dipinjam'; ?>
                </td>
                <td align="right">
                    Rp <?= number_format($row['denda_terlambat'] ?? 0, 0, ',', '.'); ?>
                </td>
                <td><?= $row['petugas']; ?></td>
            </tr>
            <?php 
                $total_seluruh_denda += ($row['denda_terlambat'] ?? 0);
            endwhile; 
            ?>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="5" align="right">TOTAL PENDAPATAN DENDA :</td>
                <td align="right">Rp <?= number_format($total_seluruh_denda, 0, ',', '.'); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Cianjur, <?= date('d F Y'); ?><br>
        Mengetahui, Petugas Perpustakaan
        <div class="space"></div>
        ( <strong><?= $_SESSION['username'] ?? 'Admin Perpustakaan'; ?></strong> )
    </div>
</body>
</html>