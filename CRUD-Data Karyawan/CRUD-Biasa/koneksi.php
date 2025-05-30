<?php
$connect = mysqli_connect("localhost", "root", "", "uniska_praktikum_maulana");
if (!$connect) {
    exit("Gagal koneksi ke database");
}


function tanggal_indo($tanggal) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}


function hitung_usia($tgl_lahir) {
    $tgl_lahir = new DateTime($tgl_lahir);
    $sekarang = new DateTime();
    $diff = $sekarang->diff($tgl_lahir);
    if ($diff->y < 1 && $diff->m < 1) {
        return $diff->d . " hari yang lalu";
    }
    return "$diff->y tahun, $diff->m bulan, $diff->d hari";
}
?>
