<?php
$page_title = "Data Nilai";
include '../../includes/header.php';

// Handle search
$search = isset($_GET['search']) ? clean($_GET['search']) : '';

// Validasi order dan sort
$order = isset($_GET['order']) ? clean($_GET['order']) : 'mahasiswa.nim';
$sort = isset($_GET['sort']) ? clean($_GET['sort']) : 'ASC';

// Daftar kolom yang boleh di-sort
$valid_orders = ['mahasiswa.nim', 'mahasiswa.nama', 'mata_kuliah.kode_mk', 'mata_kuliah.nama_mk', 'nilai.nilai', 'nilai.grade'];
if (!in_array($order, $valid_orders)) {
    $order = 'mahasiswa.nim';
}

// Sort cuma bisa ASC atau DESC
if ($sort != 'ASC' && $sort != 'DESC') {
    $sort = 'ASC';
}

// Query nilai dengan join
$sql = "SELECT nilai.*, mahasiswa.nim, mahasiswa.nama as nama_mahasiswa, 
        mata_kuliah.kode_mk, mata_kuliah.nama_mk 
        FROM nilai 
        JOIN mahasiswa ON nilai.mahasiswa_id = mahasiswa.id 
        JOIN mata_kuliah ON nilai.mata_kuliah_id = mata_kuliah.id 
        WHERE mahasiswa.nim LIKE ? OR 
              mahasiswa.nama LIKE ? OR 
              mata_kuliah.kode_mk LIKE ? OR 
              mata_kuliah.nama_mk LIKE ? OR
              nilai.grade LIKE ?
        ORDER BY $order $sort";

$search_param = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include '../../includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>
        
        <div class="col-md-10 content">
            <div class="content-header">
                <h2><i class="bi bi-clipboard-data-fill"></i> Data Nilai</h2>
                <p class="text-muted">Kelola data nilai mahasiswa</p>
            </div>

            <?php show_alert(); ?>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="create.php" class="btn btn-info">
                            <i class="bi bi-plus-circle"></i> Tambah Nilai
                        </a>
                        
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari data nilai..." value="<?php echo $search; ?>">
                            <button type="submit" class="btn btn-secondary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            <?php if ($search): ?>
                                <a href="index.php" class="btn btn-outline-secondary">Reset</a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-info">
                                <tr>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=mahasiswa.nim&sort=<?php echo ($order == 'mahasiswa.nim' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            NIM <?php if($order == 'mahasiswa.nim') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=mahasiswa.nama&sort=<?php echo ($order == 'mahasiswa.nama' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Nama Mahasiswa <?php if($order == 'mahasiswa.nama') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=mata_kuliah.kode_mk&sort=<?php echo ($order == 'mata_kuliah.kode_mk' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Kode MK <?php if($order == 'mata_kuliah.kode_mk') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>Nama Mata Kuliah</th>
                                    <th class="text-center">
                                        <a href="?search=<?php echo $search; ?>&order=nilai.nilai&sort=<?php echo ($order == 'nilai.nilai' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Nilai <?php if($order == 'nilai.nilai') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th class="text-center">
                                        <a href="?search=<?php echo $search; ?>&order=nilai.grade&sort=<?php echo ($order == 'nilai.grade' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Grade <?php if($order == 'nilai.grade') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['nim']; ?></td>
                                            <td><?php echo $row['nama_mahasiswa']; ?></td>
                                            <td><?php echo $row['kode_mk']; ?></td>
                                            <td><?php echo $row['nama_mk']; ?></td>
                                            <td class="text-center"><?php echo number_format($row['nilai'], 2); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-primary"><?php echo $row['grade']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data nilai</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
