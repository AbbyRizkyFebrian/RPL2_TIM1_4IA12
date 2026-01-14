<?php
include 'auth.php';
include '../config/koneksi.php';

// Logika Simpan Proyek
$pesan = "";
if (isset($_POST['simpan_proyek'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_proyek']);
    $tgl    = $_POST['tanggal_pengerjaan'];
    $oleh   = mysqli_real_escape_string($koneksi, $_POST['dikerjakan_oleh']);
    $desc   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    // Handle Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];
    $path   = "../assets/projects/" . $gambar;

    if (move_uploaded_file($tmp, $path)) {
        $query = "INSERT INTO proyek (nama_proyek, tanggal_pengerjaan, dikerjakan_oleh, deskripsi, gambar) 
                  VALUES ('$nama', '$tgl', '$oleh', '$desc', '$gambar')";
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<div style='color:green; margin-bottom:15px;'><b>Sukses!</b> Proyek berhasil didaftarkan.</div>";
        }
    } else {
        $pesan = "<div style='color:red; margin-bottom:15px;'><b>Gagal!</b> Gambar tidak dapat diunggah.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Proyek - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #1a237e; color: white; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-submit:hover { background: #0d47a1; }
    </style>
</head>
<body>

<div class="wrapper">
    <?php include 'navbar.php'; ?>

    <h1 style="text-align:center; margin-bottom:30px;">Daftarkan Proyek Baru</h1>

    <div class="form-container">
        <?= $pesan; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Proyek</label>
                <input type="text" name="nama_proyek" placeholder="Contoh: Renovasi Gedung A" required>
            </div>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div class="form-group">
                    <label>Tanggal Mulai Pengerjaan</label>
                    <input type="date" name="tanggal_pengerjaan" required>
                </div>
                <div class="form-group">
                    <label>Pelaksana (Dikerjakan Oleh)</label>
                    <input type="text" name="dikerjakan_oleh" value="CV Rizky Cipta Al-Fazza">
                </div>
            </div>
            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan detail singkat proyek..."></textarea>
            </div>
            <div class="form-group">
                <label>Foto Proyek (Gedung/Lokasi)</label>
                <input type="file" name="gambar" accept="image/*" required>
            </div>
            <button type="submit" name="simpan_proyek" class="btn-submit">SIMPAN PROYEK</button>
        </form>
    </div>

    </main></div></div> 
</body>
</html>