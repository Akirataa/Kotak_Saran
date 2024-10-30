<?php
include 'db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($conn, $_POST['nama']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $isi_saran = isset($_POST['isi_saran']) ? mysqli_real_escape_string($conn, $_POST['isi_saran']) : '';

    if (!empty($isi_saran)) {
        $query = "INSERT INTO saran (nama, email, isi_saran, status, tanggal_kirim) VALUES ('$nama', '$email', '$isi_saran', 'Dikirim', NOW())";

        if (mysqli_query($conn, $query)) {
            $message = "Saran berhasil dikirim. ID saran Anda adalah " . mysqli_insert_id($conn);
            $message_type = "success";
        } else {
            $message = "Gagal mengirim saran: " . mysqli_error($conn);
            $message_type = "error";
        }
    } else {
        $message = "Isi saran tidak boleh kosong!";
        $message_type = "error";
    }

    // Redirect setelah submit untuk mencegah pengiriman ulang data saat refresh
    header("Location: index.php?message=" . urlencode($message) . "&type=" . urlencode($message_type));
    exit();
}

// Mendapatkan pesan dari parameter URL jika ada
if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = urldecode($_GET['message']);
    $message_type = urldecode($_GET['type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>I-TECH</title>
</head>
<body>
    <nav>
        <a href="admin/login.php">Login</a>
    </nav>
    <h1>Kotak Saran</h1>

    <?php if ($message) : ?>
        <script>
            alert("<?php echo htmlspecialchars($message); ?>");
            if (history.replaceState) {
                history.replaceState(null, null, window.location.pathname);
            }
        </script>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <label for="isi_saran">Saran:</label>
        <textarea id="isi_saran" name="isi_saran" required></textarea>

        <button type="submit">Kirim Saran</button>
    </form>

    <h2>Lihat Status Saran</h2>
    <form action="lihat_status.php" method="GET">
        <label for="id_saran">ID Saran:</label>
        <input type="number" id="id_saran" name="id_saran" required />
        <button type="submit">Lihat Status Saran</button>
    </form>
</body>
</html>
