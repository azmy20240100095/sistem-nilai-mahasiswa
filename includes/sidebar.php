<aside class="sidebar" role="complementary" aria-label="Sidebar navigation">
    <div class="sidebar-header">
        <h5><i class="bi bi-menu-button-wide" aria-hidden="true"></i> Menu</h5>
    </div>
    <nav aria-label="Main menu">
        <ul class="sidebar-menu" role="menubar">
            <li role="none" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && !strpos($_SERVER['REQUEST_URI'], 'modules')) ? 'active' : ''; ?>">
                <a href="<?php echo base_url('index.php'); ?>" 
                   role="menuitem"
                   aria-label="Dashboard - Lihat statistik"
                   <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && !strpos($_SERVER['REQUEST_URI'], 'modules')) ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-speedometer2" aria-hidden="true"></i> 
                    <span>Dashboard</span>
                </a>
            </li>
            <li role="none" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'mahasiswa') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo base_url('modules/mahasiswa/index.php'); ?>" 
                   role="menuitem"
                   aria-label="Data Mahasiswa - Kelola data mahasiswa"
                   <?php echo (strpos($_SERVER['REQUEST_URI'], 'mahasiswa') !== false) ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-people-fill" aria-hidden="true"></i> 
                    <span>Data Mahasiswa</span>
                </a>
            </li>
            <li role="none" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'mata-kuliah') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo base_url('modules/mata-kuliah/index.php'); ?>" 
                   role="menuitem"
                   aria-label="Data Mata Kuliah - Kelola mata kuliah"
                   <?php echo (strpos($_SERVER['REQUEST_URI'], 'mata-kuliah') !== false) ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-book-fill" aria-hidden="true"></i> 
                    <span>Data Mata Kuliah</span>
                </a>
            </li>
            <li role="none" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'nilai') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo base_url('modules/nilai/index.php'); ?>" 
                   role="menuitem"
                   aria-label="Data Nilai - Kelola nilai mahasiswa"
                   <?php echo (strpos($_SERVER['REQUEST_URI'], 'nilai') !== false) ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-clipboard-data-fill" aria-hidden="true"></i> 
                    <span>Data Nilai</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
