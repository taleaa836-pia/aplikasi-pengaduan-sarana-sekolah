<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path('/tmp');
    session_start();
}
session_destroy();
header("Location: login.php?pesan=logout");
?>
