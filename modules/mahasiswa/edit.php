<?php
$page_title = "Edit Mahasiswa";
include '../../includes/header.php';

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get data mahasiswa
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    set_alert('danger', 'Data mahasiswa tidak ditemukan!');
    redirect('index.php');
}

$mahasiswa = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek CSRF token dulu
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        set_alert('danger', 'Token tidak valid. Silakan coba lagi.');
        redirect('edit.php?id=' . $id);
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
        $valid = validate_nim_unique($conn, $nim, $id);
        if ($valid !== true) $errors[] = $valid;
    }
    
    // Jika tidak ada error, update data
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, angkatan = ? WHERE id = ?");
        $stmt->bind_param("sssii", $nim, $nama, $jurusan, $angkatan, $id);
        
        if ($stmt->execute()) {
            set_alert('success', 'Data mahasiswa berhasil diupdate!');
            redirect('index.php');
        } else {
            set_alert('danger', 'Gagal mengupdate data mahasiswa!');
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
                <h2><i class="bi bi-pencil-square"></i> Edit Mahasiswa</h2>
                <p class="text-muted">Form edit data mahasiswa</p>
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
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo isset($_POST['nim']) ? $_POST['nim'] : $mahasiswa['nim']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : $mahasiswa['nama']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-select" id="jurusan" name="jurusan" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php 
                                $jurusan_value = isset($_POST['jurusan']) ? $_POST['jurusan'] : $mahasiswa['jurusan'];
                                $jurusan_list = ['Teknik Informatika', 'Sistem Informasi', 'Teknik Komputer'];
                                foreach ($jurusan_list as $j): 
                                ?>
                                    <option value="<?php echo $j; ?>" <?php echo ($jurusan_value == $j) ? 'selected' : ''; ?>><?php echo $j; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="angkatan" name="angkatan" value="<?php echo isset($_POST['angkatan']) ? $_POST['angkatan'] : $mahasiswa['angkatan']; ?>" min="2000" max="<?php echo date('Y'); ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update
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
