<?php
include 'db.php';

$id_saran = isset($_GET['id_saran']) ? intval($_GET['id_saran']) : 0;
if ($id_saran > 0) {
    $query = "SELECT status FROM saran WHERE id = $id_saran";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $saran = mysqli_fetch_assoc($result);
        echo "Status saran Anda: " . htmlspecialchars($saran['status']);
    } else {
        echo "Saran dengan ID tersebut tidak ditemukan.";
    }
} else {
    echo "ID saran tidak valid.";
}
?>
