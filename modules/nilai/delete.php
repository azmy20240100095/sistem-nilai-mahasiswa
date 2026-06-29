<?php
session_start();
require_once '../../config/database.php';
require_once '../../helpers/helper.php';

// Get ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Hapus data
    $stmt = $conn->prepare("DELETE FROM nilai WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Data nilai berhasil dihapus!');
    } else {
        set_alert('danger', 'Gagal menghapus data nilai!');
    }
} else {
    set_alert('danger', 'ID nilai tidak valid!');
}

redirect('index.php');
?>
