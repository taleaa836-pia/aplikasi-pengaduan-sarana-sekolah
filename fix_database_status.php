<?php
include 'config/koneksi.php';

echo "<h2>Fixing Database Status Enum</h2>";

// 1. Alter the table to include 'ditolak' in ENUM
$sql = "ALTER TABLE pengaduan MODIFY COLUMN status ENUM('baru', 'diproses', 'selesai', 'ditolak') NOT NULL DEFAULT 'baru'";

if (mysqli_query($koneksi, $sql)) {
    echo "<p style='color: green;'>✅ Berhasil menambahkan status 'ditolak' ke dalam database.</p>";
} else {
    echo "<p style='color: red;'>❌ Gagal mengubah database: " . mysqli_error($koneksi) . "</p>";
}

echo "<br><a href='admin/index.php'>Kembali ke Dashboard</a>";
?>
