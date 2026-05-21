<?php
require_once "../konek.php";

echo "Memulai pengisian data baru...<br>";

// 1. TAMBAH USER (Admin & Petugas)
$pass = password_hash('123', PASSWORD_DEFAULT);
mysqli_query($conn, "INSERT INTO users (username, password, nama_lengkap, role) VALUES 
('admin', '$pass', 'Administrator Utama', 'admin'),
('anggota', '123', 'Anggota', 'anggota'),
('petugas1', '$pass', 'Budi Staff', 'petugas')");

// 2. TAMBAH MASTER DATA
mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('Sains'), ('Teknologi'), ('Fiksi'), ('Sejarah'), ('Agama')");
mysqli_query($conn, "INSERT INTO penulis (nama_penulis, biografi) VALUES 
('Tere Liye', 'Penulis novel produktif Indonesia.'),
('Pramoedya Ananta Toer', 'Sastrawan legendaris Indonesia.'),
('Dee Lestari', 'Penulis seri Supernova.')");

mysqli_query($conn, "INSERT INTO penerbit (nama_penerbit, alamat_penerbit) VALUES 
('Gramedia', 'Jakarta Pusat'),
('Bentang Pustaka', 'Yogyakarta'),
('Republika', 'Jakarta Selatan')");

mysqli_query($conn, "INSERT INTO rak (nama_rak, lokasi) VALUES 
('A1', 'Lantai 1 - Rak Sains'),
('B1', 'Lantai 1 - Rak Fiksi'),
('C2', 'Lantai 2 - Rak Sejarah')");

// 3. TAMBAH BUKU (Looping 20 Buku)
$judul_list = ['Pemrograman Web', 'Laskar Pelangi', 'Bumi Manusia', 'Filosofi Teras', 'Negeri 5 Menara', 'Pulang', 'Laut Bercerita'];
for ($i = 1; $i <= 20; $i++) {
    $judul = $judul_list[array_rand($judul_list)] . " Part $i";
    $isbn = "978-602-" . rand(100, 999) . "-" . rand(10, 99);
    $stok = rand(5, 15);
    $tahun = rand(2015, 2024);
    $kat = rand(1, 5);
    $pen = rand(1, 3);
    $penerbit = rand(1, 3);
    $rak = rand(1, 3);

    mysqli_query($conn, "INSERT INTO buku (judul_buku, isbn, stok, tahun_terbit, id_kategori, id_penulis, id_penerbit, id_rak) 
                         VALUES ('$judul', '$isbn', '$stok', '$tahun', '$kat', '$pen', '$penerbit', '$rak')");
}

// 4. TAMBAH ANGGOTA (Looping 15 Anggota)
$nama_anggota = ['Andi', 'Siti', 'Rina', 'Joko', 'Dewi', 'Bambang', 'Maya'];
for ($j = 1; $j <= 15; $j++) {
    $nama = $nama_anggota[array_rand($nama_anggota)] . " " . chr(64 + $j); // Nama A, B, C...
    $nisn = "00" . rand(10000000, 99999999);
    $gender = ($j % 2 == 0) ? 'L' : 'P';
    $telp = "0812" . rand(11111111, 99999999);
    
    mysqli_query($conn, "INSERT INTO anggota (nisn, nama_anggota, jenis_kelamin, no_telp, alamat) 
                         VALUES ('$nisn', '$nama', '$gender', '$telp', 'Jl. Contoh Alamat No. $j')");
}

// 5. SETUP DENDA
mysqli_query($conn, "INSERT INTO pengaturan_denda (harga_denda_per_hari, status_aktif) VALUES (1000.00, 1)");

echo "<strong>Pengisian data dummy selesai!</strong><br>
        <a href='../pages/dashboard.php'>Kembali ke Dashboard!</a>";
?>