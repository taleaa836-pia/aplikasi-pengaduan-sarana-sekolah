<?php
$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASSWORD') ?: "";
$db   = getenv('DB_NAME') ?: "sopia_db";
$port = getenv('DB_PORT') ?: "3306";
$ssl_ca = getenv('DB_SSL_CA'); // Jalur opsional ke SSL CA untuk Aiven

$koneksi = mysqli_init();

if ($ssl_ca && $ssl_ca !== 'REQUIRED') {
    // Check if DB_SSL_CA environment variable contains the certificate content or a path
    if (strpos($ssl_ca, '-----BEGIN CERTIFICATE-----') !== false) {
        // If certificate content, write it to a temporary file
        $temp_ca = tempnam(sys_get_temp_dir(), 'ca_');
        file_put_contents($temp_ca, $ssl_ca);
        $ssl_ca = $temp_ca;
    }
    
    // Set SSL if we have a path (either a temp file or a direct path provided in DB_SSL_CA)
    if (file_exists($ssl_ca)) {
        mysqli_ssl_set($koneksi, NULL, NULL, $ssl_ca, NULL, NULL);
    }
}

// Koneksi dengan port
if (!mysqli_real_connect($koneksi, $host, $user, $pass, $db, $port)) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

