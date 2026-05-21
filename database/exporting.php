<?php
require_once '../konek.php';

// Tentukan folder tujuan (pastikan folder ini sudah ada dan bisa ditulis/writable)
$folderTujuan = "backup/"; 
if (!is_dir($folderTujuan)) {
    mkdir($folderTujuan, 0777, true);
}

// Nama file berdasarkan waktu agar tidak menimpa file lama
$namaFile = $db . "_" . date("Y-m-d_H-i-s") . ".sql";
$pathFile = $folderTujuan . $namaFile;

// Perintah mysqldump
// Jika di Windows/XAMPP, terkadang perlu path lengkap: "C:/xampp/mysql/bin/mysqldump"
$command = "mysqldump -h $host -u $user -p$pass $db > $pathFile 2>&1";

// Eksekusi perintah
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "Berhasil! Database telah diekspor ke: <b>$pathFile</b>";
} else {
    echo "Gagal mengekspor database. Cek konfigurasi atau path mysqldump.";
    print_r($output); // Untuk melihat error jika gagal
}
?>
