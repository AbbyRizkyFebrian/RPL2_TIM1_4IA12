<?php
$koneksi = mysqli_connect("localhost", "root", "", "kelompok_pppl");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
