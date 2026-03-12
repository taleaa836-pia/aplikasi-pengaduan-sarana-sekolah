<?php
if (session_status() === PHP_SESSION_NONE) {
    if (is_dir('/tmp') && is_writable('/tmp')) {
        session_save_path('/tmp');
    }
    session_start();
}
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
    if(!mysqli_query($koneksi, $query_status)) {
        die("Gagal update status: " . mysqli_error($koneksi));
    }
    
    // Debugging (opsional, bisa dihapus setelah fix)
    if(mysqli_affected_rows($koneksi) == 0) {
        // Mungkin statusnya memang sudah sama, atau ada masalah di ID
    }
    
    header("Location: tanggapan.php?id=$id_pengaduan&pesan=sukses");
} else {
    header("Location: tanggapan.php?id=$id_pengaduan&pesan=gagal");
}
?>
