<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM anggota WHERE id = '$id'"));

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $nisn          = $_POST['nisn'];
    $nama_anggota  = $_POST['nama_anggota'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp       = $_POST['no_telp'];
    $alamat        = $_POST['alamat'];

    $update = mysqli_query($conn, "UPDATE anggota SET 
                                   nisn = '$nisn', 
                                   nama_anggota = '$nama_anggota', 
                                   jenis_kelamin = '$jenis_kelamin', 
                                   no_telp = '$no_telp', 
                                   alamat = '$alamat' 
                                   WHERE id = '$id'");

    if ($update) {
        echo "<script>alert('Data anggota berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="p-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="index.php" class="p-3 bg-white border border-slate-200 rounded-2xl text-slate-400 hover:text-blue-600 hover:border-blue-100 transition-all shadow-sm">
            <i class="fas fa-chevron-left"></i>
        </a>
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Anggota</h2>
            <p class="text-slate-500 font-medium">Memperbarui informasi untuk ID: <span class="text-blue-600">#<?= $data['id']; ?></span></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden relative">
        <!-- Dekorasi Aksen -->
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <i class="fas fa-user-edit fa-6x text-slate-900"></i>
        </div>

        <form action="" method="POST" class="p-10 space-y-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NISN -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1 italic text-blue-600">Nomor Induk (NISN)</label>
                    <input type="text" name="nisn" required value="<?= $data['nisn']; ?>"
                           class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all font-mono font-bold">
                </div>

                <!-- Nama -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap Anggota</label>
                    <input type="text" name="nama_anggota" required value="<?= $data['nama_anggota']; ?>"
                           class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <!-- Gender -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Jenis Kelamin</label>
                    <div class="relative">
                        <select name="jenis_kelamin" required 
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none">
                            <option value="L" <?= $data['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= $data['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- No Telp -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">No. Telepon / WA</label>
                    <input type="text" name="no_telp" required value="<?= $data['no_telp']; ?>"
                           class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <!-- Alamat -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Alamat Domisili</label>
                <textarea name="alamat" rows="4" required 
                          class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all resize-none"><?= $data['alamat']; ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-slate-50">
                <button type="submit" name="update" class="flex-[2] bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-100 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan Data
                </button>
                <a href="index.php" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-4 rounded-2xl text-center transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>