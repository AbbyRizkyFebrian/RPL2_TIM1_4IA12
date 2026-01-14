<?php
session_start();

// Mengecek apakah user sudah login melalui variabel session 'loggedin'
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika tidak ada session, paksa kembali ke halaman login
    header("Location: login.php");
    exit;
}