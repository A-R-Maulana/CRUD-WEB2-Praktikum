<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'uniska_praktikum_maulana';


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$conn->set_charset("utf8");


function cleanInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}


function formatTanggalIndonesia($tanggal) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}


function hitungUsia($tanggal_lahir) {
    $lahir = new DateTime($tanggal_lahir);
    $sekarang = new DateTime();
    
    
    if ($lahir > $sekarang) {
        $selisih = $lahir->diff($sekarang);
        return "Lahir " . $selisih->days . " hari lagi";
    }
    
    $usia = $sekarang->diff($lahir);
    
    if ($usia->y > 0) {
        return $usia->y . " tahun, " . $usia->m . " bulan, " . $usia->d . " hari";
    } elseif ($usia->m > 0) {
        return $usia->m . " bulan, " . $usia->d . " hari";
    } else {
        return $usia->d . " hari yang lalu";
    }
}


function generateNIK() {
    global $conn;
    
    
    $query = "SELECT nik FROM karyawan ORDER BY CAST(nik AS UNSIGNED) DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNIK = (int)$row['nik'];
        $newNIK = str_pad($lastNIK + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newNIK = '001';
    }
    
    return $newNIK;
}


function cekNIK($nik, $id = null) {
    global $conn;
    
    $query = "SELECT id FROM karyawan WHERE nik = '$nik'";
    if ($id !== null) {
        $query .= " AND id != $id";
    }
    
    $result = $conn->query($query);
    return $result->num_rows > 0;
}
?>