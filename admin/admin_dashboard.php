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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <title>Halaman Admin</title>
</head>
<style>
  body {
    background-color: #f8f9fa;
}

.card {
    border-radius: 15px;
    border: none;
}

.table {
    margin-top: 20px;
}

.table thead {
    font-weight: bold;
}

.table th, .table td {
    padding: 12px;
    vertical-align: middle;
}

.btn-sm i {
    margin-right: 4px;
}

</style>
<body>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center">Halaman Admin</h2>
        
<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
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
                            <button type="button" class="btn btn-success btn-sm" onclick="editsaran(<?= $row['id'] ?>)"><i class="bi bi-pencil">Ubah</i></button>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
        <a href="logout.php" class="btn btn-outline-secondary float-end mt-3">Logout</a>
  </div>
</div>


<script>
    function updateDropdownColor(selectElement) {
        switch (selectElement.value) {
            case 'Dikirim':
                selectElement.style.backgroundColor = '#e9ecef';
                selectElement.style.color = '#6c757d';
                break;
            case 'Diproses':
                selectElement.style.backgroundColor = '#fff3cd';
                selectElement.style.color = '#856404';
                break;
            case 'Ditinjau':
                selectElement.style.backgroundColor = '#cce5ff';
                selectElement.style.color = '#004085';
                break;
            case 'Selesai':
                selectElement.style.backgroundColor = '#d4edda';
                selectElement.style.color = '#155724';
                break;
            default:
                selectElement.style.backgroundColor = '';
                selectElement.style.color = '';
        }
        selectElement.style.transition = 'background-color 0.3s ease, color 0.3s ease';
    }
    document.querySelectorAll('.form-select').forEach(select => {
        updateDropdownColor(select);
        select.addEventListener('change', function() {
            updateDropdownColor(this);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
