<nav class="navbar navbar-expand-lg navbar-dark bg-primary" role="navigation" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url('index.php'); ?>" aria-label="Sistem Nilai Mahasiswa - Home">
            <i class="bi bi-mortarboard-fill" aria-hidden="true"></i> 
            <span>Sistem Nilai Mahasiswa</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['page'])) ? 'active' : ''; ?>" 
                       href="<?php echo base_url('index.php'); ?>"
                       aria-label="Dashboard"
                       <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['page'])) ? 'aria-current="page"' : ''; ?>>
                        <i class="bi bi-speedometer2" aria-hidden="true"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-white-50" aria-label="Logged in as Admin">
                        <i class="bi bi-person-circle" aria-hidden="true"></i> 
                        <span>Admin</span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</nav>
