<?php
// Ambil environment variables dengan beberapa fallback nama umum
$host = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: getenv('MYSQL_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: "root";
$pass = getenv('DB_PASSWORD') ?: getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: getenv('DB_PASS') ?: ""; 
$db   = getenv('DB_NAME') ?: getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: "sopia_db";
$port = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: getenv('MYSQL_PORT') ?: "3306";

// Coba parsing DATABASE_URL jika ada (Sering digunakan di Heroku/Vercel)
if (getenv('DATABASE_URL')) {
    $db_parsed = parse_url(getenv('DATABASE_URL'));
    $host = $db_parsed['host'] ?? $host;
    $user = $db_parsed['user'] ?? $user;
    $pass = $db_parsed['pass'] ?? $pass;
    $db   = ltrim($db_parsed['path'] ?? $db, '/');
    $port = $db_parsed['port'] ?? $port;
}

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

