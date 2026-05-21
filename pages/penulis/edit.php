<?php 
require_once "../../konek.php"; 
proteksi_admin_petugas();

// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data lama dari database
$ambil_data = mysqli_query($conn, "SELECT * FROM penulis WHERE id='$id'");
$data = mysqli_fetch_assoc($ambil_data);

// 3. Logika Update Data
if (isset($_POST['update'])) {
    // Perbaikan: Samakan nama variabel agar konsisten
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penulis']);
    $b = mysqli_real_escape_string($conn, $_POST['biografi']);
    
    // Perbaikan: Ganti 'kategori' menjadi 'penulis'
    $query = mysqli_query($conn, "UPDATE penulis SET nama_penulis='$nama', biografi='$b' WHERE id='$id'");
    
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
            <a href="index.php" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-amber-600 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Edit Penulis</h2>
                <p class="text-sm text-slate-500">Perbarui informasi profil penulis buku.</p>
            </div>
        </div>
        <span class="px-4 py-1 bg-amber-50 text-amber-600 text-[10px] font-black uppercase rounded-full tracking-widest border border-amber-100">Mode Edit</span>
    </div>

    <form method="POST" action="" class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
        
        <div class="space-y-6 relative z-10">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Nama Lengkap Penulis</label>
                <input type="text" name="nama_penulis" value="<?= $data['nama_penulis']; ?>" required 
                       class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2">Biografi Singkat</label>
                <textarea name="biografi" rows="4" 
                          class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all resize-none"><?= $data['biografi']; ?></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" name="update" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-sync-alt text-sm"></i> Perbarui Data
                </button>
                <a href="index.php" class="px-8 py-4 rounded-2xl border border-slate-100 text-slate-400 font-bold hover:bg-slate-50 transition-all text-center">Batal</a>
            </div>
        </div>
    </form>
</div>
<?php require_once "../../layout/footer.php"; ?>