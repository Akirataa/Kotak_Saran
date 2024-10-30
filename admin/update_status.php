<?php
include '../db.php';

$id_saran = isset($_POST['id_saran']) ? intval($_POST['id_saran']) : 0;
$status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';

if ($id_saran > 0 && in_array($status, ['Dikirim', 'Diproses', 'Ditinjau', 'Selesai'])) {
    $query = "UPDATE saran SET status = '$status' WHERE id = $id_saran";
    
    if (mysqli_query($conn, $query)) {
        header('Location: admin_dashboard.php');
    } else {
        echo "Gagal memperbarui status: " . mysqli_error($conn);
    }
} else {
    echo "ID atau status tidak valid.";
}
?>
