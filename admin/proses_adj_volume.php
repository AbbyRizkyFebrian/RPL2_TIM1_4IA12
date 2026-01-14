<?php
include 'auth.php'; // Mengambil session username
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = $_POST['id'];
    $tipe   = $_POST['tipe'];
    $jumlah = $_POST['jumlah'];
    $tgl    = $_POST['tgl'];
    $proyek = $_POST['proyek'];
    $admin  = $_SESSION['username']; // Siapa yang melakukan perubahan

    // 1. Ambil data barang saat ini
    $q = mysqli_query($koneksi, "SELECT nama_barang, nama_proyek, volume, harga_satuan FROM pencatatan WHERE id='$id'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $nama_barang = $data['nama_barang'];
        $nama_proyek = $data['nama_proyek'];
        
        // 2. Hitung volume & total baru
        if ($tipe == 'tambah') {
            $vol_baru = $data['volume'] + $jumlah;
        } else {
            $vol_baru = $data['volume'] - $jumlah;
            if ($vol_baru < 0) $vol_baru = 0;
        }
        $total_baru = $vol_baru * $data['harga_satuan'];

        // 3. Update tabel pencatatan
        mysqli_query($koneksi, "UPDATE pencatatan SET volume='$vol_baru', total='$total_baru' WHERE id='$id'");

        // 4. CATAT KE LOG PERUBAHAN (Fitur Baru)
        $sql_log = "INSERT INTO log_perubahan (pencatatan_id, nama_barang, nama_proyek, tipe, jumlah, admin_user) 
                    VALUES ('$id', '$nama_barang', '$nama_proyek', '$tipe', '$jumlah', '$admin')";
        mysqli_query($koneksi, $sql_log);
    }

    header("Location: dashboard.php?tgl=$tgl&proyek=$proyek");
}
?>