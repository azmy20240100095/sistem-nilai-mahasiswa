<?php
session_start();
require_once '../../config/database.php';
require_once '../../helpers/helper.php';
require_once '../../helpers/validation.php';

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Cek apakah mahasiswa memiliki data nilai
    if (check_mahasiswa_has_nilai($conn, $id)) {
        set_alert('danger', 'Tidak dapat menghapus mahasiswa karena masih memiliki data nilai!');
        redirect('index.php');
    }
    
    // Hapus data
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Data mahasiswa berhasil dihapus!');
    } else {
        set_alert('danger', 'Gagal menghapus data mahasiswa!');
    }
} else {
    set_alert('danger', 'ID mahasiswa tidak valid!');
}

redirect('index.php');
?>
