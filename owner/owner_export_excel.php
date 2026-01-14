<?php
include '../admin/auth.php';
include '../config/koneksi.php';

// Menangkap filter agar data yang diekspor sama dengan yang dilihat di layar
$admin_filter = isset($_GET['admin']) ? $_GET['admin'] : '';
$proyek_filter = isset($_GET['proyek']) ? $_GET['proyek'] : '';

// Memberi nama file dengan tanggal hari ini
$filename = "Laporan_Pengeluaran_Global_" . date('Y-m-d') . ".xls";

// Header untuk memberi tahu browser bahwa ini adalah file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$filename");
?>

<h2>Laporan Pengeluaran Global - CV Rizky Cipta Al-Fazza</h2>
<p>Tanggal Cetak: <?= date('d/m/Y H:i'); ?></p>

<table border="1">
    <thead>
        <tr style="background-color: #1a237e; color: white;">
            <th>No.</th>
            <th>Tanggal</th>
            <th>Nama Proyek</th>
            <th>Admin Penginput</th>
            <th>Nama Barang</th>
            <th>Label</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>Total Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM pencatatan WHERE 1=1";
        if($proyek_filter != '') $sql .= " AND nama_proyek = '$proyek_filter'";
        if($admin_filter != '') $sql .= " AND admin_user = '$admin_filter'";
        $sql .= " ORDER BY tanggal DESC";

        $res = mysqli_query($koneksi, $sql);
        $no = 1;
        $grand_total = 0;

        while($row = mysqli_fetch_assoc($res)) {
            $grand_total += $row['total'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                <td><?= $row['nama_proyek']; ?></td>
                <td><?= $row['admin_user']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['label']; ?></td>
                <td><?= $row['volume']; ?></td>
                <td><?= $row['satuan']; ?></td>
                <td><?= $row['harga_satuan']; ?></td>
                <td><?= $row['total']; ?></td>
            </tr>
            <?php
        }
        ?>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td colspan="9" align="right">TOTAL KESELURUHAN:</td>
            <td><?= $grand_total; ?></td>
        </tr>
    </tbody>
</table>