<?php
session_start();
require_once '../../config/database.php';
require_once '../../helpers/helper.php';
require_once '../../helpers/validation.php';

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Cek apakah mata kuliah memiliki data nilai
    if (check_matkul_has_nilai($conn, $id)) {
        set_alert('danger', 'Tidak dapat menghapus mata kuliah karena masih memiliki data nilai!');
        redirect('index.php');
    }
    
    // Hapus data
    $stmt = $conn->prepare("DELETE FROM mata_kuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Data mata kuliah berhasil dihapus!');
    } else {
        set_alert('danger', 'Gagal menghapus data mata kuliah!');
    }
} else {
    set_alert('danger', 'ID mata kuliah tidak valid!');
}

redirect('index.php');
?>
