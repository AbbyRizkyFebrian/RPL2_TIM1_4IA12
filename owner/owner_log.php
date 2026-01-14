<?php
include '../admin/auth.php'; 
include '../config/koneksi.php';

// Proteksi Role Owner
if ($_SESSION['role'] !== 'owner') { 
    header("Location: ../admin/dashboard.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Perubahan - Owner Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Sidebar yang sudah disinkronkan efeknya */
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; flex-direction: column; height: 100vh; }
        .top-header { background: #fff; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .main-layout { display: flex; flex: 1; overflow: hidden; }
        
        .sidebar { width: 240px; background-color: #2c3e50; color: white; flex-shrink: 0; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        
        /* Menambahkan transition agar efek lebih halus */
        .sidebar li a { 
            display: flex; 
            align-items: center; 
            padding: 15px 20px; 
            text-decoration: none; 
            color: #ecf0f1; 
            border-bottom: 1px solid #34495e; 
            border-left: 4px solid transparent; 
            transition: 0.3s; 
        }
        
        /* Menambahkan :hover agar ada efek saat kursor diarahkan */
        .sidebar li a:hover, .sidebar li a.active { 
            background-color: #34495e; 
            border-left: 4px solid #3498db; 
            color: #fff;
        }
        
        .sidebar li a i { margin-right: 12px; width: 20px; text-align: center; }

        .content { flex: 1; padding: 40px; overflow-y: auto; }
        
        /* Gaya Tabel Log */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table th, table td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
        table th { background-color: #f8f9fa; color: #333; font-size: 14px; }
        
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .badge-tambah { background: #e8f5e9; color: #2e7d32; }
        .badge-kurang { background: #ffebee; color: #c62828; }
    </style>
</head>
<body>

<div class="top-header">
    <div style="font-weight:bold; font-size:18px;"><img src="../pppl_icon.png" width="30" style="vertical-align:middle;"> Owner Panel</div>
    <div style="font-size:14px;">Selamat Datang, <b>Owner</b> | <a href="../admin/logout.php" style="color:#d9534f; text-decoration:none; font-weight:bold;">Keluar</a></div>
</div>

<div class="main-layout">
    <div class="sidebar">
        <ul>
            <li><a href="owner_dashboard.php"><i class="fa-solid fa-chart-line"></i> Ringkasan Bisnis</a></li>
            <li><a href="owner_riwayat.php"><i class="fa-solid fa-history"></i> Riwayat Global</a></li>
            <li><a href="owner_log.php" class="active"><i class="fa-solid fa-clipboard-list"></i> Log Perubahan</a></li>
            <li><a href="project_report.php"><i class="fa-solid fa-file-invoice"></i> Laporan Proyek</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 style="margin-bottom: 10px;">Riwayat Perubahan Volume</h2>
        <p style="color: #666; margin-bottom: 25px; font-size: 14px;">Memantau aktivitas Admin dalam menyesuaikan volume barang pada pencatatan.</p>

        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Admin</th>
                    <th>Proyek</th>
                    <th>Barang</th>
                    <th>Aksi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($koneksi, "SELECT * FROM log_perubahan ORDER BY waktu DESC");
                while($row = mysqli_fetch_assoc($res)) {
                    $badge = ($row['tipe'] == 'tambah') ? 'badge-tambah' : 'badge-kurang';
                    echo "<tr>
                            <td style='font-size:13px;'>".date('d/m/Y H:i', strtotime($row['waktu']))."</td>
                            <td><b>".htmlspecialchars($row['admin_user'])."</b></td>
                            <td>".htmlspecialchars($row['nama_proyek'])."</td>
                            <td>".htmlspecialchars($row['nama_barang'])."</td>
                            <td><span class='badge $badge'>".htmlspecialchars($row['tipe'])."</span></td>
                            <td style='font-weight:bold;'>".htmlspecialchars($row['jumlah'])."</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>