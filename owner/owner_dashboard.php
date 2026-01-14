<?php
include '../admin/auth.php';
include '../config/koneksi.php';

// 1. Ambil data pengeluaran bulanan untuk grafik (Tahun Berjalan)
$tahun_sekarang = date('Y');
$query_grafik = mysqli_query($koneksi, "SELECT 
    MONTH(tanggal) as bulan, 
    SUM(total) as total_bulanan 
    FROM pencatatan 
    WHERE YEAR(tanggal) = '$tahun_sekarang' 
    GROUP BY MONTH(tanggal) 
    ORDER BY MONTH(tanggal) ASC");

$data_grafik = array_fill(1, 12, 0); // Siapkan array 12 bulan dengan nilai 0
while ($row = mysqli_fetch_assoc($query_grafik)) {
    $data_grafik[(int)$row['bulan']] = (float)$row['total_bulanan'];
}

// 2. Ambil Statistik Ringkas
$total_proyek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM proyek"));
$total_pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total) as total FROM pencatatan"))['total'];
$total_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT admin_user) as total FROM pencatatan"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Owner - Ringkasan Bisnis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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
        
        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 20px; }
        .stat-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .stat-info h3 { margin: 0; font-size: 14px; color: #7f8c8d; }
        .stat-info p { margin: 5px 0 0; font-size: 22px; font-weight: bold; color: #2c3e50; }

        /* Chart Section */
        .chart-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .chart-header { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .chart-header h2 { margin: 0; font-size: 18px; color: #2c3e50; }
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
            <li><a href="owner_dashboard.php" class="active"><i class="fa-solid fa-chart-line"></i> Ringkasan Bisnis</a></li>
            <li><a href="owner_riwayat.php"><i class="fa-solid fa-history"></i> Riwayat Global</a></li>
            <li><a href="../owner/owner_log.php"><i class="fa-solid fa-clipboard-list"></i> Log Perubahan</a></li>
            <li><a href="project_report.php"><i class="fa-solid fa-file-invoice"></i> Laporan Proyek</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 style="margin-bottom: 25px;">Dashboard Utama</h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;"><i class="fa-solid fa-building"></i></div>
                <div class="stat-info">
                    <h3>Total Proyek</h3>
                    <p><?= $total_proyek; ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #e8f5e9; color: #2e7d32;"><i class="fa-solid fa-wallet"></i></div>
                <div class="stat-info">
                    <h3>Total Pengeluaran</h3>
                    <p>Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff3e0; color: #f57c00;"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info">
                    <h3>Admin Aktif</h3>
                    <p><?= $total_admin; ?></p>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-header">
                <h2>Grafik Pengeluaran Bulanan (<?= $tahun_sekarang; ?>)</h2>
            </div>
            <canvas id="expenseChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Pengeluaran (Rp)',
                data: <?= json_encode(array_values($data_grafik)); ?>,
                backgroundColor: 'rgba(26, 35, 126, 0.7)',
                borderColor: 'rgba(26, 35, 126, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Total: Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>