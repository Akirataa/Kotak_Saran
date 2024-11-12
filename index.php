<?php
include 'db.php';

// Query untuk mengambil 5 saran terbaru
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="resource/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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

    <!-- Lihat Status Saran -->
    <div class="card shadow-lg p-4 mb-5">
        <h2 class="text-center text-secondary mb-4">Lihat Status Saran</h2>
        <form id="statusForm">
            <div class="mb-3">
                <label for="id_saran" class="form-label">ID Saran:</label>
                <input type="number" id="id_saran" name="id_saran" class="form-control" required />
            </div>
            <button type="button" id="checkStatus" class="btn btn-secondary w-100 rounded-pill">Lihat Status Saran</button>
        </form>
    </div>

    <!-- Tabel 5 Saran Terbaru -->
    <div class="card shadow-lg p-4">
        <h2 class="text-center text-dark mb-4">Saran Terbaru</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Saran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['isi_saran']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script>
    // Formulir pengiriman saran
    document.getElementById('suggestionForm').onsubmit = function(event) {
        event.preventDefault(); 

        const formData = new FormData(this);

        fetch('submit_saran.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            Swal.fire({
                title: 'Saran Dikirim',
                text: data,
                icon: 'success',
                confirmButtonText: 'OK'
            });
            this.reset();
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengirim saran.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    };

    // Cek status saran
    document.getElementById('checkStatus').onclick = function() {
        const id_saran = document.getElementById('id_saran').value;

        if (id_saran) {
            fetch(`lihat_status.php?id_saran=${id_saran}`)
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: data.type === 'success' ? 'Status Saran' : 'Kesalahan',
                        text: data.message,
                        icon: data.type === 'success' ? 'info' : 'error',
                        confirmButtonText: 'OK'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengambil status.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        } else {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Silakan masukkan ID saran.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    };
</script>
</body>
</html>
