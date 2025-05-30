<?php
include 'koneksi.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list.php?msg=error&action=delete");
    exit();
}

$id = cleanInput($_GET['id']);


$query = "SELECT * FROM karyawan WHERE id = '$id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    header("Location: list.php?msg=notfound");
    exit();
}

$karyawan = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $query = "DELETE FROM karyawan WHERE id = '$id'";
    
    if ($conn->query($query) === TRUE) {
        header("Location: list.php?msg=success&action=delete&name=" . urlencode($karyawan['nama']));
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        .card-custom {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        .warning-card {
            background: linear-gradient(45deg, #fff3cd, #ffeaa7);
            border-left: 5px solid #ffc107;
        }
        .danger-card {
            background: linear-gradient(45deg, #f8d7da, #f5c6cb);
            border-left: 5px solid #dc3545;
        }
        .btn-danger-gradient {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            color: white;
        }
        .btn-danger-gradient:hover {
            background: linear-gradient(45deg, #c82333, #dc3545);
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    
    
    <div class="gradient-bg text-white py-4 mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="mb-0"><i class="bi bi-trash-fill me-2"></i>Hapus Data Karyawan</h1>
                    <p class="mb-0 opacity-75">Konfirmasi Penghapusan Data Karyawan</p>
                </div>
                <div class="col-auto">
                    <a href="list.php" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                
                <div class="card warning-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-exclamation-triangle-fill display-4 text-warning"></i>
                            </div>
                            <div class="col">
                                <h5 class="mb-1 text-warning">Peringatan!</h5>
                                <p class="mb-0 text-dark">
                                    Anda akan menghapus data karyawan secara permanen. 
                                    <strong>Tindakan ini tidak dapat dibatalkan!</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card card-custom">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-person-x me-2"></i>Informasi Data yang Akan Dihapus</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">NIK</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="bi bi-credit-card text-primary me-2"></i>
                                        <strong><?php echo $karyawan['nik']; ?></strong>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Nama Lengkap</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="bi bi-person text-primary me-2"></i>
                                        <strong><?php echo $karyawan['nama']; ?></strong>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Tempat, Tanggal Lahir</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="bi bi-geo-alt text-primary me-2"></i>
                                        <?php echo $karyawan['tempat_lahir'] . ', ' . formatTanggalIndonesia($karyawan['tanggal_lahir']); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Usia</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="bi bi-calendar text-primary me-2"></i>
                                        <?php echo hitungUsia($karyawan['tanggal_lahir']); ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Jenis Kelamin</label>
                                    <div class="p-2 bg-light rounded">
                                        <?php if ($karyawan['jenis_kelamin'] == 'Laki-laki'): ?>
                                            <span class="badge bg-primary"><i class="bi bi-person-fill me-1"></i>Laki-laki</span>
                                        <?php else: ?>
                                            <span class="badge bg-info"><i class="bi bi-person-fill me-1"></i>Perempuan</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Status</label>
                                    <div class="p-2 bg-light rounded">
                                        <?php if ($karyawan['status_id'] == 1): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Tidak Aktif</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Alamat</label>
                            <div class="p-2 bg-light rounded">
                                <i class="bi bi-house text-primary me-2"></i>
                                <?php echo $karyawan['alamat']; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Dibuat Pada</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="bi bi-clock text-primary me-2"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($karyawan['created_at'])); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Terakhir Diupdate</label>
                                    <div class="p-2 bg-light rounded">
                                        <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($karyawan['updated_at'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card danger-card mt-4">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-question-circle-fill display-1 text-danger mb-3"></i>
                        <h4 class="text-danger mb-3">Apakah Anda yakin ingin menghapus data ini?</h4>
                        <p class="text-muted mb-4">
                            Data karyawan <strong>"<?php echo $karyawan['nama']; ?>"</strong> 
                            dengan NIK <strong>"<?php echo $karyawan['nik']; ?>"</strong> 
                            akan dihapus secara permanen dan tidak dapat dikembalikan.
                        </p>

                        <form method="POST" action="" class="d-inline">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="list.php" class="btn btn-secondary btn-lg me-md-2">
                                    <i class="bi bi-x-circle me-2"></i>Tidak, Batalkan
                                </a>
                                <button type="submit" name="confirm_delete" class="btn btn-danger-gradient btn-lg" 
                                        onclick="return confirm('Apakah Anda benar-benar yakin? Data akan dihapus secara permanen!')">
                                    <i class="bi bi-trash me-2"></i>Ya, Hapus Data
                                </button>
                            </div>
                        </form>
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
        
        document.addEventListener('DOMContentLoaded', function() {
            const cancelBtn = document.querySelector('a[href="list.php"]');
            if (cancelBtn) {
                cancelBtn.focus();
            }
        });

        
        document.querySelector('form').addEventListener('submit', function(e) {
            const confirmed = confirm(
                'PERINGATAN TERAKHIR!\n\n' +
                'Data karyawan "<?php echo $karyawan['nama']; ?>" akan dihapus secara permanen.\n' +
                'Tindakan ini TIDAK dapat dibatalkan!\n\n' +
                'Apakah Anda yakin ingin melanjutkan?'
            );
            
            if (!confirmed) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>