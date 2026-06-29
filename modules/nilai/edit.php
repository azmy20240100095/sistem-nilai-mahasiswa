<?php
$page_title = "Edit Nilai";
include '../../includes/header.php';

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get data nilai
$stmt = $conn->prepare("SELECT * FROM nilai WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    set_alert('danger', 'Data nilai tidak ditemukan!');
    redirect('index.php');
}

$nilai_data = $result->fetch_assoc();

// Get data mahasiswa
$mahasiswa_result = $conn->query("SELECT id, nim, nama FROM mahasiswa ORDER BY nim");

// Get data mata kuliah
$matkul_result = $conn->query("SELECT id, kode_mk, nama_mk FROM mata_kuliah ORDER BY kode_mk");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mahasiswa_id = clean($_POST['mahasiswa_id']);
    $mata_kuliah_id = clean($_POST['mata_kuliah_id']);
    $nilai = clean($_POST['nilai']);
    
    $errors = [];
    
    // Validasi
    $valid = validate_required($mahasiswa_id, 'Mahasiswa');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($mata_kuliah_id, 'Mata Kuliah');
    if ($valid !== true) $errors[] = $valid;
    
    $valid = validate_required($nilai, 'Nilai');
    if ($valid !== true) $errors[] = $valid;
    
    if (empty($errors)) {
        $valid = validate_numeric($nilai, 'Nilai');
        if ($valid !== true) $errors[] = $valid;
    }
    
    if (empty($errors)) {
        $valid = validate_range($nilai, 0, 100, 'Nilai');
        if ($valid !== true) $errors[] = $valid;
    }
    
    if (empty($errors)) {
        $valid = validate_nilai_unique($conn, $mahasiswa_id, $mata_kuliah_id, $id);
        if ($valid !== true) $errors[] = $valid;
    }
    
    // Jika tidak ada error, update data
    if (empty($errors)) {
        $grade = calculate_grade($nilai);
        
        $stmt = $conn->prepare("UPDATE nilai SET mahasiswa_id = ?, mata_kuliah_id = ?, nilai = ?, grade = ? WHERE id = ?");
        $stmt->bind_param("iidsi", $mahasiswa_id, $mata_kuliah_id, $nilai, $grade, $id);
        
        if ($stmt->execute()) {
            set_alert('success', 'Data nilai berhasil diupdate!');
            redirect('index.php');
        } else {
            set_alert('danger', 'Gagal mengupdate data nilai!');
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
                <h2><i class="bi bi-pencil-square"></i> Edit Nilai</h2>
                <p class="text-muted">Form edit data nilai mahasiswa</p>
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
                            <label for="mahasiswa_id" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                            <select class="form-select" id="mahasiswa_id" name="mahasiswa_id" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                <?php 
                                $selected_mahasiswa = isset($_POST['mahasiswa_id']) ? $_POST['mahasiswa_id'] : $nilai_data['mahasiswa_id'];
                                while ($mhs = $mahasiswa_result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $mhs['id']; ?>" <?php echo ($selected_mahasiswa == $mhs['id']) ? 'selected' : ''; ?>>
                                        <?php echo $mhs['nim'] . ' - ' . $mhs['nama']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mata_kuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                            <select class="form-select" id="mata_kuliah_id" name="mata_kuliah_id" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                                <?php 
                                $selected_matkul = isset($_POST['mata_kuliah_id']) ? $_POST['mata_kuliah_id'] : $nilai_data['mata_kuliah_id'];
                                while ($mk = $matkul_result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $mk['id']; ?>" <?php echo ($selected_matkul == $mk['id']) ? 'selected' : ''; ?>>
                                        <?php echo $mk['kode_mk'] . ' - ' . $mk['nama_mk']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nilai" name="nilai" value="<?php echo isset($_POST['nilai']) ? $_POST['nilai'] : $nilai_data['nilai']; ?>" min="0" max="100" step="0.01" required>
                            <small class="text-muted">Nilai harus antara 0-100</small>
                        </div>

                        <div class="alert alert-info">
                            <strong>Informasi Grade:</strong>
                            <ul class="mb-0 mt-2">
                                <li>A: 85-100</li>
                                <li>A-: 80-84</li>
                                <li>B+: 75-79</li>
                                <li>B: 70-74</li>
                                <li>B-: 65-69</li>
                                <li>C+: 60-64</li>
                                <li>C: 55-59</li>
                                <li>D: 40-54</li>
                                <li>E: < 40</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-info">
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
