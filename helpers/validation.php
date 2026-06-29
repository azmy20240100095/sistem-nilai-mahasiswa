<?php
/**
 * Validation Functions
 * File: helpers/validation.php
 * Fungsi-fungsi validasi input
 */

/**
 * Cek field tidak boleh kosong
 */
function validate_required($data, $field_name) {
    if (empty(trim($data))) {
        return "$field_name tidak boleh kosong";
    }
    return true;
}

/**
 * Cek harus angka
 */
function validate_numeric($data, $field_name) {
    if (!is_numeric($data)) {
        return "$field_name harus berupa angka";
    }
    return true;
}

/**
 * Validasi range angka
 */
function validate_range($data, $min, $max, $field_name) {
    if ($data < $min || $data > $max) {
        return "$field_name harus antara $min sampai $max";
    }
    return true;
}

/**
 * Validasi minimal karakter
 */
function validate_min_length($data, $min, $field_name) {
    if (strlen($data) < $min) {
        return "$field_name minimal $min karakter";
    }
    return true;
}

/**
 * Validasi maksimal karakter
 */
function validate_max_length($data, $max, $field_name) {
    if (strlen($data) > $max) {
        return "$field_name maksimal $max karakter";
    }
    return true;
}

/**
 * Cek NIM unique
 */
function validate_nim_unique($conn, $nim, $exclude_id = null) {
    $sql = "SELECT id FROM mahasiswa WHERE nim = ?";
    if ($exclude_id) {
        $sql .= " AND id != ?";
    }
    
    $stmt = $conn->prepare($sql);
    if ($exclude_id) {
        $stmt->bind_param("si", $nim, $exclude_id);
    } else {
        $stmt->bind_param("s", $nim);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return "NIM sudah terdaftar";
    }
    return true;
}

/**
 * Cek Kode MK unique
 */
function validate_kode_mk_unique($conn, $kode_mk, $exclude_id = null) {
    $sql = "SELECT id FROM mata_kuliah WHERE kode_mk = ?";
    if ($exclude_id) {
        $sql .= " AND id != ?";
    }
    
    $stmt = $conn->prepare($sql);
    if ($exclude_id) {
        $stmt->bind_param("si", $kode_mk, $exclude_id);
    } else {
        $stmt->bind_param("s", $kode_mk);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return "Kode Mata Kuliah sudah terdaftar";
    }
    return true;
}

/**
 * Validasi nilai mahasiswa tidak duplikat
 */
function validate_nilai_unique($conn, $mahasiswa_id, $mata_kuliah_id, $exclude_id = null) {
    $sql = "SELECT id FROM nilai WHERE mahasiswa_id = ? AND mata_kuliah_id = ?";
    if ($exclude_id) {
        $sql .= " AND id != ?";
    }
    
    $stmt = $conn->prepare($sql);
    if ($exclude_id) {
        $stmt->bind_param("iii", $mahasiswa_id, $mata_kuliah_id, $exclude_id);
    } else {
        $stmt->bind_param("ii", $mahasiswa_id, $mata_kuliah_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return "Mahasiswa sudah memiliki nilai untuk mata kuliah ini";
    }
    return true;
}

/**
 * Cek apakah mahasiswa punya nilai atau belum
 */
function check_mahasiswa_has_nilai($conn, $mahasiswa_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM nilai WHERE mahasiswa_id = ?");
    $stmt->bind_param("i", $mahasiswa_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] > 0;
}

/**
 * Cek apakah mata kuliah punya nilai atau belum
 */
function check_matkul_has_nilai($conn, $mata_kuliah_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM nilai WHERE mata_kuliah_id = ?");
    $stmt->bind_param("i", $mata_kuliah_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] > 0;
}

/**
 * Validasi CSRF token untuk keamanan
 */
function validate_csrf_token($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Bandingkan token
    if ($token !== $_SESSION['csrf_token']) {
        return false;
    }
    
    return true;
}

/**
 * Generate input field untuk CSRF token
 */
function csrf_field() {
    $token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}
?>
