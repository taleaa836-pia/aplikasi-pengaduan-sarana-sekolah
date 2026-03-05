<?php
$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASSWORD') ?: "";
$db   = getenv('DB_NAME') ?: "sopia_db";
$port = getenv('DB_PORT') ?: "3306";
$ssl_ca = getenv('DB_SSL_CA'); // Jalur opsional ke SSL CA untuk Aiven

$koneksi = mysqli_init();

if ($ssl_ca) {
    mysqli_ssl_set($koneksi, NULL, NULL, $ssl_ca, NULL, NULL);
}

// Koneksi dengan port
if (!mysqli_real_connect($koneksi, $host, $user, $pass, $db, $port)) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

