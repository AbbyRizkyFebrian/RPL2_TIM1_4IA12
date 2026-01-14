<?php
include 'auth.php'; // Proteksi halaman admin
include '../config/koneksi.php'; // Koneksi database

// 1. Menangkap Input Filter
$proyek_filter = isset($_GET['proyek']) ? $_GET['proyek'] : '';
$tgl_pilihan   = isset($_GET['tgl_pilihan']) ? $_GET['tgl_pilihan'] : '';

// 2. Logika Kontrol Visibilitas Tabel
$show_table = false;

// Tabel muncul hanya jika tombol "Terapkan Filter" ATAU "Semua Tanggal" diklik
if (isset($_GET['btn_filter'])) {
    $show_table = true;
} 
if (isset($_GET['btn_all_dates'])) {
    $show_table = true;
    $tgl_pilihan = 'all'; // Mengatur agar query mengambil semua tanggal
}

// 3. Persiapan Query SQL Dinamis
if ($show_table) {
    $sql = "SELECT * FROM pencatatan WHERE 1=1";
    
    // Filter Tanggal: Jika tidak memilih "Semua Tanggal"
    if ($tgl_pilihan !== 'all' && !empty($tgl_pilihan)) {
        $sql .= " AND tanggal = '$tgl_pilihan'";
    }
    
    // Filter Proyek: Hanya jika proyek dipilih (bukan -- Semua Proyek --)
    if (!empty($proyek_filter)) {
        $sql .= " AND nama_proyek = '$proyek_filter'";
    }
    
    $sql .= " ORDER BY tanggal DESC, id DESC";
    $res = mysqli_query($koneksi, $sql);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Pencatatan Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* --- STYLE DASHBOARD --- */
        .form-card { background: white; border: 2.5px solid #a855f7; border-radius: 8px; padding: 25px; max-width: 650px; margin: 0 auto 40px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px; }
        .form-grid input, .form-grid select { padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 100%; }
        
        .btn-simpan { background-color: #4cd137; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-simpan:hover { background-color: #44bd32; }

        .filter-section { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; justify-content: center; margin-bottom: 30px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        
        .btn-navy { background: #1a237e; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-sky { background: #3498db; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; background: white; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 12px 10px; font-size: 13px; text-align: center; }
        table th { background-color: #f8f9fa; color: #333; }

        /* --- MODAL STYLE --- */
        .modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 15% auto; padding: 25px; border-radius: 12px; width: 350px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .input-adj { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #ddd; border-radius: 6px; text-align: center; font-size: 16px; }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <h1 style="text-align:center; margin-bottom: 30px;">Recording (Pencatatan)</h1>

    <div class="filter-section">
        <form method="GET">
            <div style="display: flex; gap: 15px; align-items: flex-end;">
                <div class="filter-group">
                    <label style="font-size: 12px; font-weight: bold;">Pilih Proyek:</label>
                    <select name="proyek" style="padding: 10px; border-radius: 4px; border: 1px solid #ccc; min-width: 200px;">
                        <option value="">-- Semua Proyek --</option>
                        <?php
                        $q = mysqli_query($koneksi, "SELECT nama_proyek FROM proyek ORDER BY nama_proyek ASC");
                        while($p = mysqli_fetch_assoc($q)) {
                            $selected = ($proyek_filter == $p['nama_proyek']) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($p['nama_proyek'])."' $selected>".htmlspecialchars($p['nama_proyek'])."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label style="font-size: 12px; font-weight: bold;">Pilih Tanggal:</label>
                    <div style="display: flex; gap: 5px;">
                        <input type="date" name="tgl_pilihan" value="<?= ($tgl_pilihan !== 'all') ? $tgl_pilihan : '' ?>" style="padding: 9px; border: 1px solid #ccc; border-radius: 4px;">
                        <button type="submit" name="btn_all_dates" value="1" class="btn-sky" title="Tampilkan semua tanggal">Semua Tanggal</button>
                    </div>
                </div>

                <button type="submit" name="btn_filter" value="1" class="btn-navy">Terapkan Filter</button>
                <a href="dashboard.php" style="padding: 10px; background: #eee; color: #333; text-decoration: none; border-radius: 4px; font-size: 13px;">Reset</a>
            </div>
        </form>
    </div>

    <div class="form-card">
        <h3 style="margin-top:0; margin-bottom:15px; color:#a855f7;">Input Pengeluaran Baru</h3>
        <form action="proses_pencatatan.php" method="POST">
            <div class="form-grid">
                <select name="nama_proyek" required>
                    <option value="">-- Pilih Proyek --</option>
                    <?php
                    $q2 = mysqli_query($koneksi, "SELECT nama_proyek FROM proyek");
                    while($p2 = mysqli_fetch_assoc($q2)) { echo "<option value='".htmlspecialchars($p2['nama_proyek'])."'>".htmlspecialchars($p2['nama_proyek'])."</option>"; }
                    ?>
                </select>
                <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-grid">
                <input type="text" name="nama_barang" placeholder="Nama Barang" required>
                <input 
                    type="text" 
                    name="satuan" 
                    placeholder="Satuan (kg, sak, m, dll)" 
                    required 
                    oninput="this.value = this.value.replace(/[0-9]/g, '')"
                    title="Satuan hanya boleh berisi huruf, tidak boleh angka">
            </div>
            <div class="form-grid">
                <input type="number" name="volume" placeholder="Volume" required>
                <input type="number" name="harga_satuan" placeholder="Harga Satuan" required>
            </div>
            <button type="submit" class="btn-simpan">SIMPAN DATA</button>
        </form>
    </div>

    <?php if ($show_table): ?>
        <div style="max-width:1100px; margin:0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <p style="margin-bottom: 15px; font-size: 14px; color: #666;">
                Menampilkan: <b><?= ($proyek_filter ?: 'Seluruh Proyek') ?></b> | 
                Waktu: <b><?= ($tgl_pilihan == 'all' ? 'Seluruh Riwayat' : date('d/m/Y', strtotime($tgl_pilihan))) ?></b>
            </p>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Proyek</th>
                        <th>Barang</th>
                        <th>Vol</th>
                        <th>Total</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($res) > 0) {
                        $no = 1;
                        $grand_total = 0;
                        while($row = mysqli_fetch_assoc($res)) {
                            $grand_total += $row['total'];
                            echo "<tr>
                                    <td>$no</td>
                                    <td>".date('d/m/Y', strtotime($row['tanggal']))."</td>
                                    <td>".htmlspecialchars($row['nama_proyek'])."</td>
                                    <td>".htmlspecialchars($row['nama_barang'])."</td>
                                    <td>{$row['volume']}</td>
                                    <td>Rp ".number_format($row['total'], 0, ',', '.')."</td>
                                    <td>
                                        <button onclick='openModal({$row['id']}, \"kurang\", \"".htmlspecialchars($row['nama_barang'])."\", {$row['volume']})' style='background:#f39c12; color:white; border:none; padding:5px 12px; border-radius:4px; cursor:pointer;'>-</button>
                                        <button onclick='openModal({$row['id']}, \"tambah\", \"".htmlspecialchars($row['nama_barang'])."\", {$row['volume']})' style='background:#4cd137; color:white; border:none; padding:5px 12px; border-radius:4px; cursor:pointer;'>+</button>
                                        <span style='color:#ddd;'> | </span>
                                        <a href='hapus_pencatatan.php?id={$row['id']}&tgl_pilihan=$tgl_pilihan&proyek=$proyek_filter&btn_filter=1' style='color:#d9534f;' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><i class='fa-solid fa-trash'></i></a>
                                    </td>
                                  </tr>";
                            $no++;
                        }
                        echo "<tr style='background: #f8f9fa; font-weight: bold;'>
                                <td colspan='5' style='text-align: right;'>TOTAL PENGELUARAN:</td>
                                <td colspan='2' style='text-align: left; color: #d32f2f;'>Rp ".number_format($grand_total, 0, ',', '.')."</td>
                              </tr>";
                    } else {
                        echo "<tr><td colspan='7' style='padding:20px; color:#999;'>Tidak ada data yang ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align:center; padding:50px; background:#fff; border-radius:8px; border:2px dashed #ccc; max-width:600px; margin:0 auto; color:#777;">
            <i class="fa-solid fa-filter fa-3x" style="margin-bottom:15px; opacity:0.5;"></i>
            <p>Silakan pilih Proyek/Tanggal lalu klik <b>Terapkan Filter</b> atau <b>Semua Tanggal</b> untuk menampilkan data.</p>
        </div>
    <?php endif; ?>

    <div id="volumeModal" class="modal">
        <div class="modal-content">
            <h3 id="modalTitle">Penyesuaian Volume</h3>
            <p id="modalBarang" style="font-size:14px; color:#666;"></p>
            <form action="proses_adj_volume.php" method="POST">
                <input type="hidden" name="id" id="modalId">
                <input type="hidden" name="tipe" id="modalTipe">
                <input type="hidden" name="tgl" value="<?= $tgl_pilihan ?>">
                <input type="hidden" name="proyek" value="<?= $proyek_filter ?>">
                <input type="hidden" name="btn_filter" value="1">
                
                <input type="number" name="jumlah" class="input-adj" placeholder="Masukkan jumlah..." required min="1">
                <button type="submit" class="btn-navy" style="width:100%;">Konfirmasi</button>
                <button type="button" onclick="closeModal()" style="background:#eee; border:none; padding:10px; width:100%; border-radius:4px; margin-top:10px; cursor:pointer;">Batal</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, tipe, barang, volSekarang) {
            document.getElementById('modalId').value = id;
            document.getElementById('modalTipe').value = tipe;
            document.getElementById('modalBarang').innerText = "Barang: " + barang + " (Saat ini: " + volSekarang + ")";
            document.getElementById('modalTitle').innerText = (tipe === 'tambah' ? 'Tambah' : 'Kurangi') + " Volume";
            document.getElementById('volumeModal').style.display = 'block';
        }
        function closeModal() { document.getElementById('volumeModal').style.display = 'none'; }

        // Tutup modal jika user klik di luar kotak putih
        window.onclick = function(event) {
            let modal = document.getElementById('volumeModal');
            if (event.target == modal) closeModal();
        }
    </script>

    </main></div></div> 
</body>
</html>