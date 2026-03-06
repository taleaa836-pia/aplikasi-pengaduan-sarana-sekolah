<?php
session_start();
include __DIR__ . '/../config/koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

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
    } else if ($data['role'] == "siswa") {
        header("Location: ../siswa/index.php?pesan=berhasil");
    } else {
        header("Location: login.php?pesan=gagal");
    }
} else {
    header("Location: login.php?pesan=gagal");
}
