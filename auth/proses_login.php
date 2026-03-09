<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    if (is_dir('/tmp') && is_writable('/tmp')) {
        session_save_path('/tmp');
    }
    session_start();
}
include __DIR__ . '/../config/koneksi.php';

$username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
$password = md5(trim($_POST['password']));

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");

if (!$query) {
    die("Error Database: " . mysqli_error($koneksi));
}

$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);

    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = "login";

    // Backup ke Cookie Terkonsolidasi (Solusi Vercel)
    $auth_data = [
        'id' => $data['id_user'],
        'role' => $data['role'],
        'nama' => $data['nama'],
        'verif' => md5($data['id_user'] . 'SOPIA_SALT')
    ];
    
    // Auto detect HTTPS or Proxy HTTPS for secure flag
    $is_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
                 (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    
    setcookie('sopia_auth', json_encode($auth_data), time() + 86400, "/", "", $is_secure, true);

    if ($data['role'] == "admin") {
        session_write_close();
        header("Location: ../admin/index.php?pesan=berhasil");
        exit;
    } else if ($data['role'] == "siswa") {
        session_write_close();
        header("Location: ../siswa/index.php?pesan=berhasil");
        exit;
    }
} else {
    session_write_close();
    header("Location: login.php?pesan=gagal");
    exit;
}
ob_end_flush();
