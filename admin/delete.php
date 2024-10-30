<?php
include '../db.php';

$id_saran = isset($_POST['id_saran']) ? intval($_POST['id_saran']) : 0;

if ($id_saran > 0) {
    $query = "DELETE FROM saran WHERE id = $id_saran";

    if (mysqli_query($conn, $query)) {
        header('Location: admin_dashboard.php');
    } else {
        echo "Gagal menghapus saran: " . mysqli_error($conn);
    }
} else {
    echo "ID saran tidak valid.";
}
?>
