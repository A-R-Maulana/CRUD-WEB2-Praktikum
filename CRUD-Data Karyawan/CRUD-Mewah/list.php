<?php
include 'koneksi.php';


$query = "SELECT * FROM karyawan ORDER BY CAST(nik AS UNSIGNED) ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Sistem Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-custom {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        .btn-gradient {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
        }
        .btn-gradient:hover {
            background: linear-gradient(45deg, #764ba2, #667eea);
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }
        .badge-custom {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body class="bg-light">
    
    
    <div class="gradient-bg text-white py-4 mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="mb-0"><i class="bi bi-people-fill me-2"></i>Data Karyawan</h1>
                    <p class="mb-0 opacity-75">Sistem Manajemen Data Karyawan Perusahaan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        
        <div class="row mb-4">
            <div class="col-md-6">
                <button type="button" class="btn btn-gradient btn-lg" onclick="window.location.href='tambah.php'">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Data
                </button>
            </div>
            <div class="col-md-6 text-end">
                <div class="input-group" style="max-width: 300px; margin-left: auto;">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Cari nama atau NIK..." id="searchInput">
                </div>
            </div>
        </div>

        
        <div class="card card-custom">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center">NO</th>
                                <th scope="col">NIK</th>
                                <th scope="col">NAMA</th>
                                <th scope="col">TEMPAT, TANGGAL LAHIR</th>
                                <th scope="col">USIA</th>
                                <th scope="col">JENIS KELAMIN</th>
                                <th scope="col">ALAMAT</th>
                                <th scope="col">STATUS</th>
                                <th scope="col" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $usia = hitungUsia($row['tanggal_lahir']);
                                    $statusBadge = $row['status_id'] == 1 ? 
                                        '<span class="badge bg-success badge-custom">Aktif</span>' : 
                                        '<span class="badge bg-danger badge-custom">Tidak Aktif</span>';
                                    
                                    $jenisKelamin = $row['jenis_kelamin'] == 'Laki-laki' ? 
                                        '<span class="badge bg-primary badge-custom">Laki-laki</span>' : 
                                        '<span class="badge bg-info badge-custom">Perempuan</span>';
                            ?>
                            <tr>
                                <td class="text-center fw-bold"><?php echo $no; ?></td>
                                <td class="fw-bold text-primary"><?php echo $row['nik']; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['tempat_lahir'] . ', ' . formatTanggalIndonesia($row['tanggal_lahir']); ?></td>
                                <td><?php echo $usia; ?></td>
                                <td><?php echo $jenisKelamin; ?></td>
                                <td><?php echo $row['alamat']; ?></td>
                                <td><?php echo $statusBadge; ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="hapus.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus data <?php echo $row['nama']; ?>?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                $no++;
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-inbox display-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">Belum ada data karyawan</h5>
                                    <p class="text-muted">Klik tombol "Tambah Data" untuk menambahkan karyawan baru</p>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <?php
        $totalKaryawan = $result->num_rows;
        $queryAktif = "SELECT COUNT(*) as aktif FROM karyawan WHERE status_id = 1";
        $resultAktif = $conn->query($queryAktif);
        $karyawanAktif = $resultAktif->fetch_assoc()['aktif'];
        ?>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card card-custom text-center gradient-bg text-white">
                    <div class="card-body">
                        <i class="bi bi-people display-4 mb-3"></i>
                        <h3><?php echo $totalKaryawan; ?></h3>
                        <p class="mb-0">Total Karyawan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom text-center bg-success text-white">
                    <div class="card-body">
                        <i class="bi bi-person-check display-4 mb-3"></i>
                        <h3><?php echo $karyawanAktif; ?></h3>
                        <p class="mb-0">Karyawan Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom text-center bg-warning text-white">
                    <div class="card-body">
                        <i class="bi bi-person-x display-4 mb-3"></i>
                        <h3><?php echo $totalKaryawan - $karyawanAktif; ?></h3>
                        <p class="mb-0">Karyawan Non-Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <footer class="mt-5 py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0">&copy; 2025 Akhmad Rahul Maulana. 2310010146.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const nikText = row.cells[1]?.textContent.toLowerCase() || '';
                const namaText = row.cells[2]?.textContent.toLowerCase() || '';
                
                if (nikText.includes(searchValue) || namaText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>