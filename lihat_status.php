<?php
include 'db.php';

$id_saran = isset($_GET['id_saran']) ? intval($_GET['id_saran']) : 0;

$response = ['message' => '', 'type' => ''];

if ($id_saran > 0) {
    $query = "SELECT status FROM saran WHERE id = $id_saran";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $saran = mysqli_fetch_assoc($result);
        $response['message'] = "Status saran Anda: " . htmlspecialchars($saran['status']);
        $response['type'] = 'success';
    } else {
        $response['message'] = "Saran dengan ID tersebut tidak ditemukan.";
        $response['type'] = 'error';
    }
} else {
    $response['message'] = "ID saran tidak valid.";
    $response['type'] = 'error';
}

// Mengembalikan data sebagai JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
