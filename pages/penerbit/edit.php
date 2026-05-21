<?php 
require_once "../../konek.php"; 
proteksi_admin_petugas();

// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data lama dari database
$ambil_data = mysqli_query($conn, "SELECT * FROM penerbit WHERE id='$id'");
$data = mysqli_fetch_assoc($ambil_data);

// 3. Logika Update Data
if (isset($_POST['update'])) {
    // Perbaikan: Samakan nama variabel agar konsisten
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penerbit']);
    $b = mysqli_real_escape_string($conn, $_POST['alamat_penerbit']);
    
    // Perbaikan: Ganti 'kategori' menjadi 'penulis'
    $query = mysqli_query($conn, "UPDATE penerbit SET nama_penerbit='$nama', alamat_penerbit='$b' WHERE id='$id'");
    
    if ($query) {
        session_start();
        $_SESSION['notif'] = [
            'tipe' => 'success',
            'pesan' => 'Perubahan data berhasil disimpan!',
            'judul' => 'Update Berhasil'
    ];
    header("Location: index.php");
    exit;
    } else {
        $_SESSION['notif'] = [
                'tipe' => 'error',
                'pesan' => 'Gagal memperbarui data: ' . mysqli_error($conn),
                'judul' => 'Oops!'
            ];
            header("Location: index.php");
    exit;
    }
}

require_once "../../layout/header.php"; 
require_once "../../layout/sidebar.php"; 
?>

<div class="max-w-2xl mx-auto p-6">
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="index.php" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-purple-600 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Edit Penerbit</h2>
                <p class="text-sm text-slate-500">Ubah detail alamat atau nama mitra.</p>
            </div>
        </div>
        <span class="px-4 py-1 bg-purple-50 text-purple-600 text-[10px] font-black uppercase rounded-full tracking-widest border border-purple-100">Mode Edit</span>
    </div>

    <form method="POST" action="" class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Nama Perusahaan Penerbit</label>
                <input type="text" name="nama_penerbit" value="<?= $data['nama_penerbit']; ?>" required 
                       class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Alamat Lengkap Kantor</label>
                <textarea name="alamat_penerbit" rows="3" 
                          class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 outline-none transition-all resize-none"><?= $data['alamat_penerbit']; ?></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" name="update" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-purple-100 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-check-double text-sm"></i> Simpan Perubahan
                </button>
                <a href="index.php" class="px-8 py-4 rounded-2xl bg-slate-50 text-slate-500 font-bold hover:bg-slate-100 transition-all text-center border border-slate-100">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once "../../layout/footer.php"; ?>