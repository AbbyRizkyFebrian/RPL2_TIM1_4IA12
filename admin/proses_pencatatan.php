<?php
include 'auth.php';
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_proyek  = mysqli_real_escape_string($koneksi, $_POST['nama_proyek']);
    $tanggal      = $_POST['tanggal'];
    $nama_barang  = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $label        = $_POST['label'];
    $volume       = $_POST['volume'];
    $satuan       = mysqli_real_escape_string($koneksi, $_POST['satuan']);
    $harga_satuan = $_POST['harga_satuan'];
    $total        = $volume * $harga_satuan;
    $admin_user   = $_SESSION['username'];

    $query = "INSERT INTO pencatatan (nama_proyek, tanggal, nama_barang, label, volume, satuan, harga_satuan, total, admin_user) 
              VALUES ('$nama_proyek', '$tanggal', '$nama_barang', '$label', '$volume', '$satuan', '$harga_satuan', '$total', '$admin_user')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php?tgl=$tanggal&proyek=$nama_proyek");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>