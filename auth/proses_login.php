<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path('/tmp');
    session_start();
}
include __DIR__ . '/../config/koneksi.php';

$username = trim($_POST['username']);
$password = md5(trim($_POST['password']));

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);

    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = "login";

    if ($data['role'] == "admin") {
        header("Location: ../admin/index.php?pesan=berhasil");
        exit;
    } else if ($data['role'] == "siswa") {
        header("Location: ../siswa/index.php?pesan=berhasil");
        exit;
    } else {
        header("Location: login.php?pesan=gagal");
        exit;
    }
} else {
    header("Location: login.php?pesan=gagal");
    exit;
}
