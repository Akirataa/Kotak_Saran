<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = $search ? "WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR isi_saran LIKE '%$search%'" : '';
$total_query = "SELECT COUNT(*) AS total FROM saran $search_query";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$query = "SELECT * FROM saran $search_query ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Query error: " . mysqli_error($conn);
    exit;
}
$total_pages = ceil($total_data / $limit);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
     <link rel="stylesheet" href="../resources/style.css">
    <title>Halaman Admin</title>
</head>
<style>

</style>
<body class="bg-light admin-body">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold admin-h2">Halaman Admin</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>


    <form method="GET" class="mb-4">
        <div class="input-group mb-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau saran" aria-label="Search" <?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>
        
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Isi Saran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['isi_saran']) ?></td>
                    <td>
                        <form action="update_status.php" method="POST">
                            <input type="hidden" name="id_saran" value="<?= htmlspecialchars($row['id']) ?>">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option <?= $row['status'] === 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                <option <?= $row['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option <?= $row['status'] === 'Ditinjau' ? 'selected' : '' ?>>Ditinjau</option>
                                <option <?= $row['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="delete.php" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus saran ini?');">
                            <input type="hidden" name="id_saran" value="<?= htmlspecialchars($row['id']) ?>">
                            <button type="button" class="btn btn-success btn-sm me-2" onclick="editsaran(<?= $row['id'] ?>)"><i class="bi bi-pencil">Ubah</i></button>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-4">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
            </tbody>
        </table>
</div>


<script src="../resources/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
