<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

include '../config/koneksi.php';

$posisi = $_POST['posisi'];
$file   = $_FILES['gambar'];

$allowed = ['jpg','jpeg','png'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    die("Format file tidak diizinkan!");
}

$namaBaru = uniqid() . '.' . $ext;
$tujuan = "../assets/beranda/" . $namaBaru;

if (move_uploaded_file($file['tmp_name'], $tujuan)) {
    mysqli_query($koneksi,
        "UPDATE beranda_gambar SET nama_file='$namaBaru' WHERE posisi='$posisi'"
    );
    header("Location: upload_gambar.php?success=1");
} else {
    echo "Upload gagal!";
}
