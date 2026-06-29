-- ============================================
-- Database: sistem_nilai
-- Deskripsi: Database untuk Sistem Nilai Mahasiswa
-- Dibuat: 2026-06-27
-- ============================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS `sistem_nilai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistem_nilai`;

-- ============================================
-- Table: mahasiswa
-- ============================================
CREATE TABLE `mahasiswa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nim` VARCHAR(20) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `jurusan` VARCHAR(50) NOT NULL,
  `angkatan` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nim` (`nim`),
  KEY `idx_angkatan` (`angkatan`),
  KEY `idx_jurusan` (`jurusan`),
  CONSTRAINT `chk_angkatan` CHECK (`angkatan` >= 2000 AND `angkatan` <= YEAR(CURDATE()) + 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: mata_kuliah
-- ============================================
CREATE TABLE `mata_kuliah` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode_mk` VARCHAR(10) NOT NULL,
  `nama_mk` VARCHAR(100) NOT NULL,
  `sks` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_kode_mk` (`kode_mk`),
  KEY `idx_sks` (`sks`),
  CONSTRAINT `chk_sks` CHECK (`sks` >= 1 AND `sks` <= 6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: nilai
-- ============================================
CREATE TABLE `nilai` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` INT(11) NOT NULL,
  `mata_kuliah_id` INT(11) NOT NULL,
  `nilai` DECIMAL(5,2) NOT NULL,
  `grade` VARCHAR(2) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mahasiswa_matkul` (`mahasiswa_id`, `mata_kuliah_id`),
  KEY `fk_mahasiswa` (`mahasiswa_id`),
  KEY `fk_mata_kuliah` (`mata_kuliah_id`),
  KEY `idx_grade` (`grade`),
  CONSTRAINT `fk_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_mata_kuliah` FOREIGN KEY (`mata_kuliah_id`) REFERENCES `mata_kuliah` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `chk_nilai` CHECK (`nilai` >= 0 AND `nilai` <= 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Sample Data: mahasiswa
-- ============================================
INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `angkatan`) VALUES
('2024001', 'Budi Santoso', 'Teknik Informatika', 2024),
('2024002', 'Siti Aminah', 'Sistem Informasi', 2024),
('2024003', 'Ahmad Rizki', 'Teknik Informatika', 2024),
('2023001', 'Dewi Lestari', 'Sistem Informasi', 2023),
('2023002', 'Raka Pratama', 'Teknik Informatika', 2023),
('2023003', 'Rina Wulandari', 'Teknik Informatika', 2023),
('2024004', 'Andi Wijaya', 'Sistem Informasi', 2024),
('2024005', 'Fitri Handayani', 'Teknik Informatika', 2024);

-- ============================================
-- Sample Data: mata_kuliah
-- ============================================
INSERT INTO `mata_kuliah` (`kode_mk`, `nama_mk`, `sks`) VALUES
('TI101', 'Pemrograman Dasar', 3),
('TI102', 'Basis Data', 3),
('TI103', 'Struktur Data', 3),
('TI104', 'Algoritma dan Pemrograman', 4),
('SI101', 'Sistem Informasi Manajemen', 3),
('SI102', 'Analisis dan Perancangan Sistem', 3),
('MK101', 'Matematika Diskrit', 3),
('MK102', 'Kalkulus', 3);

-- ============================================
-- Sample Data: nilai
-- ============================================
INSERT INTO `nilai` (`mahasiswa_id`, `mata_kuliah_id`, `nilai`, `grade`) VALUES
(1, 1, 88.50, 'A'),
(1, 2, 92.00, 'A'),
(1, 3, 85.00, 'A'),
(2, 1, 78.00, 'B+'),
(2, 5, 85.50, 'A'),
(2, 2, 80.00, 'A-'),
(3, 1, 72.00, 'B'),
(3, 2, 68.00, 'B-'),
(3, 4, 75.00, 'B+'),
(4, 2, 95.00, 'A'),
(4, 5, 82.00, 'A-'),
(4, 6, 88.00, 'A'),
(5, 1, 65.00, 'B-'),
(5, 3, 58.00, 'C'),
(5, 7, 70.00, 'B'),
(6, 1, 90.00, 'A'),
(6, 2, 87.00, 'A'),
(7, 5, 76.00, 'B+'),
(7, 6, 81.00, 'A-'),
(8, 1, 62.00, 'C+'),
(8, 3, 55.00, 'C');

-- ============================================
-- End of SQL Script
-- ============================================
