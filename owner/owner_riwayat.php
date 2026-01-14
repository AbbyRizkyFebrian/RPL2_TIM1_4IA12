<?php
include '../admin/auth.php'; // Pastikan login
include '../config/koneksi.php'; // Koneksi ke database kelompok_pppl

// Filter dari Owner
$admin_filter = isset($_GET['admin']) ? $_GET['admin'] : '';
$proyek_filter = isset($_GET['proyek']) ? $_GET['proyek'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Global - Owner Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; flex-direction: column; height: 100vh; }
        .top-header { background: #fff; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .main-layout { display: flex; flex: 1; overflow: hidden; }
        
        /* Sidebar Khusus Owner */
        .sidebar { width: 240px; background-color: #2c3e50; color: white; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar li a { display: flex; align-items: center; padding: 15px 20px; text-decoration: none; color: #ecf0f1; border-bottom: 1px solid #34495e; }
        .sidebar li a:hover, .sidebar li a.active { background-color: #34495e; }
        .sidebar li a i { margin-right: 12px; width: 20px; text-align: center; }

        .content { flex: 1; padding: 40px; overflow-y: auto; }
        .filter-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: flex; gap: 15px; align-items: flex-end; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        select, button { padding: 10px; border-radius: 4px; border: 1px solid #ddd; }
        .btn-filter { background: #1a237e; color: white; cursor: pointer; border: none; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        table th, table td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; font-size: 14px; }
        table th { background-color: #f8f9fa; color: #333; }
        .badge-admin { background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>

<div class="top-header">
    <div style="font-weight:bold; font-size:18px;">
        <img src="../pppl_icon.png" width="30" style="vertical-align:middle;"> Owner Panel
    </div>
    <div style="font-size:14px;">Selamat Datang, <b>Owner</b> | <a href="../admin/logout.php" style="color:#d9534f; text-decoration:none; font-weight:bold;">Keluar</a></div>
</div>

<div class="main-layout">
    <div class="sidebar">
        <ul>
            <li><a href="owner_dashboard.php"><i class="fa-solid fa-chart-line"></i> Ringkasan Bisnis</a></li>
            <li><a href="owner_riwayat.php" class="active"><i class="fa-solid fa-history"></i> Riwayat Global</a></li>
            <li><a href="owner_log.php"><i class="fa-solid fa-clipboard-list"></i> Log Perubahan</a></li>
            <li><a href="project_report.php"><i class="fa-solid fa-file-invoice"></i> Laporan Proyek</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Riwayat Seluruh Transaksi</h2>
        
        <form method="GET" class="filter-card">
            <div class="filter-group">
                <label style="font-size:12px;">Pilih Proyek:</label>
                <select name="proyek">
                    <option value="">Semua Proyek</option>
                    <?php
                    $q_p = mysqli_query($koneksi, "SELECT DISTINCT nama_proyek FROM pencatatan");
                    while($p = mysqli_fetch_assoc($q_p)) {
                        $sel = ($proyek_filter == $p['nama_proyek']) ? 'selected' : '';
                        echo "<option value='".$p['nama_proyek']."' $sel>".$p['nama_proyek']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <label style="font-size:12px;">Filter Admin:</label>
                <select name="admin">
                    <option value="">Semua Admin</option>
                    <?php
                    $q_a = mysqli_query($koneksi, "SELECT DISTINCT admin_user FROM pencatatan");
                    while($a = mysqli_fetch_assoc($q_a)) {
                        $sel = ($admin_filter == $a['admin_user']) ? 'selected' : '';
                        echo "<option value='".$a['admin_user']."' $sel>".$a['admin_user']."</option>";
                    }
                    ?>
                </select>
            </div>
    
            <button type="submit" class="btn-filter">TAMPILKAN</button>

            <a href="owner_export_excel.php?proyek=<?= $proyek_filter; ?>&admin=<?= $admin_filter; ?>" 
                style="background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">
                <i class="fa-solid fa-file-excel"></i> EKSPOR EXCEL
            </a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Proyek</th>
                    <th>Nama Barang</th>
                    <th>Admin</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query Owner: Menggabungkan data tanpa batasan admin_user
                $sql = "SELECT * FROM pencatatan WHERE 1=1";
                if($proyek_filter != '') $sql .= " AND nama_proyek = '$proyek_filter'";
                if($admin_filter != '') $sql .= " AND admin_user = '$admin_filter'";
                $sql .= " ORDER BY tanggal DESC";

                $res = mysqli_query($koneksi, $sql);
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                            <td>".date('d/m/Y', strtotime($row['tanggal']))."</td>
                            <td><b>".htmlspecialchars($row['nama_proyek'])."</b></td>
                            <td>".htmlspecialchars($row['nama_barang'])."</td>
                            <td><span class='badge-admin'>".htmlspecialchars($row['admin_user'])."</span></td>
                            <td>Rp ".number_format($row['total'], 0, ',', '.')."</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>