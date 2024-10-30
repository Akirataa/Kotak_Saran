<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
echo "Selamat datang di halaman admin!";

// Mendapatkan data dari database
$query = "SELECT * FROM saran"; // Ganti 'saran' dengan nama tabel yang benar jika berbeda
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Query error: " . mysqli_error($conn);
    exit;
}
?>

<h1>Halaman Admin</h1>
<a href="logout.php">Logout</a>
<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Isi Saran</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['isi_saran']) ?></td>
            <td>
                <form action="update_status.php" method="POST">
                    <input type="hidden" name="id_saran" value="<?= htmlspecialchars($row['id']) ?>">
                    <select name="status">
                        <option <?= $row['status'] === 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                        <option <?= $row['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option <?= $row['status'] === 'Ditinjau' ? 'selected' : '' ?>>Ditinjau</option>
                        <option <?= $row['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                    <button type="submit">Ubah</button>
                </form>
            </td>
            <td>
                <form action="delete.php" method="POST">
                    <input type="hidden" name="id_saran" value="<?= htmlspecialchars($row['id']) ?>">
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
