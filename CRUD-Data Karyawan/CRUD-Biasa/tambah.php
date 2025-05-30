<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $tempat = $_POST['tempat_lahir'];
    $tgl = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];

    mysqli_query($connect, "INSERT INTO karyawan (status_id, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat)
        VALUES (1, '$nik', '$nama', '$tempat', '$tgl', '$jk', '$alamat')");

    header("Location: list.php");
    exit;
}
?>

<h2>Tambah Data</h2>
<form method="POST">
    NIK: <input type="text" name="nik"><br>
    Nama: <input type="text" name="nama"><br>
    Tempat Lahir: <input type="text" name="tempat_lahir"><br>
    Tanggal Lahir: <input type="date" name="tanggal_lahir"><br>
    Jenis Kelamin:
    <select name="jenis_kelamin">
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select><br>
    Alamat: <input type="text" name="alamat"><br>
    <input type="submit" value="Simpan">
</form>
<a href="list.php">Kembali</a>
