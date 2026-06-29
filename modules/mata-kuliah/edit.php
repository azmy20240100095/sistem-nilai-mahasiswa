<?php
$page_title = "Edit Mata Kuliah";
include '../../includes/header.php';

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get data mata kuliah
$stmt = $conn->prepare("SELECT * FROM mata_kuliah WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    set_alert('danger', 'Data mata kuliah tidak ditemukan!');
    redirect('index.php');
}

$matkul = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk = clean($_POST['kode_mk']);
    $nama_mk = clean($_POST['nama_mk']);
    $sks = clean($_POST['sks']);
    
    $errors = [];
    
    // Validasi
    $valid = validate_required($kode_mk, 'Kode Mata Kuliah');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($nama_mk, 'Nama Mata Kuliah');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($sks, 'SKS');
    if ($valid !== true) $errors[] = $valid;
    
    if (empty($errors)) {
        $valid = validate_numeric($sks, 'SKS');
        if ($valid !== true) $errors[] = $valid;
    }
    
    if (empty($errors)) {
        $valid = validate_range($sks, 1, 6, 'SKS');
        if ($valid !== true) $errors[] = $valid;
    }
    
    if (empty($errors)) {
        $valid = validate_kode_mk_unique($conn, $kode_mk, $id);
        if ($valid !== true) $errors[] = $valid;
    }
    
    // Jika tidak ada error, update data
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE mata_kuliah SET kode_mk = ?, nama_mk = ?, sks = ? WHERE id = ?");
        $stmt->bind_param("ssii", $kode_mk, $nama_mk, $sks, $id);
        
        if ($stmt->execute()) {
            set_alert('success', 'Data mata kuliah berhasil diupdate!');
            redirect('index.php');
        } else {
            set_alert('danger', 'Gagal mengupdate data mata kuliah!');
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
                <h2><i class="bi bi-pencil-square"></i> Edit Mata Kuliah</h2>
                <p class="text-muted">Form edit data mata kuliah</p>
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
                        <div class="mb-3">
                            <label for="kode_mk" class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kode_mk" name="kode_mk" value="<?php echo isset($_POST['kode_mk']) ? $_POST['kode_mk'] : $matkul['kode_mk']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_mk" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_mk" name="nama_mk" value="<?php echo isset($_POST['nama_mk']) ? $_POST['nama_mk'] : $matkul['nama_mk']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="sks" class="form-label">SKS <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="sks" name="sks" value="<?php echo isset($_POST['sks']) ? $_POST['sks'] : $matkul['sks']; ?>" min="1" max="6" required>
                            <small class="text-muted">SKS harus antara 1-6</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
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
