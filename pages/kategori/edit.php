<?php
require_once "../../konek.php";
proteksi_admin_petugas();

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kategori WHERE id = '$id'"));

if(isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $update = mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama' WHERE id = '$id'");
    if ($update) {
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
            ];-
            header("Location: index.php");
            exit;
    }
}
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
?>

<div class="p-6 max-w-2xl">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Kategori</h2>
        <p class="text-slate-500 mt-1">Mengubah ID: #<?= $id; ?></p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
        <form method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="<?= $data['nama_kategori']; ?>" required
                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <a href="index.php" class="bg-slate-100 text-slate-600 font-bold py-4 rounded-2xl text-center hover:bg-slate-200 transition-all">Batal</a>
                <button type="submit" name="update" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-blue-100">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>