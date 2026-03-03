<?php
session_start();

if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: siswa/index.php");
    }
} else {
    header("Location: auth/login.php");
}
exit;
?>
