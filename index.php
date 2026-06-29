<?php
$page_title = "Dashboard";
include 'includes/header.php';

// Query untuk statistik
$total_mahasiswa_query = $conn->query("SELECT COUNT(*) as total FROM mahasiswa");
$total_mahasiswa = $total_mahasiswa_query->fetch_assoc()['total'];

$total_matkul_query = $conn->query("SELECT COUNT(*) as total FROM mata_kuliah");
$total_matkul = $total_matkul_query->fetch_assoc()['total'];

$total_nilai_query = $conn->query("SELECT COUNT(*) as total FROM nilai");
$total_nilai = $total_nilai_query->fetch_assoc()['total'];

$rata_rata_query = $conn->query("SELECT AVG(nilai) as rata FROM nilai");
$rata_rata_row = $rata_rata_query->fetch_assoc();
$rata_rata = $rata_rata_row['rata'] ? number_format($rata_rata_row['rata'], 2) : 0;
?>

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        
        <main class="col-md-10 content" id="main-content" role="main">
            <header class="content-header">
                <h1><i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard</h1>
                <p class="text-muted">Selamat datang di Sistem Nilai Mahasiswa</p>
            </header>

            <?php show_alert(); ?>

            <!-- Statistik Cards -->
            <section aria-labelledby="statistics-heading">
                <h2 id="statistics-heading" class="visually-hidden">Statistik Data</h2>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <article class="card stat-card stat-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="h6 text-muted mb-2">Total Mahasiswa</h3>
                                        <p class="mb-0 h2" role="status" aria-live="polite"><?php echo $total_mahasiswa; ?></p>
                                    </div>
                                    <div class="stat-icon" aria-hidden="true">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <article class="card stat-card stat-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="h6 text-muted mb-2">Total Mata Kuliah</h3>
                                        <p class="mb-0 h2" role="status" aria-live="polite"><?php echo $total_matkul; ?></p>
                                    </div>
                                    <div class="stat-icon" aria-hidden="true">
                                        <i class="bi bi-book-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <article class="card stat-card stat-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="h6 text-muted mb-2">Total Data Nilai</h3>
                                        <p class="mb-0 h2" role="status" aria-live="polite"><?php echo $total_nilai; ?></p>
                                    </div>
                                    <div class="stat-icon" aria-hidden="true">
                                        <i class="bi bi-clipboard-data-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <article class="card stat-card stat-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="h6 text-muted mb-2">Rata-rata Nilai</h3>
                                        <p class="mb-0 h2" role="status" aria-live="polite"><?php echo $rata_rata; ?></p>
                                    </div>
                                    <div class="stat-icon" aria-hidden="true">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Quick Access -->
            <section aria-labelledby="quick-access-heading">
                <h2 id="quick-access-heading" class="visually-hidden">Quick Access</h2>
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-people-fill text-primary" style="font-size: 3rem;" aria-hidden="true"></i>
                                <h3 class="h5 mt-3">Data Mahasiswa</h3>
                                <p class="text-muted">Kelola data mahasiswa</p>
                                <a href="<?php echo base_url('modules/mahasiswa/index.php'); ?>" 
                                   class="btn btn-primary"
                                   aria-label="Kelola Data Mahasiswa">
                                    <i class="bi bi-arrow-right-circle" aria-hidden="true"></i> Kelola
                                </a>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-book-fill text-success" style="font-size: 3rem;" aria-hidden="true"></i>
                                <h3 class="h5 mt-3">Data Mata Kuliah</h3>
                                <p class="text-muted">Kelola data mata kuliah</p>
                                <a href="<?php echo base_url('modules/mata-kuliah/index.php'); ?>" 
                                   class="btn btn-success"
                                   aria-label="Kelola Data Mata Kuliah">
                                    <i class="bi bi-arrow-right-circle" aria-hidden="true"></i> Kelola
                                </a>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-clipboard-data-fill text-info" style="font-size: 3rem;" aria-hidden="true"></i>
                                <h3 class="h5 mt-3">Data Nilai</h3>
                                <p class="text-muted">Kelola data nilai mahasiswa</p>
                                <a href="<?php echo base_url('modules/nilai/index.php'); ?>" 
                                   class="btn btn-info"
                                   aria-label="Kelola Data Nilai">
                                    <i class="bi bi-arrow-right-circle" aria-hidden="true"></i> Kelola
                                </a>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
