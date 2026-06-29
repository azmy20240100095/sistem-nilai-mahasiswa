<?php
$page_title = "Tambah Mahasiswa";
include '../../includes/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        set_alert('danger', 'Token tidak valid. Silakan coba lagi.');
        redirect('create.php');
    }
    
    $nim = clean($_POST['nim']);
    $nama = clean($_POST['nama']);
    $jurusan = clean($_POST['jurusan']);
    $angkatan = clean($_POST['angkatan']);
    
    $errors = [];
    
    // Validasi
    $valid = validate_required($nim, 'NIM');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($nama, 'Nama');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($jurusan, 'Jurusan');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($angkatan, 'Angkatan');
    if ($valid !== true) $errors[] = $valid;
    
    if (empty($errors)) {
        $valid = validate_numeric($angkatan, 'Angkatan');
        if ($valid !== true) $errors[] = $valid;
    }
    
    if (empty($errors)) {
        $valid = validate_nim_unique($conn, $nim);
        if ($valid !== true) $errors[] = $valid;
    }
    
    // Jika tidak ada error, simpan data
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nim, $nama, $jurusan, $angkatan);
        
        if ($stmt->execute()) {
            set_alert('success', 'Data mahasiswa berhasil ditambahkan!');
            redirect('index.php');
        } else {
            set_alert('danger', 'Gagal menambahkan data mahasiswa!');
        }
    }
}
?>

<?php include '../../includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>
        
        <div class="col-md-10 content">
            <div class="content-header">
                <h2><i class="bi bi-plus-circle"></i> Tambah Mahasiswa</h2>
                <p class="text-muted">Form tambah data mahasiswa baru</p>
            </div>

            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo isset($_POST['nim']) ? $_POST['nim'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-select" id="jurusan" name="jurusan" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Teknik Informatika" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                                <option value="Sistem Informasi" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                                <option value="Teknik Komputer" <?php echo (isset($_POST['jurusan']) && $_POST['jurusan'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="angkatan" name="angkatan" value="<?php echo isset($_POST['angkatan']) ? $_POST['angkatan'] : date('Y'); ?>" min="2000" max="<?php echo date('Y'); ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
