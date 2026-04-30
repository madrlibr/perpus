<?php
session_start();
include "konek.php";

// Jika sudah login, langsung lempar ke dashboard agar tidak login lagi
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("location: pages/dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Disarankan pakai password_verify, tapi untuk SMK biasanya plain text/md5 dulu

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Sesi dimulai
        $_SESSION['id_user']  = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role']; // admin/petugas/anggota
        $_SESSION['status']   = "login";

        header("location: pages/dashboard.php");
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Perpustakaan SMK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #e9ecef; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-login { width: 100%; max-width: 400px; border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-login { background: #343a40; color: white; border-radius: 8px; }
        .btn-login:hover { background: #23272b; color: white; }
    </style>
</head>
<body>
    <div class="card card-login p-4">
        <div class="text-center mb-4">
            <h3>LIB-SMK</h3>
            <p class="text-muted">Silakan masuk ke akun Anda</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center py-2" style="font-size: 14px;"><?= $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn btn-login w-100 py-2">Masuk Sekarang</button>
        </form>
    </div>
</body>
</html>