<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM buku WHERE id='$id'"));

if (isset($_POST['update'])) {
    // Pastikan nama di dalam $_POST sesuai dengan atribut 'name' pada tag input/select
    $judul    = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $isbn     = mysqli_real_escape_string($conn, $_POST['isbn']);
    $stok     = $_POST['stok'];
    $tahun    = $_POST['tahun_terbit'];
    $kategori = $_POST['id_kategori'];
    $penulis  = $_POST['id_penulis']; // Perbaikan baris 13: ganti 'penulis' jadi 'id_penulis'
    $penerbit = $_POST['id_penerbit'];
    $rak      = $_POST['id_rak'];

    // Perbaikan baris 21: Pastikan nama kolom database benar (id_penulis, id_penerbit, dll)
    $update = mysqli_query($conn, "UPDATE buku SET 
                                   judul_buku   = '$judul', 
                                   isbn         = '$isbn',
                                   stok         = '$stok',
                                   tahun_terbit = '$tahun',
                                   id_kategori  = '$kategori', 
                                   id_penulis   = '$penulis', 
                                   id_penerbit  = '$penerbit', 
                                   id_rak       = '$rak' 
                                   WHERE id     = '$id'");

    if ($update) {
        echo "<script>alert('Perubahan Berhasil Disimpan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="p-6 max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Informasi Buku</h2>
        <p class="text-slate-500 mt-1 text-sm italic">ID Buku: #<?= $id; ?></p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100">
        <form action="" method="POST" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Judul & ISBN -->
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Buku</label>
                <input type="text" name="judul_buku" value="<?= $data['judul_buku']; ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">ISBN</label>
                <input type="text" name="isbn" value="<?= $data['isbn']; ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="<?= $data['tahun_terbit']; ?>" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Penulis (Dropdown) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Penulis</label>
                <select name="id_penulis" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none">
                    <?php 
                    $pnl = mysqli_query($conn, "SELECT * FROM penulis");
                    while($p = mysqli_fetch_assoc($pnl)) {
                        $selected = ($p['id'] == $data['id_penulis']) ? "selected" : "";
                        echo "<option value='".$p['id']."' $selected>".$p['nama_penulis']."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Penerbit (Dropdown) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Penerbit</label>
                <select name="id_penerbit" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none">
                    <?php 
                    $pnb = mysqli_query($conn, "SELECT * FROM penerbit");
                    while($pb = mysqli_fetch_assoc($pnb)) {
                        $selected = ($pb['id'] == $data['id_penerbit']) ? "selected" : "";
                        echo "<option value='".$pb['id']."' $selected>".$pb['nama_penerbit']."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Kategori (Dropdown) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                <select name="id_kategori" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none">
                    <?php 
                    $kat = mysqli_query($conn, "SELECT * FROM kategori");
                    while($k = mysqli_fetch_assoc($kat)) {
                        $selected = ($k['id'] == $data['id_kategori']) ? "selected" : "";
                        echo "<option value='".$k['id']."' $selected>".$k['nama_kategori']."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Rak (Dropdown) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Rak</label>
                <select name="id_rak" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white outline-none">
                    <?php 
                    $rak_q = mysqli_query($conn, "SELECT * FROM rak");
                    while($r = mysqli_fetch_assoc($rak_q)) {
                        $selected = ($r['id'] == $data['id_rak']) ? "selected" : "";
                        echo "<option value='".$r['id']."' $selected>".$r['nama_rak']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Stok</label>
                <input type="number" name="stok" value="<?= $data['stok']; ?>" required min="0"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Action Buttons -->
            <div class="md:col-span-2 pt-6 flex gap-3">
                <button type="submit" name="update" 
                        class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-amber-100 transition-all active:scale-95">
                    Simpan Perubahan
                </button>
                <a href="index.php" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3.5 rounded-xl text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>