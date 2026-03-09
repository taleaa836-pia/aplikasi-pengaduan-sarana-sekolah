<?php
include 'config/koneksi.php';

echo "<h2>Remote Database Sync</h2>";

// Reset Admin Password
$pass_admin = md5('admin');
$sql = "UPDATE users SET password = '$pass_admin' WHERE username = 'admin'";

if (mysqli_query($koneksi, $sql)) {
    echo "<p style='color:green;'>✅ Password Admin berhasil disinkronkan menjadi 'admin'</p>";
} else {
    echo "<p style='color:red;'>❌ Gagal update password: " . mysqli_error($koneksi) . "</p>";
}

// Optional: Check connection info
echo "<hr>";
echo "Current DB Host: " . $host . "<br>";
echo "DB Name: " . $db . "<br>";
?>
