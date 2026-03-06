<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path('/tmp');
    session_start();
}
include __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'siswa') {
    header("Location: ../auth/login.php?pesan=belum_login");
    exit;
}

$id_user = $_SESSION['id_user'];
$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$isi = $_POST['isi_pengaduan'];
$tanggal = date('Y-m-d H:i:s');
$status = 'baru';

// Upload Gambar
$rand = rand();
$ekstensi =  array('png','jpg','jpeg');
$filename = $_FILES['gambar']['name'];
$ukuran = $_FILES['gambar']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array($ext,$ekstensi) ) {
    header("Location: index.php?pesan=gagal_ekstensi");
} else {
    if($ukuran < 2048000){		
        $xx = $rand.'_'.$filename;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/'.$xx);
        
        $query = "INSERT INTO pengaduan (id_user, id_kategori, judul, isi_pengaduan, gambar, tanggal, status) VALUES ('$id_user', '$kategori', '$judul', '$isi', '$xx', '$tanggal', '$status')";
        
        if(mysqli_query($koneksi, $query)){
            header("Location: index.php?pesan=sukses");
        } else {
            header("Location: index.php?pesan=gagal_db");
        }
    } else {
        header("Location: index.php?pesan=gagal_ukuran");
    }
}
?>
