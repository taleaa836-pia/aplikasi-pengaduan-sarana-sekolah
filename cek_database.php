<?php
include 'config/koneksi.php';

echo "--- DIAGNOSA DATABASE SOPA ---\n";
if ($koneksi) {
    echo "Status: KONEKSI BERHASIL\n";
    echo "Host: " . (getenv('DB_HOST') ?: 'localhost') . "\n";
    echo "DB Name: " . (getenv('DB_NAME') ?: 'sopia_db') . "\n";
    echo "------------------------------\n";

    $query = mysqli_query($koneksi, "SELECT id_user, nama, username, role FROM users");
    
    if ($query) {
        $count = mysqli_num_rows($query);
        echo "Jumlah User Ditemukan: $count\n\n";
        
        if ($count > 0) {
            echo "ID | NAMA | USERNAME | ROLE\n";
            echo "------------------------------\n";
            while ($row = mysqli_fetch_assoc($query)) {
                echo $row['id_user'] . " | " . $row['nama'] . " | " . $row['username'] . " | " . $row['role'] . "\n";
            }
        } else {
            echo "Peringatan: Tabel users KOSONG!\n";
        }
    } else {
        echo "Gagal Query: " . mysqli_error($koneksi) . "\n";
    }
} else {
    echo "Status: KONEKSI GAGAL\n";
}
?>
