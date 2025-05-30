<?php
include 'koneksi.php';

$message = '';
$messageType = '';


$autoNIK = generateNIK();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = cleanInput($_POST['nik']);
    $nama = cleanInput($_POST['nama']);
    $tempat_lahir = cleanInput($_POST['tempat_lahir']);
    $tanggal_lahir = cleanInput($_POST['tanggal_lahir']);
    $jenis_kelamin = cleanInput($_POST['jenis_kelamin']);
    $alamat = cleanInput($_POST['alamat']);
    $status_id = cleanInput($_POST['status_id']);
    
    
    if (empty($nik) || empty($nama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($jenis_kelamin) || empty($alamat)) {
        $message = "Semua field harus diisi!";
        $messageType = "danger";
    } elseif (cekNIK($nik)) {
        $message = "NIK sudah ada! Silakan gunakan NIK lain.";
        $messageType = "danger";
    } else {
        $query = "INSERT INTO karyawan (nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, status_id, created_at, updated_at) 
                  VALUES ('$nik', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$status_id', NOW(), NOW())";
        
        if ($conn->query($query) === TRUE) {
            header("Location: list.php?msg=success&action=add");
            exit();
        } else {
            $message = "Error: " . $conn->error;
            $messageType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Karyawan</title>
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
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>
<body class="bg-light">
    
    
    <div class="gradient-bg text-white py-4 mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah Data Karyawan</h1>
                    <p class="mb-0 opacity-75">Formulir Penambahan Data Karyawan Baru</p>
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
                
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="card card-custom">
                    <div class="card-header gradient-bg text-white">
                        <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Informasi Karyawan</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                        <input type="text" class="form-control" id="nik" name="nik" 
                                               value="<?php echo isset($_POST['nik']) ? $_POST['nik'] : $autoNIK; ?>" 
                                               required maxlength="16">
                                    </div>
                                    <small class="text-muted">NIK otomatis: <?php echo $autoNIK; ?></small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="nama" name="nama" 
                                               value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : ''; ?>" 
                                               required maxlength="50">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" 
                                               value="<?php echo isset($_POST['tempat_lahir']) ? $_POST['tempat_lahir'] : ''; ?>" 
                                               required maxlength="32">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                                               value="<?php echo isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : ''; ?>" 
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" 
                                                   id="laki" value="Laki-laki" 
                                                   <?php echo (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="laki">
                                                <i class="bi bi-person-fill text-primary me-1"></i>Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" 
                                                   id="perempuan" value="Perempuan"
                                                   <?php echo (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="perempuan">
                                                <i class="bi bi-person-fill text-info me-1"></i>Perempuan
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status_id" class="form-label fw-bold">Status Karyawan</label>
                                    <select class="form-select" id="status_id" name="status_id">
                                        <option value="1" <?php echo (isset($_POST['status_id']) && $_POST['status_id'] == '1') ? 'selected' : 'selected'; ?>>
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </option>
                                        <option value="0" <?php echo (isset($_POST['status_id']) && $_POST['status_id'] == '0') ? 'selected' : ''; ?>>
                                            <i class="bi bi-x-circle"></i> Tidak Aktif
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" 
                                              required maxlength="200" placeholder="Masukkan alamat lengkap..."><?php echo isset($_POST['alamat']) ? $_POST['alamat'] : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="list.php" class="btn btn-secondary btn-lg me-md-2">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                                <button type="reset" class="btn btn-outline-secondary btn-lg me-md-2">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                </button>
                                <button type="submit" class="btn btn-gradient btn-lg">
                                    <i class="bi bi-save me-2"></i>Simpan Data
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
        
        document.getElementById('nik').addEventListener('input', function() {
            if (this.value === '') {
                this.value = '<?php echo $autoNIK; ?>';
            }
        });

        
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'alamat'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            
            const genderInputs = document.querySelectorAll('input[name="jenis_kelamin"]');
            const genderSelected = Array.from(genderInputs).some(input => input.checked);
            
            if (!genderSelected) {
                isValid = false;
                alert('Pilih jenis kelamin!');
            }

            if (!isValid) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        });
    </script>
</body>
</html>