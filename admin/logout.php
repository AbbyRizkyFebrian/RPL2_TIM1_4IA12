<?php
session_start();

// Menghapus semua variabel session
session_unset();

// Menghancurkan session yang sedang berjalan
session_destroy();

// Mengarahkan pengguna kembali ke halaman login (bukan ke index.php root)
header("Location: login.php");
exit;