<?php
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    // Redirect ke halaman dashboard jika sudah login
    header("Location: dashboard.php");
    exit;
} else {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit;
}
?>
