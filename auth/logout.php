<?php
if (session_status() === PHP_SESSION_NONE) {
    if (is_dir('/tmp') && is_writable('/tmp')) {
        session_save_path('/tmp');
    }
    session_start();
}
session_destroy();

// Hapus Cookie backup
setcookie('sopia_auth', '', time() - 3600, "/");

header("Location: login.php?pesan=logout");
exit;
