<?php
require_once "../../konek.php";
proteksi_admin_petugas();
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";
?>

<div class="p-6 max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-slate-800">Scanner Perpustakaan</h2>
        <p class="text-slate-500 font-medium">Arahkan kamera ke QR Code buku untuk mencari data</p>
    </div>

    <div class="bg-white p-4 rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
        <div id="reader" class="rounded-2xl overflow-hidden border-none"></div>
    </div>

    <div id="result" class="mt-6 text-center hidden">
        <div class="p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold">
            <i class="fas fa-spinner fa-spin mr-2"></i> Mengalihkan ke data buku...
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<script>
    // Inisialisasi scanner di luar agar bisa diakses secara global
    let html5QrcodeScanner;

    function onScanSuccess(decodedText, decodedResult) {
        // Beri tahu user kalau scan berhasil
        document.getElementById('result').classList.remove('hidden');
        
        // Efek suara (opsional)
        try {
            let beep = new Audio("https://www.soundjay.com/button/beep-07.wav");
            beep.play();
        } catch (e) { console.log("Audio play blocked by browser"); }

        // Hentikan scanner sebelum pindah halaman untuk mencegah error memori
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().then(() => {
                // Setelah scanner bersih, baru pindah halaman
                window.location.href = "tambah.php?isbn=" + encodeURIComponent(decodedText);
            }).catch(error => {
                // Jika gagal clear, tetap pindah halaman
                window.location.href = "tambah.php?isbn=" + encodeURIComponent(decodedText);
            });
        }
    }

    // Pastikan elemen DOM sudah siap sebelum merender scanner
    document.addEventListener('DOMContentLoaded', function() {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0 
            }, 
            /* verbose= */ false
        );
        
        html5QrcodeScanner.render(onScanSuccess);
    });
</script>

<?php require_once "../../layout/footer.php"; ?>