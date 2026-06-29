<?php
/**
 * Helper Functions
 * File: helpers/helper.php
 * Fungsi-fungsi bantuan untuk aplikasi
 */

/**
 * Redirect ke URL tertentu
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Bersihkan input dari XSS
 */
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Set alert message
 */
function set_alert($type, $message) {
    $_SESSION['alert_type'] = $type;
    $_SESSION['alert_message'] = $message;
}

/**
 * Tampilkan alert
 */
function show_alert() {
    if (isset($_SESSION['alert_message'])) {
        $type = $_SESSION['alert_type'];
        $message = $_SESSION['alert_message'];
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
        echo $message;
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
        unset($_SESSION['alert_type']);
        unset($_SESSION['alert_message']);
    }
}

/**
 * Hitung grade berdasarkan nilai
 */
function calculate_grade($nilai) {
    if ($nilai >= 85) return 'A';
    if ($nilai >= 80) return 'A-';
    if ($nilai >= 75) return 'B+';
    if ($nilai >= 70) return 'B';
    if ($nilai >= 65) return 'B-';
    if ($nilai >= 60) return 'C+';
    if ($nilai >= 55) return 'C';
    if ($nilai >= 40) return 'D';
    return 'E';
}

/**
 * Format tanggal Indonesia
 */
function format_tanggal($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $tanggal = date('j', $timestamp);
    $bulan_num = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    
    return $tanggal . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
}

/**
 * Base URL aplikasi
 */
function base_url($path = '') {
    // Protocol
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https" : "http";
    
    // Host
    $host = $_SERVER['HTTP_HOST'];
    
    // Get directory path
    $script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    
    // Kalau file di dalam modules, naik 2 level
    if (strpos($script_name, '/modules/') !== false) {
        $parts = explode('/modules/', $script_name);
        $base_path = $parts[0];
    } else {
        $base_path = $script_name;
    }
    
    // Bersihin
    $base_path = rtrim($base_path, '/');
    
    // Build URL
    $base_url = $protocol . "://" . $host . $base_path;
    
    // Tambahin path kalau ada
    if (!empty($path)) {
        $path = ltrim($path, '/');
        return $base_url . '/' . $path;
    }
    
    return $base_url;
}
?>
