<?php
include '../admin/auth.php'; // Memastikan login
include '../config/koneksi.php'; // Koneksi ke database

// Proteksi Halaman: Hanya boleh diakses oleh Owner
if ($_SESSION['role'] !== 'owner') {
    header("Location: dashboard.php");
    exit;
}

$bulan_pilihan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun_pilihan = date('Y');
$proyek_pilihan = isset($_GET['proyek']) ? $_GET['proyek'] : '';
$detail_proyek = null; 
$q_barang = null;

if (!empty($proyek_pilihan)) {
    $q_proyek = mysqli_query($koneksi, "SELECT * FROM proyek WHERE nama_proyek = '$proyek_pilihan'");
    $detail_proyek = mysqli_fetch_assoc($q_proyek);
    if ($detail_proyek) {
        $q_barang = mysqli_query($koneksi, "SELECT * FROM pencatatan 
                    WHERE nama_proyek = '$proyek_pilihan' 
                    AND MONTH(tanggal) = '$bulan_pilihan' 
                    AND YEAR(tanggal) = '$tahun_pilihan' 
                    ORDER BY tanggal ASC");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Project Report - Owner Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Mengambil gaya dari owner_dashboard.php & owner_riwayat.php */
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; flex-direction: column; height: 100vh; }
        .top-header { background: #fff; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .main-layout { display: flex; flex: 1; overflow: hidden; }
        
        /* Sidebar Style */
        .sidebar { width: 240px; background-color: #2c3e50; color: white; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar li a { display: flex; align-items: center; padding: 15px 20px; text-decoration: none; color: #ecf0f1; border-bottom: 1px solid #34495e; transition: 0.3s; }
        .sidebar li a:hover, .sidebar li a.active { background-color: #34495e; border-left: 4px solid #3498db; }
        .sidebar li a i { margin-right: 12px; width: 20px; text-align: center; }

        .content { flex: 1; padding: 40px; overflow-y: auto; }
        
        /* Filter Card Style */
        .filter-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: flex; gap: 15px; align-items: flex-end; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        select, button { padding: 10px; border-radius: 4px; border: 1px solid #ddd; }
        .btn-filter { background: #1a237e; color: white; cursor: pointer; border: none; font-weight: bold; }

        /* Project Info & Table */
        .project-info-row { display: flex; gap: 20px; margin-bottom: 30px; }
        .project-img-box { width: 250px; height: 300px; background: #eee; border-radius: 8px; overflow: hidden; border: 1px solid #ddd; }
        .project-img-box img { width: 100%; height: 100%; object-fit: cover; }
        .project-desc-box { flex: 1; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table th, table td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; font-size: 14px; }
        table th { background-color: #f8f9fa; color: #333; }
    </style>
</head>
<body>

<div class="top-header">
    <div style="font-weight:bold; font-size:18px;">
        <img src="../pppl_icon.png" width="30" style="vertical-align:middle;"> Owner Panel
    </div>
    <div style="font-size:14px;">Selamat Datang, <b>Owner</b> | <a href="logout.php" style="color:#d9534f; text-decoration:none; font-weight:bold;">Keluar</a></div>
</div>

<div class="main-layout">
    <div class="sidebar">
        <ul>
            <li><a href="owner_dashboard.php"><i class="fa-solid fa-chart-line"></i> Ringkasan Bisnis</a></li>
            <li><a href="owner_riwayat.php"><i class="fa-solid fa-history"></i> Riwayat Global</a></li>
            <li><a href="owner_log.php"><i class="fa-solid fa-clipboard-list"></i> Log Perubahan</a></li>
            <li><a href="project_report.php" class="active"><i class="fa-solid fa-file-invoice"></i> Laporan Proyek</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 style="margin-bottom: 25px;">Laporan Proyek Detail</h2>
        
        <form method="GET" class="filter-card">
            <div class="filter-group">
                <label style="font-size:12px;">Pilih Bulan:</label>
                <select name="bulan" onchange="this.form.proyek.value=''; this.form.submit()">
                    <?php
                    $bln = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                    foreach($bln as $k => $v) { echo "<option value='$k' ".($bulan_pilihan==$k?'selected':'').">$v</option>"; }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <label style="font-size:12px;">Pilih Proyek:</label>
                <select name="proyek" onchange="this.form.submit()">
                    <option value="">-- Pilih Proyek --</option>
                    <?php
                    $q_list = mysqli_query($koneksi, "SELECT DISTINCT nama_proyek FROM proyek");
                    while($l = mysqli_fetch_assoc($q_list)) { echo "<option value='{$l['nama_proyek']}' ".($proyek_pilihan==$l['nama_proyek']?'selected':'').">{$l['nama_proyek']}</option>"; }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn-filter">TAMPILKAN</button>
        </form>

        <?php if ($detail_proyek): ?>
            <div class="project-info-row">
                <div class="project-img-box">
                    <img src="../assets/projects/<?= $detail_proyek['gambar'] ?>" alt="Project Image">
                </div>
                <div class="project-desc-box">
                    <h3 style="margin-top:0; color: #1a237e;"><?= htmlspecialchars($detail_proyek['nama_proyek']) ?></h3>
                    <p style="font-size: 14px;"><strong>Tanggal:</strong> <?= date('d F Y', strtotime($detail_proyek['tanggal_pengerjaan'])) ?></p>
                    <p style="font-size: 14px;"><strong>Pelaksana:</strong> <?= htmlspecialchars($detail_proyek['dikerjakan_oleh']) ?></p>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                    <p style="font-size: 14px; color: #555; line-height: 1.6;"><?= nl2br(htmlspecialchars($detail_proyek['deskripsi'])) ?></p>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Vol</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; $grand_total=0; while($r=mysqli_fetch_assoc($q_barang)): $grand_total += $r['total']; ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($r['nama_barang']) ?></td>
                            <td><?= $r['volume'] ?></td>
                            <td><?= htmlspecialchars($r['satuan']) ?></td>
                            <td>Rp <?= number_format($r['harga_satuan'],0,',','.') ?></td>
                            <td style="font-weight: bold;">Rp <?= number_format($r['total'],0,',','.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr style="background: #f8f9fa; font-weight: bold;">
                        <td colspan="5" style="text-align: right;">TOTAL PENGELUARAN:</td>
                        <td style="color: #d32f2f;">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align:center; padding:80px; background:#fff; border-radius:8px; border:2px dashed #ccc; color:#7f8c8d;">
                <i class="fa-solid fa-folder-open fa-4x" style="margin-bottom: 20px; opacity: 0.3;"></i>
                <p>Silakan pilih proyek untuk menampilkan laporan pengeluaran mendetail.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>