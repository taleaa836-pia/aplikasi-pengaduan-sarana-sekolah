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
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: siswa/index.php");
    }
} else {
    header("Location: auth/login.php");
}
exit;
?>
