<?php
if (session_status() === PHP_SESSION_NONE) {
    if (is_dir('/tmp') && is_writable('/tmp')) {
        session_save_path('/tmp');
    }
    session_start();
}

// Auto-restore session dari Cookie Terkonsolidasi (Solusi Vercel)
if (!isset($_SESSION['status']) && isset($_COOKIE['sopia_auth'])) {
    $auth = json_decode($_COOKIE['sopia_auth'], true);
    if ($auth && isset($auth['verif']) && $auth['verif'] === md5($auth['id'] . 'SOPIA_SALT')) {
        $_SESSION['id_user'] = $auth['id'];
        $_SESSION['role'] = $auth['role'];
        $_SESSION['nama'] = $auth['nama'];
        $_SESSION['status'] = "login";
    }
}
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengaduan Sarana Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="login-card card p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-muted">Login Aplikasi</h4>
            <p class="text-muted">Pengaduan Sarana Sekolah</p>
        </div>

        <form action="proses_login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>
        
        <div class="mt-3 text-center">
            <small>Belum punya akun? Hubungi Admin.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_GET['pesan'])): ?>
    <script>
        const pesan = "<?php echo $_GET['pesan']; ?>";
        if (pesan === 'gagal') {
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: 'Username atau Password salah!',
                confirmButtonColor: '#6BAED6'
            });
        } else if (pesan === 'belum_login') {
            Swal.fire({
                icon: 'warning',
                title: 'Akses Ditolak',
                text: 'Silahkan login terlebih dahulu.',
                confirmButtonColor: '#6BAED6'
            });
        } else if (pesan === 'logout') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Logout',
                text: 'Anda telah berhasil keluar dari sistem.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
    <?php endif; ?>
</body>
</html>
