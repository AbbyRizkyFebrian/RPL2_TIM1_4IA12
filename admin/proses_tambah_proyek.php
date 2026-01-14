<?php
include 'auth.php';
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data dari form
    $nama_proyek = mysqli_real_escape_string($koneksi, $_POST['nama_proyek']);
    $tanggal     = $_POST['tanggal_pengerjaan'];
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    // 2. Cek apakah Nama Proyek sudah ada (karena Primary Key tidak boleh duplikat)
    $cek_proyek = mysqli_query($koneksi, "SELECT nama_proyek FROM proyek WHERE nama_proyek = '$nama_proyek'");
    if (mysqli_num_rows($cek_proyek) > 0) {
        echo "<script>alert('Gagal! Nama Proyek tersebut sudah terdaftar.'); window.history.back();</script>";
        exit;
    }

    // 3. Proses Upload Gambar
    $file_name = $_FILES['gambar']['name'];
    $tmp_name  = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];
    $error     = $_FILES['gambar']['error'];

    if ($error === 0) {
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];

        if (in_array($file_ext, $allowed_ext)) {
            // Berikan nama unik untuk file gambar
            $new_img_name = "proyek_" . uniqid() . "." . $file_ext;
            $upload_path  = "../assets/projects/" . $new_img_name;

            // Buat folder jika belum ada
            if (!is_dir('../assets/projects/')) {
                mkdir('../assets/projects/', 0777, true);
            }

            if (move_uploaded_file($tmp_name, $upload_path)) {
                // 4. Simpan ke database
                $query = "INSERT INTO proyek (nama_proyek, tanggal_pengerjaan, deskripsi, gambar) 
                          VALUES ('$nama_proyek', '$tanggal', '$deskripsi', '$new_img_name')";

                if (mysqli_query($koneksi, $query)) {
                    echo "<script>alert('Proyek Berhasil Ditambahkan!'); window.location='dashboard.php';</script>";
                } else {
                    echo "Error Database: " . mysqli_error($koneksi);
                }
            } else {
                echo "<script>alert('Gagal mengunggah gambar ke server.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Format file tidak didukung! Gunakan JPG atau PNG.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file.'); window.history.back();</script>";
    }
}
?>