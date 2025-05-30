<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($connect, "SELECT * FROM karyawan WHERE id=$id");
$data = mysqli_fetch_array($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $tempat = $_POST['tempat_lahir'];
    $tgl = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];

    mysqli_query($connect, "UPDATE karyawan SET nik='$nik', nama='$nama', tempat_lahir='$tempat', tanggal_lahir='$tgl', jenis_kelamin='$jk', alamat='$alamat' WHERE id=$id");

    header("Location: list.php");
    exit;
}
?>

<h2>Edit Data</h2>
<form method="POST">
    NIK: <input type="text" name="nik" value="<?= $data['nik'] ?>"><br>
    Nama: <input type="text" name="nama" value="<?= $data['nama'] ?>"><br>
    Tempat Lahir: <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>"><br>
    Tanggal Lahir: <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>"><br>
    Jenis Kelamin:
    <select name="jenis_kelamin">
        <option <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
        <option <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
    </select><br>
    Alamat: <input type="text" name="alamat" value="<?= $data['alamat'] ?>"><br>
    <input type="submit" value="Update">
</form>
<a href="list.php">Kembali</a>
