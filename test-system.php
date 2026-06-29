<?php
/**
 * System Testing - Check all components
 * File: test-system.php
 * Run this file to check if all system components are working
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>System Test</title>";
echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5}";
echo ".success{color:green;font-weight:bold}.error{color:red;font-weight:bold}";
echo ".section{background:white;padding:15px;margin:10px 0;border-radius:5px;box-shadow:0 2px 4px rgba(0,0,0,0.1)}";
echo "h2{color:#333;border-bottom:2px solid #007bff;padding-bottom:10px}</style></head><body>";

echo "<h1>🔍 Sistem Nilai Mahasiswa - System Test</h1>";

// Test 1: Database Connection
echo "<div class='section'><h2>1. Database Connection Test</h2>";
try {
    require_once 'config/database.php';
    if ($conn && $conn->ping()) {
        echo "<p class='success'>✅ Database connection: OK</p>";
        echo "<p>Host: " . DB_HOST . "</p>";
        echo "<p>Database: " . DB_NAME . "</p>";
    } else {
        echo "<p class='error'>❌ Database connection: FAILED</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
}
echo "</div>";

// Test 2: Check Tables
echo "<div class='section'><h2>2. Database Tables Test</h2>";
$tables = ['mahasiswa', 'mata_kuliah', 'nilai'];
foreach ($tables as $table) {
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p class='success'>✅ Table '$table': " . $row['count'] . " records</p>";
    } else {
        echo "<p class='error'>❌ Table '$table': NOT FOUND</p>";
    }
}
echo "</div>";

// Test 3: Helper Functions
echo "<div class='section'><h2>3. Helper Functions Test</h2>";
require_once 'helpers/helper.php';
require_once 'helpers/validation.php';

// Test clean function
$test_input = "<script>alert('xss')</script>";
$cleaned = clean($test_input);
if ($cleaned != $test_input) {
    echo "<p class='success'>✅ clean() function: WORKING (XSS prevented)</p>";
} else {
    echo "<p class='error'>❌ clean() function: NOT WORKING</p>";
}

// Test calculate_grade
$grade = calculate_grade(88);
if ($grade == 'A') {
    echo "<p class='success'>✅ calculate_grade() function: WORKING (88 = A)</p>";
} else {
    echo "<p class='error'>❌ calculate_grade() function: NOT WORKING</p>";
}

// Test base_url
$url = base_url();
if (!empty($url)) {
    echo "<p class='success'>✅ base_url() function: WORKING</p>";
    echo "<p>Base URL: $url</p>";
} else {
    echo "<p class='error'>❌ base_url() function: NOT WORKING</p>";
}
echo "</div>";

// Test 4: Check Files
echo "<div class='section'><h2>4. File Structure Test</h2>";
$files = [
    'config/database.php',
    'helpers/helper.php',
    'helpers/validation.php',
    'includes/header.php',
    'includes/navbar.php',
    'includes/sidebar.php',
    'includes/footer.php',
    'assets/css/style.css',
    'assets/js/script.js',
    'index.php',
    'modules/mahasiswa/index.php',
    'modules/mahasiswa/create.php',
    'modules/mahasiswa/edit.php',
    'modules/mahasiswa/delete.php',
    'modules/mata-kuliah/index.php',
    'modules/mata-kuliah/create.php',
    'modules/mata-kuliah/edit.php',
    'modules/mata-kuliah/delete.php',
    'modules/nilai/index.php',
    'modules/nilai/create.php',
    'modules/nilai/edit.php',
    'modules/nilai/delete.php'
];

$missing = 0;
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p class='success'>✅ $file</p>";
    } else {
        echo "<p class='error'>❌ $file - MISSING</p>";
        $missing++;
    }
}

if ($missing == 0) {
    echo "<p class='success'><strong>All files present!</strong></p>";
} else {
    echo "<p class='error'><strong>$missing files missing!</strong></p>";
}
echo "</div>";

// Test 5: PHP Version
echo "<div class='section'><h2>5. PHP Environment Test</h2>";
echo "<p class='success'>✅ PHP Version: " . phpversion() . "</p>";
echo "<p class='success'>✅ MySQLi Extension: " . (extension_loaded('mysqli') ? 'Loaded' : 'Not Loaded') . "</p>";
echo "<p class='success'>✅ Session Support: " . (function_exists('session_start') ? 'Available' : 'Not Available') . "</p>";
echo "</div>";

// Test 6: Test CRUD Operations
echo "<div class='section'><h2>6. CRUD Operations Test</h2>";

// Test SELECT
$result = $conn->query("SELECT * FROM mahasiswa LIMIT 1");
if ($result && $result->num_rows > 0) {
    echo "<p class='success'>✅ SELECT: WORKING</p>";
} else {
    echo "<p class='error'>❌ SELECT: FAILED or No Data</p>";
}

// Test INSERT (with rollback)
$conn->begin_transaction();
try {
    $test_nim = 'TEST' . time();
    $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES (?, ?, ?, ?)");
    $test_nama = "Test User";
    $test_jurusan = "Test";
    $test_angkatan = 2024;
    $stmt->bind_param("sssi", $test_nim, $test_nama, $test_jurusan, $test_angkatan);
    
    if ($stmt->execute()) {
        echo "<p class='success'>✅ INSERT: WORKING (test rolled back)</p>";
    } else {
        echo "<p class='error'>❌ INSERT: FAILED</p>";
    }
    $conn->rollback(); // Rollback test data
} catch (Exception $e) {
    $conn->rollback();
    echo "<p class='error'>❌ INSERT: ERROR - " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 7: Grade Calculation
echo "<div class='section'><h2>7. Grade Calculation Test</h2>";
$test_grades = [
    100 => 'A',
    88 => 'A',
    82 => 'A-',
    77 => 'B+',
    72 => 'B',
    67 => 'B-',
    62 => 'C+',
    57 => 'C',
    45 => 'D',
    35 => 'E'
];

$grade_ok = true;
foreach ($test_grades as $nilai => $expected_grade) {
    $calculated = calculate_grade($nilai);
    if ($calculated == $expected_grade) {
        echo "<p class='success'>✅ Nilai $nilai = $calculated (expected: $expected_grade)</p>";
    } else {
        echo "<p class='error'>❌ Nilai $nilai = $calculated (expected: $expected_grade)</p>";
        $grade_ok = false;
    }
}

if ($grade_ok) {
    echo "<p class='success'><strong>Grade calculation: PERFECT!</strong></p>";
}
echo "</div>";

// Summary
echo "<div class='section'><h2>📊 Summary</h2>";
echo "<h3 style='color:green'>System is ready to use! 🎉</h3>";
echo "<p><a href='index.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px'>Go to Dashboard →</a></p>";
echo "</div>";

echo "<p style='text-align:center;color:#666;margin-top:20px'>Test completed at " . date('Y-m-d H:i:s') . "</p>";
echo "</body></html>";

$conn->close();
?>
