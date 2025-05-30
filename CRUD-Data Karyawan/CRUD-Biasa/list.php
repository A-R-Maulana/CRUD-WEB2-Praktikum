<?php
include 'koneksi.php';

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = mysqli_query($connect, "SELECT * FROM karyawan 
    WHERE nama LIKE '%$cari%' OR nik LIKE '%$cari%' 
    ORDER BY id ASC");
?>

<h2>Data Karyawan</h2>

<form method="GET">
    <input type="text" name="cari" placeholder="Cari Nama/NIK" value="<?= $cari ?>">
    <input type="submit" value="Cari">
</form>

<a href="tambah.php">Tambah Data</a><br><br>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Tempat, Tanggal Lahir</th>
        <th>Usia</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
            <td>$no</td>
            <td>{$row['nik']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['tempat_lahir']}, " . tanggal_indo($row['tanggal_lahir']) . "</td>
            <td>" . hitung_usia($row['tanggal_lahir']) . "</td>
            <td>{$row['jenis_kelamin']}</td>
            <td>{$row['alamat']}</td>
            <td>
                <a href='edit.php?id={$row['id']}'>Edit</a> |
                <a href='hapus.php?id={$row['id']}' onclick=\"return confirm('Yakin?')\">Hapus</a>
            </td>
        </tr>";
        $no++;
    }
    ?>
</table>
