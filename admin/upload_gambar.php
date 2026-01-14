<?php
include 'auth.php';
include '../config/koneksi.php';

$notif = "";
if (isset($_POST['update_web'])) {
    $posisi = $_POST['posisi'];
    $gambar = $_FILES['foto']['name'];
    $tmp    = $_FILES['foto']['tmp_name'];
    
    // PERBAIKAN: Mengarah ke assets/beranda
    $path   = "../assets/beranda/" . $gambar;

    if (move_uploaded_file($tmp, $path)) {
        $cek = mysqli_query($koneksi, "SELECT * FROM beranda_gambar WHERE posisi='$posisi'");
        if (mysqli_num_rows($cek) > 0) {
            $sql = "UPDATE beranda_gambar SET nama_file='$gambar' WHERE posisi='$posisi'";
        } else {
            $sql = "INSERT INTO beranda_gambar (posisi, nama_file) VALUES ('$posisi', '$gambar')";
        }
        
        if (mysqli_query($koneksi, $sql)) {
            $notif = "<div style='color:green; background:#e8f5e9; padding:10px; border-radius:5px; margin-bottom:20px;'>Gambar Berhasil Diperbarui di folder assets/beranda!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Website - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
<body>

<div class="wrapper">
    <?php include 'navbar.php'; ?>

    <h1 style="text-align:center; margin-bottom:40px;">Edit Gambar Website</h1>

    <div style="max-width: 1000px; margin: 0 auto;">
        <?= $notif; ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
            <div style="background:white; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <h3>Upload Gambar Baru</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <select name="posisi" required style="width:100%; padding:10px; margin-bottom:15px;">
                        <option value="hero">Banner Utama (Hero)</option>
                        <option value="layanan1">Layanan 1</option>
                        <option value="layanan2">Layanan 2</option>
                        <option value="portofolio1">Gambar Portofolio 1</option>
                        <option value="portofolio2">Gambar Portofolio 2</option>
                    </select>
                    <input type="file" name="foto" accept="image/*" required style="margin-bottom:15px;">
                    <button type="submit" name="update_web" style="background:#6c5ce7; color:white; border:none; padding:12px; width:100%; border-radius:4px; font-weight:bold; cursor:pointer;">UPDATE</button>
                </form>
            </div>

            <div style="background:white; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <h3>Daftar Gambar Aktif</h3>
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <?php
                    $imgs = mysqli_query($koneksi, "SELECT * FROM beranda_gambar");
                    while($row = mysqli_fetch_assoc($imgs)) {
                        // PERBAIKAN: Path untuk menampilkan gambar
                        $sumber = "../assets/beranda/" . $row['nama_file'];
                        echo "<tr style='border-bottom:1px solid #eee;'>
                                <td style='padding:10px;'><b>".ucfirst($row['posisi'])."</b></td>
                                <td style='padding:10px;'>";
                        if (file_exists($sumber) && !empty($row['nama_file'])) {
                            echo "<img src='$sumber' width='100' style='border-radius:4px;'>";
                        } else {
                            echo "<span style='color:red;'>File tidak ditemukan</span>";
                        }
                        echo "</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    </main></div></div> 
</body>
</html>