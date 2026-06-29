<?php
$page_title = "Data Mata Kuliah";
include '../../includes/header.php';

// Handle search
$search = isset($_GET['search']) ? clean($_GET['search']) : '';

// Validasi order dan sort
$order = isset($_GET['order']) ? clean($_GET['order']) : 'kode_mk';
$sort = isset($_GET['sort']) ? clean($_GET['sort']) : 'ASC';

// Validasi kolom yang diperbolehkan
$valid_orders = ['kode_mk', 'nama_mk', 'sks'];
if (!in_array($order, $valid_orders)) {
    $order = 'kode_mk';
}

// Pastikan sort cuma ASC atau DESC
if ($sort != 'ASC' && $sort != 'DESC') {
    $sort = 'ASC';
}

// Query mata kuliah dengan search dan sorting
$sql = "SELECT * FROM mata_kuliah WHERE 
        kode_mk LIKE ? OR 
        nama_mk LIKE ? OR 
        sks LIKE ? 
        ORDER BY $order $sort";

$search_param = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $search_param, $search_param, $search_param);
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
                <h2><i class="bi bi-book-fill"></i> Data Mata Kuliah</h2>
                <p class="text-muted">Kelola data mata kuliah</p>
            </div>

            <?php show_alert(); ?>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="create.php" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Mata Kuliah
                        </a>
                        
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari mata kuliah..." value="<?php echo $search; ?>">
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
                            <thead class="table-success">
                                <tr>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=kode_mk&sort=<?php echo ($order == 'kode_mk' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Kode MK <?php if($order == 'kode_mk') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=nama_mk&sort=<?php echo ($order == 'nama_mk' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            Nama Mata Kuliah <?php if($order == 'nama_mk') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?search=<?php echo $search; ?>&order=sks&sort=<?php echo ($order == 'sks' && $sort == 'ASC') ? 'DESC' : 'ASC'; ?>" class="text-decoration-none text-dark">
                                            SKS <?php if($order == 'sks') echo ($sort == 'ASC') ? '↑' : '↓'; ?>
                                        </a>
                                    </th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['kode_mk']; ?></td>
                                            <td><?php echo $row['nama_mk']; ?></td>
                                            <td><?php echo $row['sks']; ?></td>
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
                                        <td colspan="4" class="text-center">Tidak ada data mata kuliah</td>
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
