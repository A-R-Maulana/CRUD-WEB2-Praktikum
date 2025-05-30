<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($connect, "DELETE FROM karyawan WHERE id=$id");
header("Location: list.php");
exit;
?>
