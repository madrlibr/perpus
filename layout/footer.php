</main> <script>
    /* 1. LOGIKA SIDEBAR */
    const sidebar = document.getElementById('mainSidebar');
    const content = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');

    function openSidebar() {
        if (!sidebar) return;
        sidebar.style.width = "256px";
        content.style.marginLeft = "256px";
        if(toggleIcon) toggleIcon.classList.replace('fa-chevron-right', 'fa-bars');
        localStorage.setItem('sidebarStatus', 'open');
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.style.width = "0px";
        content.style.marginLeft = "0px";
        if(toggleIcon) toggleIcon.classList.replace('fa-bars', 'fa-chevron-right');
        localStorage.setItem('sidebarStatus', 'closed');
    }

    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.style.width === "0px" ? openSidebar() : closeSidebar();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const status = localStorage.getItem('sidebarStatus');
        if (status === 'closed') {
            sidebar.style.transition = "none";
            content.style.transition = "none";
            closeSidebar();
            setTimeout(() => {
                sidebar.style.transition = "width 0.3s ease";
                content.style.transition = "margin-left 0.3s ease";
            }, 100);
        }
    });

        /* 2. NOTIFIKASI BERHASIL (DARI SESSION) */
    <?php if (isset($_SESSION['notif'])) : ?>
        Swal.fire({
            icon: '<?= $_SESSION['notif']['tipe'] ?>',
            title: '<?= $_SESSION['notif']['judul'] ?>',
            text: '<?= $_SESSION['notif']['pesan'] ?>',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            // Animasi masuk yang lebih smooth
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        });
    <?php unset($_SESSION['notif']); endif; ?>

    /* 3. FUNGSI HAPUS (YANG KAMU TANYAKAN) */
    function konfirmasiHapus(url) {
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', 
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    /* 4. FUNGSI LOGOUT */
    function logoutKonfirmasi(url) {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Sesi anda akan berakhir.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Tetap Disini'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>
</b ody>
</html>