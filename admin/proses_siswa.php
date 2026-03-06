<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path('/tmp');
    session_start();
}
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
include __DIR__ . '/../config/koneksi.php';

$aksi = $_GET['aksi'];

if ($aksi == 'tambah') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    // Cek username
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: siswa.php?pesan=username_ada");
    } else {
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', 'siswa')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: siswa.php?pesan=tambah_sukses");
        } else {
            header("Location: siswa.php?pesan=gagal");
        }
    }
} elseif ($aksi == 'update') {
    $id_user = $_POST['id_user'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    
    // Cek username unik kecuali untuk user ini sendiri
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' AND id_user != '$id_user'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: siswa.php?pesan=username_ada");
        exit;
    }

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $query = "UPDATE users SET nama = '$nama', username = '$username', password = '$password' WHERE id_user = '$id_user'";
    } else {
        $query = "UPDATE users SET nama = '$nama', username = '$username' WHERE id_user = '$id_user'";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: siswa.php?pesan=update_sukses");
    } else {
        header("Location: siswa.php?pesan=gagal");
    }
} elseif ($aksi == 'hapus') {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id_user = '$id' AND role = 'siswa'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: siswa.php?pesan=hapus_sukses");
    } else {
        header("Location: siswa.php?pesan=gagal");
    }
}
?>
