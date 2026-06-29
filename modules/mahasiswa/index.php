<?php
$page_title = "Data Mahasiswa";
include '../../includes/header.php';

// Handle search
$search = isset($_GET['search']) ? clean($_GET['search']) : '';

// Validasi order dan sort untuk keamanan
$order = isset($_GET['order']) ? clean($_GET['order']) : 'nim';
$sort = isset($_GET['sort']) ? clean($_GET['sort']) : 'ASC';

// Cek order harus valid
$valid_orders = ['nim', 'nama', 'jurusan', 'angkatan'];
if (!in_array($order, $valid_orders)) {
    $order = 'nim';
}

// Cek sort harus ASC atau DESC
if ($sort != 'ASC' && $sort != 'DESC') {
    $sort = 'ASC';
}

// Query mahasiswa dengan search dan sorting
$sql = "SELECT * FROM mahasiswa WHERE 
        nim LIKE ? OR 
        nama LIKE ? OR 
        jurusan LIKE ? OR 
        angkatan LIKE ? 
        ORDER BY $order $sort";

$search_param = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
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
                <h2><i class="bi bi-people-fill"></i> Data Mahasiswa</h2>
                <p class="text-muted">Kelola data mahasiswa</p>
            </div>

            <?php show_alert(); ?>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="create.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
                        </a>
                        
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari mahasiswa..." value="<?php echo $search; ?>">
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
                            <thead class="table-primary">
                                <tr>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=nim&sort=<?php echo ($order == 'nim' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            NIM <?php if($order == 'nim') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=nama&sort=<?php echo ($order == 'nama' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Nama <?php if($order == 'nama') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=jurusan&sort=<?php echo ($order == 'jurusan' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Jurusan <?php if($order == 'jurusan') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=angkatan&sort=<?php echo ($order == 'angkatan' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Angkatan <?php if($order == 'angkatan') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
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
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['jurusan']; ?></td>
                                            <td><?php echo $row['angkatan']; ?></td>
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
                                        <td colspan="5" class="text-center">Tidak ada data mahasiswa</td>
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
