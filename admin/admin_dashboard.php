<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM saran"; 
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Query error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../resource/style.css">
    <title>Halaman Admin</title>
</head>
<body>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Halaman Admin</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-primary">
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
                            <select name="status" class="form-select">
                                <option <?= $row['status'] === 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                <option <?= $row['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option <?= $row['status'] === 'Ditinjau' ? 'selected' : '' ?>>Ditinjau</option>
                                <option <?= $row['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="delete.php" method="POST">
                            <input type="hidden" name="id_saran" value="<?= htmlspecialchars($row['id']) ?>">
                            <button type="submit" class="btn btn-sm btn-success">Ubah</button>
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
