<?php
$current_page = basename($_SERVER['PHP_SELF']); // Mengambil nama file aktif
?>
<style>
    :root {
        --primary-navy: #1a237e;
        --sidebar-dark: #2c3e50;
        --accent-blue: #3498db;
        --bg-light: #f4f7f6;
    }

    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: var(--bg-light); overflow: hidden; }
    
    .wrapper { display: flex; flex-direction: column; height: 100vh; }

    /* Top Header */
    .top-header { 
        background: #fff; 
        padding: 10px 25px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        z-index: 1000;
        height: 60px;
    }
    .logo-area { display: flex; align-items: center; gap: 10px; font-weight: bold; font-size: 18px; color: var(--primary-navy); }
    .user-info { display: flex; align-items: center; gap: 20px; font-size: 14px; }
    .btn-keluar { background: #d9534f; color: white; text-decoration: none; padding: 7px 15px; border-radius: 4px; font-weight: bold; font-size: 13px; }

    /* Main Container */
    .main-container { display: flex; flex: 1; overflow: hidden; }

    /* Sidebar */
    .sidebar { width: 250px; background-color: var(--sidebar-dark); flex-shrink: 0; overflow-y: auto; }
    .sidebar ul { list-style: none; padding: 20px 0; margin: 0; }
    .sidebar li a { 
        display: flex; align-items: center; padding: 15px 25px; 
        text-decoration: none; color: #ecf0f1; font-size: 13px; 
        border-left: 4px solid transparent; transition: 0.3s; 
    }
    .sidebar li a i { margin-right: 15px; width: 20px; text-align: center; }
    .sidebar li a.active, .sidebar li a:hover { 
        background: rgba(255,255,255,0.05); 
        border-left: 4px solid var(--accent-blue); 
        color: #fff; 
        font-weight: bold;
    }
    .sidebar-label { padding: 15px 25px 5px; font-size: 11px; color: #7f8c8d; text-transform: uppercase; font-weight: bold; }

    /* Content Area */
    .content { flex: 1; padding: 30px; overflow-y: auto; }
</style>

<div class="wrapper">
    <header class="top-header">
        <div class="logo-area">
            <img src="../assets/images/pppl_icon.png" width="30"> Pencatatan Admin
        </div>
        <div class="user-info">
            <div>Halo, <b><?= htmlspecialchars($_SESSION['username']); ?></b></div>
            <a href="logout.php" class="btn-keluar"><i class="fa-solid fa-power-off"></i> Keluar</a>
        </div>
    </header>

    <div class="main-container">
        <nav class="sidebar">
            <ul>
                <div class="sidebar-label">Utama</div>
                <li>
                    <a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                        <i class="fa-solid fa-pen-to-square"></i> Pencatatan Admin
                    </a>
                </li>
                
                <div class="sidebar-label">Manajemen</div>
                <li>
                    <a href="tambah_proyek.php" class="<?= $current_page == 'tambah_proyek.php' ? 'active' : '' ?>">
                        <i class="fa-solid fa-folder-plus"></i> Tambah Proyek
                    </a>
                </li>
                <li>
                    <a href="upload_gambar.php" class="<?= $current_page == 'upload_gambar.php' ? 'active' : '' ?>">
                        <i class="fa-solid fa-image"></i> Edit Website
                    </a>
                </li>
            </ul>
        </nav>
        <main class="content">