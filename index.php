<?php
include 'db.php';

$query = "SELECT * FROM saran ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Query error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>I-TECH</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="resources/itech.png" alt="I-TECH Logo" width="120%" height="50" class="d-inline-block align-text-top">
        </a>
        <a href="admin/login.php"> <button type="button" class="btn btn-primary rounded-pill">Login as Admin</button> </a>
    </div>
</nav>

<div class="container mt-5">

    <!-- Kotak Saran -->
    <div class="card shadow-lg p-4 mb-5">
        <h1 class="text-center text-primary mb-4">Kotak Saran</h1>
        <form id="suggestionForm">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>
            <div class="mb-4">
                <label for="isi_saran" class="form-label">Saran:</label>
                <textarea id="isi_saran" name="isi_saran" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill">Kirim Saran</button>
        </form>
    </div>

    <!-- Saran Terbaru -->
    <div class="card shadow-lg p-4">
        <h2 class="text-center text-dark mb-4">Saran Terbaru</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Nama</th>
                    <th>Saran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['isi_saran']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="resources/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
