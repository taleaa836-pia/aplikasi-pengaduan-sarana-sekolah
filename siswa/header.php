<?php
ob_start();
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

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'siswa') {
    session_write_close();
    header("Location: ../auth/login.php?pesan=belum_login");
    exit;
}
include __DIR__ . '/../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - Pengaduan Sarana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-green shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">SMK TERPADU BINA INSAN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" aria-current="page" href="index.php">Buat Pengaduan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'active' : ''; ?>" href="riwayat.php">Riwayat Pengaduan</a>
        </li>
        <li class="nav-item">
          <span class="nav-link text-white me-2 d-none d-lg-block">Halo, <strong><?php echo $_SESSION['nama']; ?></strong></span>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 bg-red text-white rounded shadow-sm" href="../auth/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
