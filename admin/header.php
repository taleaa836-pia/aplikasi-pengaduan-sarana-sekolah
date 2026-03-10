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

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'admin') {
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
    <title>Admin Dashboard - Sopia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #fff; 
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        main {
            margin-left: 240px; /* Adjust based on sidebar width */
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none; 
            }
            main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    
<header class="navbar navbar-dark sticky-top bg-green flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">ADMIN</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3 bg-red text-white" href="../auth/logout.php">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" aria-current="page" href="index.php">
              <i class="bi bi-house-door me-2"></i>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pengaduan.php' ? 'active' : ''; ?>" href="pengaduan.php">
              <i class="bi bi-file-text me-2"></i>
              Data Pengaduan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'siswa.php' ? 'active' : ''; ?>" href="siswa.php">
              <i class="bi bi-people me-2"></i>
              Data Siswa
            </a>
          </li>
          
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span>Laporan</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <!-- Add report links if needed -->
             <li class="nav-item">
            <a class="nav-link" href="cetak_laporan.php" target="_blank">
              <i class="bi bi-printer me-2"></i>
              Cetak Laporan
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
