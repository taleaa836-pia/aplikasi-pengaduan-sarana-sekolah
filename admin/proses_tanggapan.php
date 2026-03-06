<?php
session_start();
include __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php?pesan=belum_login");
    exit;
}

$id_pengaduan = $_POST['id_pengaduan'];
$id_admin = $_POST['id_admin'];
$isi_tanggapan = $_POST['isi_tanggapan'];
$status = $_POST['status'];
$tanggal = date('Y-m-d H:i:s');

// Insert tanggapan
$query_tanggapan = "INSERT INTO tanggapan (id_pengaduan, id_admin, isi_tanggapan, tanggal_tanggapan) VALUES ('$id_pengaduan', '$id_admin', '$isi_tanggapan', '$tanggal')";

if (mysqli_query($koneksi, $query_tanggapan)) {
    // Update status pengaduan
    $query_status = "UPDATE pengaduan SET status='$status' WHERE id_pengaduan='$id_pengaduan'";
    mysqli_query($koneksi, $query_status);
    
    header("Location: tanggapan.php?id=$id_pengaduan&pesan=sukses");
} else {
    header("Location: tanggapan.php?id=$id_pengaduan&pesan=gagal");
}
?>
