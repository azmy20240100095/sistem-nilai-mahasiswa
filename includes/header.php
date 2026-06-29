<?php
// Konfigurasi session untuk keamanan
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

session_start();

// Bikin CSRF token kalau belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/helper.php';
require_once __DIR__ . '/../helpers/validation.php';

// SEO: Generate proper meta description based on page
$meta_description = isset($page_title) 
    ? "Sistem Nilai Mahasiswa - $page_title. Aplikasi manajemen data mahasiswa, mata kuliah, dan nilai berbasis web."
    : "Sistem Nilai Mahasiswa - Aplikasi manajemen data mahasiswa, mata kuliah, dan nilai secara digital. Efisien, aman, dan mudah digunakan.";

$meta_keywords = "sistem nilai, mahasiswa, manajemen nilai, aplikasi nilai, CRUD mahasiswa, basis data, academic system";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Essential Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    <meta name="author" content="Sistem Nilai Mahasiswa">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Sistem Nilai Mahasiswa">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Sistem Nilai Mahasiswa">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    
    <!-- Theme Color for Mobile Browsers -->
    <meta name="theme-color" content="#6366f1">
    <meta name="msapplication-TileColor" content="#6366f1">
    
    <!-- Page Title -->
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - ' : ''; ?>Sistem Nilai Mahasiswa</title>
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    
    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-to-content">Skip to main content</a>
